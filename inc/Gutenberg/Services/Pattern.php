<?php 
namespace Miaou\Gutenberg\Services;

class Pattern 
{
    public function __construct()
    {
        add_action('after_setup_theme', [$this, 'removeGutenbergNativePatterns'], 120);
        add_action('init', [$this, 'registerPatterns']);
    }

    public function removeGutenbergNativePatterns() : void 
    {
        remove_theme_support('core-block-patterns');
    }

    public function registerPatterns() : void 
    {
        // register patterns categories type
        if (function_exists('register_block_pattern_category_type')) {
            register_block_pattern_category_type(
                'miaou',
                ['label' => __('Miaou theme\'s patterns', LANG_DOMAIN)]
            );
        }

        // pattern categories
        $patternCategories = require CONFIG_DIR . '/pattern-categories.config.php';
        if (!empty($patternCategories)) {
            foreach ($patternCategories as $patternCategoryId => $patternCategory) {
                register_block_pattern_category($patternCategoryId, $patternCategory);
            }
        }

        // patterns
        $patterns = require CONFIG_DIR . '/patterns.config.php';
        foreach ($patterns as $pattern) {
            register_block_pattern(
                'miaou/' . $pattern,
                require get_theme_file_path('/templates/patterns/' . $pattern . '.php')
            );
        }
    }
}