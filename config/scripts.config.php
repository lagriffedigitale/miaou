<?php 
apply_filters('miaou_script_list', [
    [
        'handle' => 'miaou-app',
        'path' => JS_DIR . '/app.js',
        'dependencies' => [],
        'version' => '0.1.0',
        'in_footer' => true,
        'defer' => false
    ]
]);