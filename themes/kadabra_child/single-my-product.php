<?php
get_template_part('templates/top', 'folio'); ?>

<section id="layout" class="single-folio">

	<div class="row project">
		<?php
		if (!post_password_required(get_the_id())) {
			$folio_inside_template = dfd_get_folio_inside_template();
			get_template_part('templates/portfolio/inside', $folio_inside_template);
		} else {
			the_content();
		}
		?>
	</div>

    <?php if (get_post_meta($post->ID, 'recent_work', true)) {
      $shortcode = get_post_meta($post->ID, 'recent_work', true);
      echo do_shortcode("$shortcode");
      } else { echo ''; } ?>
</section>

<?php if (strcmp(DfdThemeSettings::get('portfolio_single_slider'),'slider') === 0): ?>
    <script type="text/javascript">
        jQuery(window).load(function () {
            var target_flexslider = jQuery('#my-work-slider');
            target_flexslider.flexslider({
                namespace: "my-work-",
                animation: "slide",
                controlNav: "thumbnails",
				animationLoop: false,
                smoothHeight: true,
                directionNav: false,

                start: function (slider) {
                    slider.removeClass('loading');
                }

            });
        });

    </script>
<?php endif; ?>
