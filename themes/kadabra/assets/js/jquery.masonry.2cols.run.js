(function($){
	"use strict";

	jQuery(document).ready(function ($) {
		var $container = jQuery('#grid-posts');

		$container.imagesLoaded(function () {
			$container.masonry({
				itemSelector: 'article.small-news'
			});
		});
	});
})(jQuery);