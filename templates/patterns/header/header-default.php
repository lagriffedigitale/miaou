<?php
return array(
    'title'      => __('Header with site title, navigation.', LANG_DOMAIN),
    'categories' => array( 'miaou-header' ),
    'blockTypes' => array( 'core/template-part/header' ),
    'content'    => '
        <!-- wp:group {"align":"full"},"layout":{"inherit":true}} -->
        <div class="wp-block-group alignfull">
        <!-- wp:columns -->
        <div class="wp-block-columns">
            <!-- wp:column {"className":"wp-block-column-20"} -->
            <div class="wp-block-column wp-block-column-20">
        
            </div>
            <!-- /wp:column -->
            <!-- wp:column {"className":"wp-block-column-80"} -->
            <div class="wp-block-column wp-block-column-80">
        
            </div>
            <!-- /wp:column -->
        </div>
        <!-- /wp:columns -->
        </div>
        <!-- /wp:group -->
    ',
);
