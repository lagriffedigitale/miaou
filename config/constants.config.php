<?php 
define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

define('CONFIG_DIR', THEME_PATH . '/config');

define('ASSETS_DIR', THEME_URL . '/dist');
define('ASSETS_PATH', THEME_PATH . '/dist');

define('JS_DIR', ASSETS_DIR . '/js');
define('CSS_DIR', ASSETS_DIR . '/css');
define('FONTS_DIR', ASSETS_DIR . '/fonts');
define('IMG_DIR', ASSETS_DIR . '/images');
define('IMG_PATH', ASSETS_PATH . '/images');

define('LANG_DOMAIN', 'miaou');

define('ACF_FIELDS_DIR', THEME_PATH . '/acf-fields');
