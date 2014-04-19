<?php
if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
}

$icon = (!empty($icon)) ? $icon : '';
$icon_align = (!empty($icon_align)) ? $icon_align : '';
$icon_color = (!empty($icon_color)) ? $icon_color : '';
$icon_hover_color = (!empty($icon_hover_color)) ? $icon_hover_color : '';
$icon_size = (!empty($icon_size)) ? $icon_size : '';

# Addition CSS styles
$addition_css_styles = '';

if (!empty($css_styles)) {
	$addition_css_styles .= $css_styles;
}
if (!empty($addition_css_styles)) {
	$addition_css_styles = 'style="' . $addition_css_styles . '"';
}
?>
<div class="module icon-module <?php echo (!empty($css)) ? $css : ''; ?> <?php echo $cr_effect; ?>" <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

	<?php require(dirname(__FILE__).'/_icon.php'); ?>

</div>