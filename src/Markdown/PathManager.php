<?php
class PathManager {
    private $currentPath = '';
    private $docsBasePath = '';
    
    public function __construct($docsBasePath = 'md') {
        $this->docsBasePath = realpath($docsBasePath);
    }
    
    public function setCurrentPath($path) {
        $this->currentPath = $path;
    }
    
    public function getCurrentPath() {
        return $this->currentPath;
    }
    
    public function getDocsBasePath() {
        return $this->docsBasePath;
    }
    
    public function resolveRelativePath($path) {
        // Return as-is if it's an absolute URL
        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }
        
        // For images and other assets, just prepend 'md/'
        if (preg_match('/\.(png|jpe?g|gif|svg|webp)$/i', $path)) {
            return 'md/' . $path;
        }
        
        // For markdown files and other links
        $relativePath = str_replace($this->docsBasePath . DIRECTORY_SEPARATOR, '', dirname($this->currentPath));
        $relativePath = preg_replace('/^md\//', '', $relativePath);
        
        if ($relativePath && $relativePath !== '.') {
            return 'md/' . $relativePath . '/' . $path;
        }
        
        return 'md/' . $path;
    }
}