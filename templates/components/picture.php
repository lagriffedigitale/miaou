<picture>
    <?php if (!empty($args['srcset'])) : ?>
        <?php foreach ($args['srcset'] as $srcset) : ?>
            <source media="<?php print $srcset['rule']; ?>" data-srcset="<?php print $args['picture']['sizes'][$srcset['size']]; ?>" type="<?php print $args['picture']['mime_type']; ?>">
            <?php if (!empty($args['picture']['sizes'][$srcset['size'] . '-webp'])) : ?>
                <source media="<?php print $srcset['rule']; ?>" data-srcset="<?php print $args['picture']['sizes'][$srcset['size'] . '-webp']; ?>" type="image/webp">
            <?php endif; ?>
        <?php endforeach; ?>
        <img data-src="<?php print $args['default']; ?>" alt="<?php (!empty($args['picture']['alt'])) ? print $args['picture']['alt'] : $args['picture']['title']; ?>" class="lazy" decoding="async">
    <?php endif; ?>
</picture>