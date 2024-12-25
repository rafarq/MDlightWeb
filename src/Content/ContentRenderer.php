<?php
class ContentRenderer {
    private $markdownParser;
    
    public function __construct($markdownParser) {
        $this->markdownParser = $markdownParser;
    }
    
    public function renderContent($structure) {
        if (!isset($structure['index'])) {
            return '';
        }
        
        $this->markdownParser->setCurrentPath($structure['index']['path']);
        return "<article class='markdown-content'>" .
               $this->markdownParser->parse($structure['index']['content']) .
               "</article>";
    }
}