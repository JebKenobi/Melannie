<?php
if ($count === 1) {
	// Big Template
	$el_class = 'big-element';
	$el_thumbnail_size = array(680, 672);
} else {
	// Small Template
	$el_class = 'small-element';
	$el_thumbnail_size = array(500, 224);
}

if (has_post_thumbnail()) {
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
} else {
	$img_url = '';
}

if ($enable_description) {
	$content = get_the_content();
	$trimmed_content = wp_trim_words($content, $limit_words, '');
}
?>

<div class="<?php echo $el_class; ?> item">
	<div class="entry-thumb">
		<img src="<?php echo aq_resize($img_url, $el_thumbnail_size[0], $el_thumbnail_size[1], true); ?>" alt="">

		<div class="entry-hover-bg"></div>
		
		<a class="picture-entry-thumb" href="<?php echo $img_url; ?>" data-rel="prettyPhoto[]">
			<i class="icon-link-2"></i>
		</a>
		
		<?php if ($enable_title): ?>
		<div class="entry-title-wrap">
			<div class="entry-title">
				<?php if ($enable_link) { ?>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					<?php
				} else {
					the_title();
				}
				?>
			</div>
			<div class="dopinfo">
				<?php echo get_the_date(); ?>
			</div>
		</div>
		<?php endif; ?>

	</div>
</div>
