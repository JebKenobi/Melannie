<?php
require_once( dirname(__FILE__).'/top_stan_header.php' );

?>

<div class="row">
    <div class="twelve columns">
        <div id="page-title">
            <div class="page-title-inner">

                <h1 class="page-title">
                    <?php echo get_the_title(); ?>
                </h1>

                <div class="page-title-inner-subtitle">
                    <?php
                    if (empty($custom_head_subtitle) && !empty($page)) {
						$custom_head_subtitle = get_post_meta($page, 'crum_headers_subtitle', true);
					}
                    if (!empty($custom_head_subtitle)) {
                        echo $custom_head_subtitle;
                    } else {
						the_title();
					}
					?>
                </div>

                

            </div>
        </div>
    </div>
</div>
<?php if (DfdThemeSettings::get('stan_header')) {echo '</div>';} ?>