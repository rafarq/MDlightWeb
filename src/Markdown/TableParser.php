<?php
require_once 'src/Markdown/InlineParserInterface.php';

class TableParser {
    private $headers = [];
    private $rows = [];
    private $alignments = [];
    private $inTable = false;
    private $inlineParser;

    public function __construct(InlineParserInterface $inlineParser) {
        $this->inlineParser = $inlineParser;
    }

    public function isTableRow($line) {
        return preg_match('/^\|?.+\|.+$/', $line);
    }

    public function isAlignmentRow($line) {
        return preg_match('/^\|?\s*(:?-+:?\|)+\s*$/', $line);
    }

    public function parseAlignments($line) {
        preg_match_all('/(:?-+:?)\|?/', $line, $matches);
        foreach ($matches[1] as $alignment) {
            if ($alignment[0] === ':' && substr($alignment, -1) === ':') {
                $this->alignments[] = 'center';
            } elseif ($alignment[0] === ':') {
                $this->alignments[] = 'left';
            } elseif (substr($alignment, -1) === ':') {
                $this->alignments[] = 'right';
            } else {
                $this->alignments[] = '';
            }
        }
    }

    public function parseCells($line) {
        return array_map('trim', explode('|', trim($line, '| ')));
    }

    public function startTable($cells) {
        $this->inTable = true;
        $this->headers = $cells;
    }

    public function addRow($cells) {
        $this->rows[] = $cells;
    }

    public function isInTable() {
        return $this->inTable;
    }

    public function reset() {
        $this->headers = [];
        $this->rows = [];
        $this->alignments = [];
        $this->inTable = false;
    }

    public function render() {
        $table = '<table class="markdown-table">';
        
        // Add header with bold text
        $table .= '<thead><tr>';
        foreach ($this->headers as $i => $header) {
            $align = isset($this->alignments[$i]) ? ' style="text-align: ' . $this->alignments[$i] . '"' : '';
            $table .= "<th{$align}><strong>" . $this->inlineParser->parseInline($header) . '</strong></th>';
        }
        $table .= '</tr></thead>';
        
        // Add rows
        if (!empty($this->rows)) {
            $table .= '<tbody>';
            foreach ($this->rows as $row) {
                $table .= '<tr>';
                foreach ($row as $i => $cell) {
                    $align = isset($this->alignments[$i]) ? ' style="text-align: ' . $this->alignments[$i] . '"' : '';
                    $table .= "<td{$align}>" . $this->inlineParser->parseInline($cell) . '</td>';
                }
                $table .= '</tr>';
            }
            $table .= '</tbody>';
        }
        
        $table .= '</table>';
        return $table;
    }
}