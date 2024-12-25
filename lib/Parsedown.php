<?php
require_once 'src/Markdown/TableParser.php';
require_once 'src/Markdown/FootnoteParser.php';
require_once 'src/Markdown/InlineParserInterface.php';

class Parsedown implements InlineParserInterface
{
    const version = '1.7.4';
    
    protected $DefinitionData = [];
    protected $tableParser;
    protected $footnoteParser;
    
    public function __construct() {
        $this->tableParser = new TableParser($this);
        $this->footnoteParser = new FootnoteParser($this);
    }
    
    public function text($text)
    {
        # standardize line breaks
        $text = str_replace(array("\r\n", "\r"), "\n", $text);

        # remove surrounding line breaks
        $text = trim($text, "\n");

        # split text into lines
        $lines = explode("\n", $text);

        # collect footnotes
        $this->footnoteParser->collectFootnotes($lines);

        # convert lines into html
        $text = $this->linesElements($lines);

        # add footnotes section
        $text .= $this->footnoteParser->renderFootnotes();

        # remove trailing line breaks
        $text = trim($text, "\n");

        return $text;
    }

    public function parseInline($text)
    {
        # Strikethrough (must come before bold/italic to avoid conflicts)
        $text = preg_replace('/~~(.*?)~~/', '<del>$1</del>', $text);

        # Bold
        $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
        $text = preg_replace('/__(.*?)__/', '<strong>$1</strong>', $text);

        # Italic
        $text = preg_replace('/\*(.*?)\*/', '<em>$1</em>', $text);
        $text = preg_replace('/_(.*?)_/', '<em>$1</em>', $text);

        # Code
        $text = preg_replace('/`(.*?)`/', '<code>$1</code>', $text);

        # Footnotes
        $text = $this->footnoteParser->parseFootnoteReferences($text);

        return $text;
    }

    protected function linesElements($lines)
    {
        $Elements = array();
        $CurrentBlock = null;
        $inList = false;
        $listItems = array();

        foreach ($lines as $line)
        {
            // Skip footnote definitions as they're handled separately
            if (preg_match('/^\[\^(\w+)\]:\s*(.+)$/', $line)) {
                continue;
            }

            // Handle horizontal rule
            if (preg_match('/^[-*_]{3,}\s*$/', $line)) {
                $Elements[] = array(
                    'name' => 'hr',
                    'text' => '',
                    'handler' => 'line',
                );
                continue;
            }

            // Handle table separator row
            if ($this->tableParser->isInTable() && $this->tableParser->isAlignmentRow($line)) {
                $this->tableParser->parseAlignments($line);
                continue;
            }

            // Handle table rows
            if ($this->tableParser->isTableRow($line)) {
                $cells = $this->tableParser->parseCells($line);
                
                if (!$this->tableParser->isInTable()) {
                    $this->tableParser->startTable($cells);
                } else {
                    $this->tableParser->addRow($cells);
                }
                continue;
            } else if ($this->tableParser->isInTable()) {
                // End of table
                $Elements[] = array(
                    'name' => 'raw',
                    'text' => $this->tableParser->render(),
                    'handler' => 'line',
                );
                
                $this->tableParser->reset();
            }

            if (chop($line) === '')
            {
                if ($inList) {
                    $Elements[] = array(
                        'name' => 'ul',
                        'elements' => $listItems
                    );
                    $listItems = array();
                    $inList = false;
                }

                if (isset($CurrentBlock))
                {
                    $CurrentBlock['interrupted'] = true;
                }

                continue;
            }

            # Markdown headers
            if (preg_match('/^(#{1,6})[ ]*(.+?)[ ]*#*$/', $line, $matches))
            {
                if ($inList) {
                    $Elements[] = array(
                        'name' => 'ul',
                        'elements' => $listItems
                    );
                    $listItems = array();
                    $inList = false;
                }

                $level = strlen($matches[1]);
                
                $Elements[] = array(
                    'name' => 'h' . $level,
                    'text' => $this->parseInline($matches[2]),
                    'handler' => 'line',
                );

                continue;
            }

            # Lists
            if (preg_match('/^[\*\-\+]\s+(.+)$/', $line, $matches))
            {
                $inList = true;
                $listItems[] = array(
                    'name' => 'li',
                    'text' => $this->parseInline($matches[1]),
                    'handler' => 'line',
                );
                continue;
            }

            # Numbered Lists
            if (preg_match('/^\d+\.\s+(.+)$/', $line, $matches))
            {
                $inList = true;
                $listItems[] = array(
                    'name' => 'li',
                    'text' => $this->parseInline($matches[1]),
                    'handler' => 'line',
                );
                continue;
            }

            if ($inList) {
                $Elements[] = array(
                    'name' => 'ul',
                    'elements' => $listItems
                );
                $listItems = array();
                $inList = false;
            }

            # Paragraph
            $Elements[] = array(
                'name' => 'p',
                'text' => $this->parseInline($line),
                'handler' => 'line',
            );
        }

        if ($inList) {
            $Elements[] = array(
                'name' => 'ul',
                'elements' => $listItems
            );
        }

        # Format elements to HTML
        $markup = '';

        foreach ($Elements as $Element)
        {
            if ($Element['name'] === 'p' && empty($Element['text']))
            {
                continue;
            }

            if ($Element['name'] === 'raw') {
                $markup .= $Element['text'] . "\n";
                continue;
            }

            $markup .= '<'.$Element['name'].'>';

            if (isset($Element['elements'])) {
                foreach ($Element['elements'] as $item) {
                    $markup .= '<'.$item['name'].'>';
                    $markup .= $item['text'];
                    $markup .= '</'.$item['name'].'>';
                }
            } else if (isset($Element['text'])) {
                $markup .= $Element['text'];
            }

            if ($Element['name'] !== 'hr') {
                $markup .= '</'.$Element['name'].'>';
            }
            $markup .= "\n";
        }

        return $markup;
    }
}