<div class="wrap news-page-slider-wrap">

	<div class="controls center row">
		<span class="prev"><i class="icon-arrow-57"></i></span>
		<span class="next"><i class="icon-arrow-58"></i></span>
	</div>

	<div id="<?php echo $uniq_id; ?>" class="news-page-slider">
		<ul class="slidee">
		<?php
			$count = 0;
			$count_post = 0;
			$new_post_count = ($query->post_count > 4) ? ($query->post_count - $query->post_count % 4) : $query->post_count;

			while ($query->have_posts()) : $query->the_post();

				$count_post++;
				$count++;

				if ($count === 1) {
					echo '<li>';
				}
				
				require dirname(__FILE__) . '/loop.php';

				if ($count === 4) {
					echo '</li>';
					$count = 0;
				}

				if ($new_post_count === 8 && $count_post === 4) {
					break;
				}

				if ($count_post === $new_post_count) {
					break;
				}
				
			endwhile;
			?>
		</ul>
	</div>
</div>

<script type="text/javascript">
(function($) {
	var gutter_width = 0;
	var content_max_width = 1180, content_width;
	var $slider = $('#<?php echo $uniq_id; ?>');
	var $slider_nav = $('.news-page-slider-wrap .controls > span');
	var padding_between_slides = 0;

	var setSizes = function() {
		var window_width = $(document).width();
		
		if (window_width > content_max_width) {
			content_width = content_max_width - gutter_width;
		} else {
			content_width = window_width;
		}

		var slide_width = content_width;
		$slider.children('ul').children('li').css('width', slide_width + 'px');

		var slide_height = $slider.find('ul:first > li').height();
		$slider_nav.css('top', Math.round(slide_height / 2 ));

		if (($slider.find('li').length > 2) && (window_width > content_max_width)) {
			var left_offset = Math.floor(slide_width - ((window_width - content_width) / 2)) + padding_between_slides;
			$slider.css({
				width: Math.round(slide_width * 2.85) + 'px',
				left: -left_offset
			});
		} else {
			$slider.css({
				width: slide_width + 'px',
				left: 0
			});
		}
	};

	var initSlider = function() {
		$slider
				.on('jcarousel:createend', function(event, carousel) {
					if (carousel._items.length === 1) {
						$slider.jcarousel({center: true});
						carousel._first.addClass('active');
					} else {
						carousel._first.next().addClass('active');
					}
				})
				.on('jcarousel:scroll', function(event, carousel, target, animate) {
					if (carousel._items.length > 1) {
						$slider.find('li').removeClass('active');
					}
				})
				.on('jcarousel:scrollend', function(event, carousel) {
					carousel._first.next().addClass('active');
				})
				.jcarousel({
					wrap: 'circular',
					transitions: true
				});

		if ($slider.find('li').length > 2) {
			$('.news-page-slider-wrap .controls .prev')
					.jcarouselControl({
						target: '-=1'
					});

			$('.news-page-slider-wrap .controls .next')
					.jcarouselControl({
						target: '+=1'
					});
		} else {
			$('.news-page-slider-wrap .controls').hide();
		}
		
		var slide_height = $slider.find('li').height();
		
		$('.news-page-slider-wrap .controls > span').each(function(){
			var $this = $(this);
			var h = $this.height();
			
			$this.hover(function(){
				$this.css({
					'height': slide_height+'px',
					'line-height': slide_height+'px'
				});
				
			}, function(){
				$this.css({
					'height': h+'px',
					'line-height': h+'px'
				});
			});
		});

		<?php if ($auto_scroll == 1) : ?>
			$slider.jcarouselAutoscroll({
				target: '+=1',
				interval: <?php echo $auto_timeout; ?>
			});

			$slider.find('li').hover(function() {
				$slider.jcarouselAutoscroll('stop');
			}, function() {
				$slider.jcarouselAutoscroll('start');
			});
		<?php endif; ?>
	};

	$(window).load(function() {
		setSizes();
		initSlider();
	});

	$(window).resize(function() {
		<?php if (isset($slider['auto_cycling']) && $slider['auto_cycling'] == 1) : ?>
			$slider.jcarouselAutoscroll('stop');
		<?php endif; ?>

		setSizes();

		<?php if (isset($slider['auto_cycling']) && $slider['auto_cycling'] == 1) : ?>
			$slider.jcarouselAutoscroll('start');
		<?php endif; ?>
	});

}(jQuery));
</script>