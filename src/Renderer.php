<?php
require_once 'Navigation/NavigationBuilder.php';
require_once 'Content/ContentRenderer.php';

class Renderer {
    private $navigationBuilder;
    private $contentRenderer;
    
    public function __construct($markdownParser) {
        $this->navigationBuilder = new NavigationBuilder($markdownParser);
        $this->contentRenderer = new ContentRenderer($markdownParser);
    }
    
    public function renderNavigation($structure, $prefix = '') {
        return $this->navigationBuilder->buildNavigation($structure, $prefix);
    }
    
    public function renderContent($structure, $prefix = '') {
        return $this->contentRenderer->renderContent($structure);
    }
}