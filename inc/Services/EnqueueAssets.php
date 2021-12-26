<?php
namespace Miaou\Services;

class EnqueueAssets
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts'], 100);
        add_action('wp_enqueue_scripts', [$this, 'enqueueStylesheets'], 110);

        add_action('wp_enqueue_scripts', [$this, 'addInlineScripts'], 120);

        add_action('wp_enqueue_scripts', [$this, 'dequeueScripts'], 130);
        add_action('wp_enqueue_scripts', [$this, 'dequeueStyles'], 140);
    }

    public function enqueueScripts() : void
    {
        $scriptFiles = require CONFIG_DIR . '/scripts.config.php';

        if (!empty($scriptFiles)) {
            foreach ($scriptFiles as $scriptFile) {
                wp_enqueue_script(
                    $scriptFile['handle'],
                    $scriptFile['path'],
                    (!empty($scriptFile['dependencies']) && is_array($scriptFile['dependencies'])) ? $scriptFile['dependencies'] : [],
                    (!empty($scriptFile['version'])) ? $scriptFile['version'] : null,
                    (!empty($scriptFile['in_footer'])) ? $scriptFile['in_footer'] : false
                );
            }
        }
    }

    public function enqueueStylesheets() : void
    {
        $stylesheetFiles = require CONFIG_DIR . '/stylesheets.config.php';

        if (!empty($stylesheetFiles)) {
            foreach ($stylesheetFiles as $stylesheetFile) {
                wp_register_style(
                    $stylesheetFile['handle'],
                    $stylesheetFile['path'],
                    (!empty($stylesheetFile['dependencies'])) ? $stylesheetFile['dependencies'] : [],
                    (!empty($stylesheetFile['version'])) ? $stylesheetFile['version'] : '',
                    (!empty($stylesheetFile['media'])) ? $stylesheetFile['media'] : 'all'
                );
                
                wp_enqueue_style($stylesheetFile['handle']);
            }
        }
    }

    public function addInlineScripts() : void 
    {
        $scriptFiles = require CONFIG_DIR . '/scripts.config.php';
        $inlineScripts = require CONFIG_DIR . '/inline-scripts.config.php';

        if (!empty($scriptFiles[0]['handle']) && !empty($inlineScripts)) {
            wp_add_inline_script(
                $scriptFiles[0]['handle'], 
                $inlineScripts, 
                'before'
            );
        }
    }

    public function dequeueScripts() : void 
    {
        wp_deregister_script('wp-embed');
    }

    public function dequeueStyles() : void
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');
    }
}
