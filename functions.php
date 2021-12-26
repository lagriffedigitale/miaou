<?php
require_once(__DIR__ . '/vendor/autoload.php');

require_once(__DIR__ . '/config/constants.config.php');

// theme initialisation 
new Miaou\Services\ThemeInitialisation();

// gutenberg features
new Miaou\Services\Gutenberg();

// enqueue assets
new Miaou\Services\EnqueueAssets();

// custom post types 

// acf features  