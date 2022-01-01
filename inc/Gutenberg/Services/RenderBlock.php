<?php 
namespace Miaou\Gutenberg\Services;

class RenderBlock 
{
    public function __construct()
    {
        add_filter('render_block', [$this, 'overrideCoreImage'], 1, 2);
    }

    public function overrideCoreImage(string $blockContent, array $block) : string
    {
        if ('core/image' != $block['blockName']) {
            return $blockContent;
        }

        $figcaption = $imageLink = '';

        // extract figcaption
        preg_match('/<figcaption>(.*?)<\/figcaption>/s', $blockContent, $figcaptionMatch);
        $figcaption = (!empty($figcaptionMatch[0])) ? $figcaptionMatch[0] : '';
        
        // extract image link 
        if (!empty($block['attrs']['linkDestination'])) {
            preg_match('/<a (.*?)\>(.*?)<\/a>/s', $blockContent, $imageLinkMatch);
            $imageLink = (!empty($imageLinkMatch[0])) ? $imageLinkMatch[1] : '';
        }

        $templateArgs = array_merge($block['attrs'], ['figcaption' => $figcaption, 'image_link' => $imageLink]);
        
        ob_start();
        get_template_part('templates/blocks/native/image', null, $templateArgs);
        $blockContent = ob_get_contents();
        ob_end_clean();

        return $blockContent;
    }
}