<?php
require_once 'Markdown/PathManager.php';
require_once 'Markdown/BlockquoteParser.php';

class MarkdownParser {
    private $parsedown;
    private $pathManager;
    private $blockquoteParser;
    
    public function __construct() {
        $this->parsedown = new Parsedown();
        $this->pathManager = new PathManager();
        $this->blockquoteParser = new BlockquoteParser();
    }
    
    public function setCurrentPath($path) {
        $this->pathManager->setCurrentPath($path);
    }
    
    public function parse($content) {
        if (!$content) {
            return '';
        }
        
        $content = $this->parseImages($content);
        $content = $this->parseLinks($content);
        $content = $this->parseCodeBlocks($content);
        $content = $this->blockquoteParser->parse($content);
        
        return $this->parsedown->text($content);
    }
    
    public function getTitle($content) {
        if (!$content) {
            return null;
        }
        if (preg_match('/^#\s+(.+)$/m', $content, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    protected function parseImages($content) {
        return preg_replace_callback(
            '/!\[(.*?)\]\((.*?)(\s+"(.*?)")?\)/',
            function($matches) {
                $alt = $matches[1];
                $url = $this->pathManager->resolveRelativePath($matches[2]);
                $title = isset($matches[4]) ? ' title="' . htmlspecialchars($matches[4]) . '"' : '';
                
                return sprintf(
                    '<figure>' .
                    '<img src="%s" alt="%s"%s class="markdown-image">' .
                    ($alt ? '<figcaption>%s</figcaption>' : '') .
                    '</figure>',
                    htmlspecialchars($url),
                    htmlspecialchars($alt),
                    $title,
                    htmlspecialchars($alt)
                );
            },
            $content
        );
    }

    protected function parseLinks($content) {
        return preg_replace_callback(
            '/(?<!!)\[(.*?)\]\((.*?)(\s+"(.*?)")?\)/',
            function($matches) {
                $text = $matches[1];
                $url = $this->pathManager->resolveRelativePath($matches[2]);
                $title = isset($matches[4]) ? ' title="' . htmlspecialchars($matches[4]) . '"' : '';
                
                return sprintf(
                    '<a href="%s"%s target="_blank" rel="noopener noreferrer">%s</a>',
                    htmlspecialchars($url),
                    $title,
                    htmlspecialchars($text)
                );
            },
            $content
        );
    }

    protected function parseCodeBlocks($content) {
        return preg_replace_callback(
            '/```(?:(\w+)\n)?(.*?)```/s',
            function($matches) {
                $language = isset($matches[1]) ? htmlspecialchars($matches[1]) : '';
                $code = htmlspecialchars(trim($matches[2]));
                
                return sprintf(
                    '<div class="code-block" data-language="%s">
                        <button class="copy-button" onclick="copyCode(this)">Copy</button>
                        <pre><code>%s</code></pre>
                    </div>',
                    $language,
                    $code
                );
            },
            $content
        );
    }
}