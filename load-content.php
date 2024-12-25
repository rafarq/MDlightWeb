<?php
require_once 'lib/Parsedown.php';
require_once 'src/FileSystem.php';
require_once 'src/MarkdownParser.php';
require_once 'src/Config.php';

if (!isset($_GET['file'])) {
    http_response_code(400);
    exit('File parameter is required');
}

try {
    $config = new Config();
    $markdownParser = new MarkdownParser();
    
    // Obtener y validar la ruta del archivo
    $filePath = $config->getDocsPath() . '/' . urldecode($_GET['file']);
    
    // Verificar que el archivo existe y está dentro del directorio docs
    $realPath = realpath($filePath);
    $docsPath = realpath($config->getDocsPath());
    
    if ($realPath === false || strpos($realPath, $docsPath) !== 0) {
        throw new Exception('Invalid file path');
    }
    
    // Leer y parsear el contenido
    $content = file_get_contents($realPath);
    if ($content === false) {
        throw new Exception('Could not read file');
    }
    
    // Establecer la ruta actual para el parser
    $markdownParser->setCurrentPath($realPath);
    
    // Devolver el contenido parseado
    echo "<article class='markdown-content'>";
    echo $markdownParser->parse($content);
    echo "</article>";
    
} catch (Exception $e) {
    http_response_code(404);
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>