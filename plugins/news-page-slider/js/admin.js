(function($) {
	"use strict";
	$(function() {
		$('#cidade').change(function() {
			$.ajax({
				url: "<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php",
				type: 'POST',
				data: 'action=category_select_action&name=' + name,
				success: function(results)
				{
					$("#cozinha").html(results);
				}
			});
		});
	});
}(jQuery));
