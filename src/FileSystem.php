<?php
class FileSystem {
    public function readMarkdownDirectory($dir, $isRoot = true) {
        if (!is_dir($dir)) {
            throw new Exception("Directory not found: $dir");
        }

        $structure = [
            'sections' => [],
            'files' => [],
            'index' => null
        ];
        
        $items = @scandir($dir);
        if ($items === false) {
            throw new Exception("Cannot read directory: $dir");
        }
        
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') continue;
            
            $fullPath = $dir . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($fullPath)) {
                $structure['sections'][$item] = $this->readMarkdownDirectory($fullPath, false);
            } elseif (is_file($fullPath) && pathinfo($item, PATHINFO_EXTENSION) === 'md') {
                $content = @file_get_contents($fullPath);
                if ($content === false) {
                    throw new Exception("Cannot read file: $fullPath");
                }
                
                if ($isRoot && (strtolower($item) === 'index.md' || strtolower($item) === 'readme.md')) {
                    $structure['index'] = [
                        'name' => $item,
                        'path' => $fullPath,
                        'content' => $content
                    ];
                } else {
                    $structure['files'][] = [
                        'name' => $item,
                        'path' => $fullPath,
                        'content' => $content
                    ];
                }
            }
        }
        
        return $structure;
    }
}