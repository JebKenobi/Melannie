(function($){
	"use strict";

	var $window = $(window);
	$window.load(function () {

		var columns = 3,
			setColumns = function () {
				var width = $window.width();
				columns = width > 640 ? 3 : width > 320 ? 2 : 1;
			};

		setColumns();
		$window.resize(setColumns);

		jQuery('#grid-folio').masonry({
			itemSelector: '.project',
			isAnimated: true,
			columnWidth: function (containerWidth) {
				return containerWidth / columns;
			}
		});
	});
})(jQuery);