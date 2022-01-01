<?php
namespace Miaou\Theme\Services;

class ThemeInitialisation
{
    public function __construct()
    {
        // disable comments features
        add_action('init', [$this, 'disableCommentsFromAdminBar']);
        add_action('admin_init', [$this, 'disableCommentsFeatures']);
        add_action('admin_menu', [$this, 'disableCommentsEditionAdminMenu']);
        add_filter('comments_open', '__return_false', 10, 2);
        add_filter('pings_open', '__return_false', 10, 2);
        add_filter('comments_array', '__return_empty_array', 10, 2);

        // allow mime-types
        add_filter('upload_mimes', [$this, 'allowedMimeTypes']);

        // load i18n - theme textdomain 
        add_action('after_setup_theme', [$this, 'loadThemeTextDomain'], 100);

        // theme support 
        add_action('after_setup_theme', [$this, 'initThemeSupport'], 110);

        // register menus 
        add_action('after_setup_theme', [$this, 'registerNavMenus'], 115);

        // register custom image sizes
        add_action('after_setup_theme', [$this, 'registerCustomImageSizes'], 120);
    }

    public function disableCommentsFromAdminBar() : void
    {
        // disable comments from admin-bar
        if (is_admin_bar_showing()) {
            remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
        }
    }

    public function disableCommentsFeatures() : void
    {
        global $pagenow;

        if ($pagenow === 'edit-comments.php') {
            wp_redirect(admin_url());
            exit;
        }

        // Remove comments metabox from dashboard
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

        // Disable support for comments and trackbacks in post types
        foreach (get_post_types() as $post_type) {
            if (post_type_supports($post_type, 'comments')) {
                remove_post_type_support($post_type, 'comments');
                remove_post_type_support($post_type, 'trackbacks');
            }
        }
    }

    public function disableCommentsEditionAdminMenu() : void
    {
        remove_menu_page('edit-comments.php');
    }

    public function allowedMimeTypes(array $mimeTypes) : array
    {
        $miaouMimeTypes = require CONFIG_DIR . '/mime-types.config.php';
        return array_merge($mimeTypes, $miaouMimeTypes);
    }

    public function loadThemeTextDomain() : void
    {
        load_theme_textdomain(LANG_DOMAIN, THEME_PATH . '/languages');
    }

    public function initThemeSupport() : void 
    {
        add_theme_support('title-tag');
        add_theme_support('post-formats', []);
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
        add_theme_support('woocommerce');

        add_theme_support('align-wide');
        
        // remove emoji support 
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    public function registerNavMenus() : void 
    {
        $navMenus = require CONFIG_DIR . '/menus.config.php';

        if (!empty($navMenus)) {
            register_nav_menus($navMenus);
        }
    }

    public function registerCustomImageSizes() : void 
    {
        $imageSizes = require CONFIG_DIR . '/image-sizes.config.php';
        
        if (!empty($imageSizes)) {
            foreach ($imageSizes as $imageSize) {
                if (empty($imageSize['image_id'])) {
                    continue;
                }
                    
                add_image_size(
                    $imageSize['image_id'],
                    $imageSize['width'],
                    $imageSize['height'],
                    (!empty($imageSize['crop'])) ? $imageSize['crop'] : false
                );
            }
        }
    }
}
