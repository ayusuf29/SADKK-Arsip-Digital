<?php
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

// Simple redirect to public folder if accessed directly
// This is a fallback for when Apache mod_rewrite is not working correctly in the root
if (file_exists(__DIR__.'/public/index.php')) {
    require __DIR__.'/public/index.php';
} else {
    header("HTTP/1.0 404 Not Found");
    echo "Public index not found.";
}
