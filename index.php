<?php
require_once 'lib/Parsedown.php';
require_once 'src/FileSystem.php';
require_once 'src/MarkdownParser.php';
require_once 'src/Renderer.php';
require_once 'src/Config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $config = new Config();
    $fileSystem = new FileSystem();
    $markdownParser = new MarkdownParser();
    $renderer = new Renderer($markdownParser);

    $structure = $fileSystem->readMarkdownDirectory($config->getDocsPath());
    
    if (isset($structure['index'])) {
        $markdownParser->setCurrentPath($structure['index']['path']);
    }
} catch (Exception $e) {
    die('Error: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config->getSiteName()); ?></title>
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <nav class="sidebar">
            <h1>Navegación</h1>
            <?php echo $renderer->renderNavigation($structure); ?>
        </nav>
        <main class="content" id="main-content">
            <?php 
            if (isset($structure['index'])) {
                echo "<article class='markdown-content'>";
                echo $markdownParser->parse($structure['index']['content']);
                echo "</article>";
            }
            ?>
        </main>
    </div>
    <script type="module">
        import { initializeTheme } from './js/theme.js';
        document.addEventListener('DOMContentLoaded', initializeTheme);
    </script>
    <script type="module" src="js/navigation.js"></script>
</body>
</html>