<?php 
namespace Miaou\Services;

class RegisterCustomPostTypes 
{
    public function __construct() 
    {
        add_action('init', [$this, 'execute']);
    }

    public function execute() : void 
    {
        $customPostTypes = require CONFIG_DIR . '/custom-post-types.config.php';

        if (!empty($customPostTypes)) {
            foreach ($customPostTypes as $customPostTypeId => $customPostType) {
                register_post_type(
                    $customPostTypeId, 
                    array_replace(
                        self::getDefaultCPTArgs($customPostType['singular_name'], $customPostType['plural_name']), 
                        $customPostType['args']
                    )
                );

                // register taxonomies 
                if (!empty($customPostType['taxonomies'])) {
                    foreach ($customPostType['taxonomies'] as $taxonomyId => $taxonomy) {
                        register_taxonomy(
                            $taxonomyId, 
                            $customPostTypeId, 
                            array_replace(
                                self::getDefaultTaxonomyArgs($taxonomy['singular_name'], $taxonomy['plural_name']), 
                                $taxonomy['args']
                            )
                        );
                    }
                }
            }
        }
    }

    public static function getDefaultCPTArgs(string $postTypeSingularLabel, string $postTypePluralLabel) : array
    {
        return [
            'labels'    => [
                'name'                  => __(ucfirst($postTypeSingularLabel), 'post type general name', LANG_DOMAIN),
                'singular_name'         => __(ucfirst($postTypeSingularLabel), 'post type singular name', LANG_DOMAIN),
                'menu_name'             => __(ucfirst($postTypePluralLabel), 'admin menu', LANG_DOMAIN),
                'name_admin_bar'        => __(ucfirst($postTypeSingularLabel), 'admin menu', LANG_DOMAIN),
                'add_new'               => __('Add new', LANG_DOMAIN),
                'add_new_item'          => sprintf(__('Add new %s', LANG_DOMAIN), $postTypeSingularLabel),
                'new_item'              => sprintf(__('New %s', LANG_DOMAIN), $postTypeSingularLabel),
                'edit_item'             => sprintf(__('Edit %s', LANG_DOMAIN), $postTypeSingularLabel),
                'view_item'             => sprintf(__('View %s', LANG_DOMAIN), $postTypeSingularLabel),
                'view_items'            => sprintf(__('View %s', LANG_DOMAIN), $postTypePluralLabel),
                'all_items'             => sprintf(__('All %s', LANG_DOMAIN), $postTypePluralLabel),
                'search_items'          => sprintf(__('Search %s', LANG_DOMAIN), $postTypeSingularLabel),
                'parent_item_colon'     => sprintf(__('Parent %s', LANG_DOMAIN), $postTypeSingularLabel),
                'not_found'             => sprintf(__('No %s found', LANG_DOMAIN), $postTypeSingularLabel),
                'not_found_in_trash'    => sprintf(__('No %s found in trash', LANG_DOMAIN), $postTypeSingularLabel)
            ],
            'description'           =>  sprintf(__('%s post type', LANG_DOMAIN), ucfirst($postTypeSingularLabel)),
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => ['rewrite' => $postTypeSingularLabel],
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => true,
            'menu_position'         => null,
            'supports'              => ['title', 'editor', 'thumbnail', 'excerpt'],
        ];
    }

    public static function getDefaultTaxonomyArgs(string $taxonomySingularLabel, string $taxonomyPluralLabel) : array
    {
        return [
            'labels'        => [
                'name'                  => __(ucfirst($taxonomyPluralLabel), 'taxonomy general name', LANG_DOMAIN),
                'singular_name'         => __(ucfirst($taxonomySingularLabel), 'taxonomy singular name', LANG_DOMAIN),
                'search_items'          => sprintf(__('Search %s', LANG_DOMAIN), $taxonomyPluralLabel),
                'all_items'             => sprintf(__('All %s', LANG_DOMAIN), $taxonomyPluralLabel),
                'parent_item'           => sprintf(__('Parent %s', LANG_DOMAIN), $taxonomySingularLabel),
                'parent_item_colon'     => sprintf(__('Parent %s', LANG_DOMAIN), $taxonomySingularLabel),
                'edit_item'             => sprintf(__('Edit %s', LANG_DOMAIN), $taxonomySingularLabel),
                'update_item'           => sprintf(__('Update %s', LANG_DOMAIN), $taxonomySingularLabel),
                'add_new_item'          => sprintf(__('Add new %s', LANG_DOMAIN), $taxonomySingularLabel),
                'new_item_name'         => sprintf(__('New %s', LANG_DOMAIN), $taxonomySingularLabel),
                'menu_name'             => __(ucfirst($taxonomyPluralLabel), LANG_DOMAIN)
            ],
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => $taxonomyPluralLabel]
        ];
    }
}