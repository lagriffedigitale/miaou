<?php
namespace Miaou\Theme\Services;

class Attachment
{
    public static function getAttachmentDatas(int $attachmentId) : array
    {
        $response = [];

        $storedDatas = get_transient('miaou_attachment_datas_' . $attachmentId);
        if (false !== $storedDatas) {
            return $storedDatas;
        }

        $attachment = get_post($attachmentId);
        if (empty($attachment)) {
            return $response;
        }
        if ($attachment->post_type !== 'attachment') {
            return $response;
        }

        $uploadDir = wp_upload_dir();
        $meta = wp_get_attachment_metadata($attachment->ID);
        $attachedFile = get_attached_file($attachment->ID);

        if (strpos($attachment->post_mime_type, '/') !== false) {
            list($type, $subtype) = explode('/', $attachment->post_mime_type);
        } else {
            list($type, $subtype) = array( $attachment->post_mime_type, '' );
        }

        // Generate response.
        $response = array(
            'ID'			=> $attachment->ID,
            'id'			=> $attachment->ID,
            'title'       	=> $attachment->post_title,
            'filename'		=> wp_basename($attachedFile),
            'filesize'		=> 0,
            'url'			=> wp_get_attachment_url($attachment->ID),
            'link'			=> get_attachment_link($attachment->ID),
            'alt'			=> get_post_meta($attachment->ID, '_wp_attachment_image_alt', true),
            'author'		=> $attachment->post_author,
            'description'	=> $attachment->post_content,
            'caption'		=> $attachment->post_excerpt,
            'name'			=> $attachment->post_name,
            'status'		=> $attachment->post_status,
            'uploaded_to'	=> $attachment->post_parent,
            'date'			=> $attachment->post_date_gmt,
            'modified'		=> $attachment->post_modified_gmt,
            'menu_order'	=> $attachment->menu_order,
            'mime_type'		=> $attachment->post_mime_type,
            'type'			=> $type,
            'subtype'		=> $subtype,
            'icon'			=> wp_mime_type_icon($attachment->ID)
        );
    
        // Append filesize data.
        if (isset($meta['filesize'])) {
            $response['filesize'] = $meta['filesize'];
        } elseif (file_exists($attachedFile)) {
            $response['filesize'] = filesize($attachedFile);
        }

        $sizesId = 0;

        // Type specific logic.
        switch ($type) {
            case 'image':
                $sizesId = $attachment->ID;
                $src = wp_get_attachment_image_src($attachment->ID, 'full');
                if ($src) {
                    $response['url'] = $src[0];
                    $response['width'] = $src[1];
                    $response['height'] = $src[2];
                }
                break;
            case 'video':
                $response['width'] = acf_maybe_get($meta, 'width', 0);
                $response['height'] = acf_maybe_get($meta, 'height', 0);
                if ($featured_id = get_post_thumbnail_id($attachment->ID)) {
                    $sizesId = $featured_id;
                }
                break;
            case 'audio':
                if ($featured_id = get_post_thumbnail_id($attachment->ID)) {
                    $sizesId = $featured_id;
                }
                break;
        }

        // Load array of image sizes.
        if ($sizesId) {
            $sizes = get_intermediate_image_sizes();
            $sizesData = array();
            foreach ($sizes as $size) {
                $src = wp_get_attachment_image_src($sizesId, $size);
                if ($src) {
                    $sizesData[ $size ] = $src[0];
                    $sizesData[ $size . '-width' ] = $src[1];
                    $sizesData[ $size . '-height' ] = $src[2];
                    // add webp
                    $imagePath = str_replace($uploadDir['baseurl'], $uploadDir['basedir'], $src[0]);
                    if (file_exists($imagePath . '.webp')) {
                        $sizesData[ $size  . '-webp'] = str_replace($uploadDir['basedir'], $uploadDir['baseurl'], $imagePath) . '.webp';
                    }
                }
            }
            $response['sizes'] = $sizesData;
        }

        set_transient('miaou_attachment_datas_' . $attachmentId, $response, HOUR_IN_SECONDS);

        return $response;
    }
}
