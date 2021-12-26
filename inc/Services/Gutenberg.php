<?php 
namespace Miaou\Services; 

class Gutenberg 
{
    public function __construct()
    {
        // init gutenberg's features theme support
        add_action('after_theme_setup', [$this, 'initGutenbergThemeSupport'], 120);
    }

    public function initGutenbergThemeSupport() : void 
    {
        // disable native patterns
        remove_theme_support('core-block-patterns');
        
        // add align-wide support
        add_theme_support('align-wide');
    }
}