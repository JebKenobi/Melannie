(function($){
	"use strict";

	var $window = $(window);
	$window.load(function() {
		var $container = jQuery('#grid-folio');
		var itemSelector = '.project';
        var columns = 4,
            setColumns = function () {
				var width = $window.width();
                columns = width > 640 ? 4 : width > 320 ? 1 : 1;
            };

        setColumns();
        $window.resize(setColumns);

        $container.masonry({
                itemSelector: itemSelector,
                isAnimated: true,
                columnWidth: function (containerWidth) {
					var w = Math.floor(containerWidth / columns);
					$container.find(itemSelector).css('width', w+'px');
                    return w;
                }
            });
    });
})(jQuery);