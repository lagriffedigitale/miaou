<?php
require_once(__DIR__ . '/vendor/autoload.php');

require_once(__DIR__ . '/config/constants.config.php');

// theme initialisation 
new Miaou\Theme\Services\ThemeInitialisation();

// enqueue assets
new Miaou\Theme\Services\EnqueueAssets();

// custom post types 
new Miaou\WordPress\Services\RegisterCustomPostTypes();

// gutenberg features
new Miaou\Gutenberg\Services\Pattern();
new Miaou\Gutenberg\Services\RenderBlock();


function get_picture_datas(int $attachment_id) : array 
{
    return Miaou\Theme\Services\Attachment::getAttachmentDatas($attachment_id);
}