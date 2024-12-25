<?php
class NavigationBuilder {
    private $markdownParser;
    
    public function __construct($markdownParser) {
        $this->markdownParser = $markdownParser;
    }
    
    public function buildNavigation($structure, $prefix = '') {
        $html = '<ul class="nav-list">';
        
        // Add home link only at root level
        if ($prefix === '') {
            $html .= $this->renderHomeLink();
        }
        
        // Render sections (folders)
        if (!empty($structure['sections'])) {
            $html .= $this->renderSections($structure['sections'], $prefix);
        }
        
        // Render files (only if not in root)
        if (!empty($structure['files']) && $prefix !== '') {
            $html .= $this->renderFiles($structure['files'], $prefix);
        }
        
        $html .= '</ul>';
        return $html;
    }
    
    private function renderHomeLink() {
        return '<li class="file home-link">' .
               '<a href="#index.md">Principal</a>' .
               '</li>';
    }
    
    private function renderSections($sections, $prefix) {
        $html = '';
        foreach ($sections as $name => $content) {
            $html .= '<li class="section">';
            $html .= '<div class="section-title collapsed">' . htmlspecialchars($name) . '</div>';
            $html .= '<div class="section-content collapsed">';
            $html .= $this->buildNavigation($content, "$prefix$name/");
            $html .= '</div>';
            $html .= '</li>';
        }
        return $html;
    }
    
    private function renderFiles($files, $prefix) {
        $html = '';
        foreach ($files as $file) {
            $this->markdownParser->setCurrentPath($file['path']);
            $title = $this->markdownParser->getTitle($file['content']) ?? pathinfo($file['name'], PATHINFO_FILENAME);
            $id = urlencode($prefix . $file['name']);
            $html .= '<li class="file">';
            $html .= '<a href="#' . $id . '">' . htmlspecialchars($title) . '</a>';
            $html .= '</li>';
        }
        return $html;
    }
}