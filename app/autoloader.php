<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

function autoloader( $class ) {
    $file = get_theme_file_path() .DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'class'.DIRECTORY_SEPARATOR.$class.'.php';
    if ( file_exists( $file ) ) {
        require_once $file;
    }
}
spl_autoload_register('autoloader' );