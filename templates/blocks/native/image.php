<figure class="wp-block-image<?php print (!empty($args['className'])) ? ' ' . $args['className'] : ''; ?>">

    <?php if (!empty($args['image_link'])) : ?>
        <a <?php print $args['image_link']; ?>>
    <?php endif; ?>

    <?php 

    $picture_datas = get_picture_datas($args['id']);
    get_template_part('templates/components/picture', null, [
        'picture' => $picture_datas,
        'srcset' => [
            ['rule' => '(max-width : 640px)', 'size' => 'miaou_small'],
            ['rule' => '(max-width : 960px)', 'size' => 'miaou_medium']
        ],
        'default' => $picture_datas['sizes']['miaou_large'],
    ]); 
    ?>

    <?php if (!empty($args['image_link'])) : ?>
        </a>
    <?php endif; ?>

    <?php 
    if (!empty($args['figcaption'])) :
        print $args['figcaption'];
    endif; 
    ?>
</figure>