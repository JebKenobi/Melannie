<div class="share-wrap">
	
	<ul>
		
		<li>
			<?php echo do_shortcode('[sb_wishlist_button]'); ?>
		</li>
		
		<li class="entry-share">
			<a href="#">
				<i class="icon-cloud"></i>
				<span class="entry-share-label"><?php _e('Share', 'dfd'); ?></span>
			</a>
			<ul class="entry-share-popup" data-directory="<?php echo get_template_directory_uri(); ?>" style="display: none;">
				<li>
					<a class="entry-share-link-facebook" data-title="<?php echo $data_title; ?>" data-url="<?php echo $data_link; ?>" href="#">
						<i class="soc_icon-facebook"></i>
					</a>
				</li>
				<li>
					<a class="entry-share-link-twitter" data-title="<?php echo $data_title; ?>" data-url="<?php echo $data_link; ?>" href="#">
						<i class="soc_icon-twitter-3"></i>
					</a>
				</li>
				<li>
					<a class="entry-share-link-googleplus" data-title="<?php echo $data_title; ?>" data-url="<?php echo $data_link; ?>" href="#">
						<i class="soc_icon-google__x2B_"></i>
					</a>
				</li>
				<li>
					<a class="entry-share-link-pinterest" data-title="<?php echo $data_title; ?>" data-url="<?php echo $data_link; ?>" href="#">
						<i class="soc_icon-pinterest"></i>
					</a>
				</li>
			</ul>
		</li>
		
	</ul>
	
</div>
