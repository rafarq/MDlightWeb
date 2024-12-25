<?php
class Config {
    private $config;

    public function __construct() {
        $this->config = [
            'siteName' => 'Documentation',
            'docsPath' => 'md',
            'defaultLocale' => 'en'
        ];
    }

    public function getSiteName() {
        return $this->config['siteName'];
    }

    public function getDocsPath() {
        return $this->config['docsPath'];
    }

    public function getDefaultLocale() {
        return $this->config['defaultLocale'];
    }
}