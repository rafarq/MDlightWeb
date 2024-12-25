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
        
        // Get the directory of the current markdown file relative to the docs path
        $currentDir = dirname($this->currentPath);
        $relativeDir = str_replace($this->docsBasePath . DIRECTORY_SEPARATOR, '', $currentDir);
        
        // Construct the full server path to check if file exists
        $fullPath = $currentDir . DIRECTORY_SEPARATOR . $path;
        
        // If the file exists relative to current directory, use that path
        if (file_exists($fullPath)) {
            // Return path relative to web root, maintaining the directory structure
            return 'md/' . $relativeDir . '/' . $path;
        }
        
        // If file doesn't exist in current directory, try base docs path
        $baseFullPath = $this->docsBasePath . DIRECTORY_SEPARATOR . $path;
        if (file_exists($baseFullPath)) {
            return 'md/' . $path;
        }
        
        // If file not found anywhere, return relative to current directory
        // This maintains the expected structure even if file is missing
        return 'md/' . $relativeDir . '/' . $path;
    }
}