<?php
if (!empty($effects)) {
	$cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
	$cr_effect ='';
}

# IMG Wrapper options
$img_wrap_class = '';
$img_wrap_style = '';

$text_align = (!empty($text_align)) ? $text_align : '';
$image = (!empty($image)) ? $image : '';
$main_title = (!empty($main_title)) ? $main_title : '';

# Text align
$textwidget_class = 'textwidget ' . mvb_get_align_class($text_align);

switch ($text_align) {
	case 'left':
		$img_wrap_class .= 'text-left';
		break;
	case 'right':
		$img_wrap_class .= 'text-right';
		break;
	case 'center':
		$img_wrap_class .= 'text-center';
		break;
	default:

}

if (!empty($crop_height)) {
	$crop_height = intval($crop_height);
	$img_wrap_style .= ' height: '.$crop_height.'px;';
}

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}

?>

<div class="module banner-module <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>"  <?php echo $addition_css_styles; ?>>
	<div class="title-wrap vertical-align-center">
		<?php include(dirname(__FILE__).'/_title.php'); ?>
		<div class="<?php echo $textwidget_class; ?>">
			<?php echo mvb_parse_content($content, true) ?>
		</div>
	</div>
	<div class="banner-module-img-wrap <?php echo $img_wrap_class; ?>" style="<?php echo $img_wrap_style; ?>">
		<img src="<?php echo mvb_get_image_url($image); ?>" alt= "<?php echo strip_tags($main_title); ?>" />
	</div>
</div>
