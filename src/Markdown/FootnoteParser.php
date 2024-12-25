<?php
class FootnoteParser {
    private $footnotes = [];
    private $inlineParser;

    public function __construct(InlineParserInterface $inlineParser) {
        $this->inlineParser = $inlineParser;
    }

    public function collectFootnotes($lines) {
        $this->footnotes = [];
        foreach ($lines as $line) {
            if (preg_match('/^\[\^(\w+)\]:\s*(.+)$/', $line, $matches)) {
                $this->footnotes[$matches[1]] = $matches[2];
            }
        }
    }

    public function parseFootnoteReferences($text) {
        return preg_replace_callback(
            '/\[\^(\w+)\]/',
            function($matches) {
                $id = htmlspecialchars($matches[1]);
                return sprintf(
                    '<sup class="footnote-ref"><a href="#fn-%s" id="fnref-%s">[%s]</a></sup>',
                    $id,
                    $id,
                    $id
                );
            },
            $text
        );
    }

    public function renderFootnotes() {
        if (empty($this->footnotes)) {
            return '';
        }

        $html = '<div class="footnotes"><hr><ol>';
        foreach ($this->footnotes as $id => $text) {
            $html .= sprintf(
                '<li id="fn-%s">%s <a href="#fnref-%s" class="footnote-backref">↩</a></li>',
                htmlspecialchars($id),
                $this->inlineParser->parseInline($text),
                htmlspecialchars($id)
            );
        }
        $html .= '</ol></div>';
        return $html;
    }

    public function reset() {
        $this->footnotes = [];
    }
}