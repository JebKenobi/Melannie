<?php
function dfd_num_to_string( $str = 1){
    $arr = array(1 => 'twelve', 'six', 'four');

    if( isset($arr[$str]) )
    {
        return $arr[$str];
    }
    else
    {
        return 'twelve';
    }

}
$a = 0;
for($i = 1; $i < 4; $i++) {
    (is_active_sidebar('sidebar-footer-col'.$i)) ? $a++ : 0;
}
$b = dfd_num_to_string($a);
?>
<?php if (DfdThemeSettings::get("site_boxed")): ?><div class="boxed_lay"><?php endif; ?>   
<?php if ( $a > 0 ) : ?>
<section id="footer">
	<a href="#to-top" class="back-to-top"></a>

	<?php if (DfdThemeSettings::get("logo_footer")): ?>
		<div class="row">
			<div class="twelve columns footer-logo">
					<img src="<?php echo DfdThemeSettings::get("logo_footer"); ?>" alt="logo" class="foot-logo" />
			</div>
		</div>
	<?php endif; ?>
	<div class="row">
	<?php
	$counter = 0;
	for ($i = 1; $i < $a + 1; $i++) {
		$counter++;
		?>
		<div class="<?php echo $b; ?> columns col-<?php echo $a; ?> num-<?php echo $i; ?>">
			<?php dynamic_sidebar('sidebar-footer-col' . $i); ?>
		</div>
	<?php
	}
	?>
	</div>

</section>
<?php endif; ?>
	
<section id="sub-footer">
    <div class="row">
        <div class="six columns copyr">
                          
               <div class="subfoot-copyright">
                    <?php echo DfdThemeSettings::get("copyright_footer"); ?>
               </div>

        </div>
        <div class="six columns">
            <div class="subfoot-soc-icons">
                    <div class="soc-icons">
                            <?php crum_social_networks(true); ?>
                    </div>
            </div>
            <div class="soc-icons-title"><?php _e('Share us', 'dfd'); ?></div>
        </div>
    </div>
</section>
	
<?php echo DfdThemeSettings::get("custom_js"); ?>

<?php if (DfdThemeSettings::get("site_boxed")): ?></div><?php endif; ?>

</div>

<?php echo DfdThemeSettings::get('social_counters_code'); ?>

<?php wp_footer(); ?>
<script>
    (function ($) {
    var navToggle = function() {
        var $self = $("#primary_nav .menu_container");
        var $allElse = $('#layout');
        ( $self.css('right') === '0px' ) ? $self.css( 'right', '-300px' ) : $self.css( 'right', '0px' );
        ( $allElse.css('left') === '0px' ) ? $allElse.css( 'left', '-300px%' ) : $allElse.css( 'left', '0px' );
        $('#primary_nav .nav_trigger').toggleClass('active');
        $('#primary_nav .nav_trigger').toggleClass('inactive');
    }
    var hideNav = function () { 
        $( '#primary_nav .menu_container' ).css('right', '-300px%'); 
        $( '#layout' ).css('left', '0px'); 
        $( '#primary_nav .nav_trigger').removeClass('active');
        $('#primary_nav .nav_trigger').addClass('inactive');
    };
    $( '#primary_nav .nav_trigger' ).on( 'click', navToggle);
    
    
    $( '#layout' ).on( 'click', hideNav);

    })(jQuery);
</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-54547379-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
