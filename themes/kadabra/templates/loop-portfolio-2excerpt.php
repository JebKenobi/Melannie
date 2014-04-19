<?php
$terms = get_the_terms(get_the_ID(), 'my-product_category');

if (has_post_thumbnail()) {
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url($thumb, 'full'); //get img URL
} else {
	$img_url = get_template_directory_uri() . '/img/no-image-large.jpg';
}

$article_columns = 'six';
$article_image = aq_resize($img_url, 480, 280, true);

$article_tags_classes = '';

foreach ($terms as $term) {
	$article_tags_classes .= ' ' . strtolower(preg_replace('/\s+/', '-', $term->slug)) . ' ';
}

?>
<article class="<?php echo $article_columns; ?> columns project" data-category="<?php echo $article_tags_classes; ?>">
	<div class="entry-thumb">
		<img src="<?php echo $article_image ?>" alt="<?php the_title(); ?>"/>
		
		<?php get_template_part('templates/portfolio/thumb', 'hover-mini'); ?>
	</div>

	<h4 class="box-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

	<?php get_template_part('templates/folio', 'terms'); ?>
	
	<?php the_excerpt(); ?>
	
	<?php echo DFD_HTML::read_more(get_permalink()); ?>
</article>