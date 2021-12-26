<?php 
ob_start();
?>
var ajaxURL = "<?php print admin_url('admin-ajax.php'); ?>";
var websiteName = "<?php print get_bloginfo('name'); ?>";
<?php 
$inline_scripts = ob_get_contents();
ob_end_clean();
return apply_filters('miaou_inline_scripts', $inline_scripts);