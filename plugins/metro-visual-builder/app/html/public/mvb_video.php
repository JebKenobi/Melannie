<?php if (!empty($effects)) {
    $cr_effect = ' cr-animate-gen"  data-gen="'.$effects.'" data-gen-offset="bottom-in-view';
} else {
    $cr_effect ='';
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

<div class="video_module module <?php echo (!empty($css)) ? $css : ''; ?>"  <?php echo $addition_css_styles; ?>>

    <?php include(dirname(__FILE__).'/_title.php'); ?>

    <?php if ($content){


        $embed_code = wp_oembed_get($content.'&amp;wmode=opaque', array('width'=>1200));
	    $one_explode = explode('src="', $embed_code);
	    $two_explode = explode('"', $one_explode[1]);
	    if (strpos($two_explode[0], '?') === false) {
		    $two_explode[0] .= '?rel=0&amp;wmode=opaque';
	    } else {
		    $two_explode[0] .= '&amp;rel=0&amp;wmode=opaque';
	    }
	    $one_explode[1] = implode('"', $two_explode);
	    $embed_code = implode('src="', $one_explode);

        echo '<div class="video-box">'.$embed_code.'</div>';

} ?>


</div>
