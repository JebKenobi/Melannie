<nav class="mega-menu" id="primary_nav">
	<a class="nav_trigger inactive">Menu</a>
	<div class="menu_container">
		<?php
			wp_nav_menu(array(
				'theme_location' => 'primary_navigation', 
				'menu_class' => 'nav-menu menu-primary-navigation', 
				'fallback_cb' => 'top_menu_fallback'
			));
		?>
		<?php get_template_part('templates/header/block', 'search'); ?>
		<p class="contact_info"><strong>1625 Harbor AVE SW #2</strong><br />Seattle, WA, 98126<br />info [at] somethingepic [dot] co</p>	
	</div>
</nav>
