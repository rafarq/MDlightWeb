<?php
class BlockquoteParser {
    public function parse($content) {
        return preg_replace_callback(
            '/^>\s*(.+)$/m',
            function($matches) {
                return "<blockquote>" . trim($matches[1]) . "</blockquote>";
            },
            $content
        );
    }
}