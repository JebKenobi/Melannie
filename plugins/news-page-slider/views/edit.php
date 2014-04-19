<?php

// Get the IF of the slider
$id = (int) $_GET['id'];

// Get slider
$slider = newsPageSliderById($id);

$title = (isset($_POST['title'])) ? $_POST['title'] : $slider['name'];


$slider = $slider['data'];

# main options
$template = (isset($_POST['slider']['template'])) ? $_POST['slider']['template'] : (isset($slider['template']))?$slider['template']:'';
$sort = (isset($_POST['slider']['sort'])) ? $_POST['slider']['sort'] : $slider['sort'];
$order = (isset($_POST['slider']['sort_order'])) ? $_POST['slider']['sort_order'] : $slider['sort_order'];
$number = (isset($_POST['slider']['posts'])) ? $_POST['slider']['posts'] : $slider['posts'];
$cache_time = (isset($_POST['slider']['cache'])) ? $_POST['slider']['cache'] : $slider['cache'];
$auto_cycling = (isset($_POST['slider']['auto_cycling'])) ? $_POST['slider']['auto_cycling'] : (isset($slider['auto_cycling']))?$slider['auto_cycling']:'';
$cycle_interval = (isset($_POST['slider']['cycle_interval'])) ? $_POST['slider']['cycle_interval'] : $slider['cycle_interval'];

# elements options
$enable_title = (isset($_POST['slider']['enable']['title'])) ? $_POST['slider']['enable']['title'] : $slider['enable']['title'];
$enable_description = (isset($_POST['slider']['enable']['description'])) ? $_POST['slider']['enable']['description'] : $slider['enable']['description'];
$enable_link = (isset($_POST['slider']['enable']['link'])) ? $_POST['slider']['enable']['link'] : $slider['enable']['link'];

$limit_words = (isset($_POST['slider']['words_limit'])) ? $_POST['slider']['words_limit'] : $slider['words_limit'];

# slideshow options
$auto_scroll = (isset($_POST['slider']['auto_mode'])) ? $_POST['slider']['auto_mode'] : (isset($slider['auto_mode']))?$slider['auto_mode']:'';
$auto_timeout = (isset($_POST['slider']['timeout'])) ? $_POST['slider']['timeout'] : (isset($slider['timeout']))?$slider['timeout']:'';

# Posts and categories
$selected_posts = (isset($_POST['slider']['post_select'])) ? $_POST['slider']['post_select'] : $slider['post_select'];
?>
<form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post" class="wrap" id="ls-slider-form">

	<input type="hidden" name="posted_edit" value="1">

	<h2>
		<?php _e('Edit this Slider', 'crum') ?>
		<a href="?page=<?php echo $plugin_slug; ?>" class="add-new-h2"><?php _e('Back to the list', 'crum') ?></a>
	</h2>


	<div id="ls-pages">

		<!-- Global Settings -->
		<div class="ls-page ls-settings active">

			<div id="post-body-content">
				<div id="titlediv">
					<div id="titlewrap">
						<input type="text" name="title" value="<?php echo $title; ?>" id="title" autocomplete="off" placeholder="<?php _e('Type your slider name here', 'crum') ?>">
					</div>
				</div>
			</div>


            <div class="ls-box ls-settings" id="hor-zebra">
                <table>
                    <tbody>
                    <thead>
                    <tr>
                        <td colspan="3">
                            <h4><?php _e('Basic settings', 'crum') ?></h4>
                        </td>
                    </tr>
                    </thead>

                    <!--<tr>
                        <td><?php _e('Select posts template', 'crum') ?></td>
                        <td>
                            <select name="slider[template]">
                                <option value='1b-4s' <?php if($template == '1b-4s') echo 'selected'; ?>><?php _e('1 Big and 4 small tiles', 'crum') ?></option>
                                <option value='4s-1b' <?php if($template == '4s-1b') echo 'selected'; ?>><?php _e('4 small and 1 Big tiles', 'crum') ?></option>
                                <option value='8s'    <?php if($template == '8s') echo 'selected'; ?>><?php _e('8 small tiles', 'crum') ?></option>
                                <option value='2b'    <?php if($template == '2b') echo 'selected'; ?>><?php _e('2 Big tiles', 'crum') ?></option>
                            </select>
                        <td class="desc"><?php _e('Select template to display post in one slide item', 'crum') ?></td>
                    </tr> -->

                    <tr>
                        <td><?php _e('Choose Sorting of Posts/Pages', 'crum') ?></td>
                        <td>
                            <select name="slider[sort]">
                                <option value='date' <?php if($sort == 'date') echo 'selected'; ?>><?php _e('Date', 'crum') ?></option>
                                <option value='ID'   <?php if($sort == 'ID') echo 'selected'; ?>><?php _e('Post ID', 'crum') ?></option>
                                <option value='name' <?php if($sort == 'name') echo 'selected'; ?>><?php _e('Slug', 'crum') ?></option>
                                <option value='title'<?php if($sort == 'title') echo 'selected'; ?>><?php _e('Title', 'crum') ?></option>
                            </select>
                        <td class="desc"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Choose Order of Posts/Pages', 'crum') ?></td>
                        <td>
                            <select name="slider[sort_order]">
                                <option value='asc'  <?php if($order == 'asc') echo 'selected'; ?>><?php _e('Ascending', 'crum') ?></option>
                                <option value='desc' <?php if($order == 'desc') echo 'selected'; ?>><?php _e('Descending', 'crum') ?></option>
                                <option value='rand' <?php if($order == 'rand') echo 'selected'; ?>><?php _e('Random', 'crum') ?></option>
                            </select>

                        </td>
                        <td class="desc"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Number of Posts/Pages slides', 'crum') ?></td>
                        <td>
                            <select name="slider[posts]">
                                <?php for ($i = 3; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if($number == $i) echo 'selected'; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </td>
                        <td class="desc"><?php _e('Select how many slides will be shown on the slider.', 'crum') ?></td>
                    </tr>

                    <tr>
                        <td><?php _e('Cache time [in minutes]', 'crum') ?></td>
                        <td><input type="text" name="slider[cache]" value="<?php echo $cache_time; ?>" class="input"></td>
                        <td class="desc"><?php _e('Enter time in minutes to cache slider for more high performance. Set 0 to disable slider cache.', 'crum') ?></td>
                    </tr>
					
					<thead>
					<tr>
						<td colspan="3">
							<h4><?php _e('Slideshow options', 'crum') ?></h4>
						</td>
					</tr>
					</thead>
					
					<tr>
                        <td><?php _e('Automated cycling', 'crum') ?></td>
                        <td><input type="checkbox" name="slider[auto_cycling]" value="1" class="input" <?php if ($auto_cycling == 1) echo 'checked="checked"'?>></td>
                        <td class="desc"><?php _e('Enable automatic cycling', 'crum') ?></td>
                    </tr>
					
					<tr>
                        <td><?php _e('Cycle Interval', 'crum') ?></td>
                        <td><input type="text" name="slider[cycle_interval]" value="<?php echo $cycle_interval; ?>" class="input"></td>
                        <td class="desc"><?php _e('Delay between cycles in milliseconds.', 'crum') ?></td>
                    </tr>
					
                    <thead>
                    <tr>
                        <td colspan="3">
                            <h4><?php _e('Slider elements', 'crum') ?></h4>
                        </td>
                    </tr>
                    </thead>

                    <tr>
                        <td><?php _e('Display Post/Page title', 'crum') ?></td>
                        <td><input type="checkbox" <?php if ($enable_title): ?>checked<?php endif;?> name="slider[enable][title]"></td>
                        <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
                    </tr>
                    <tr>
                        <td><?php _e('Display Post description', 'crum') ?></td>
                        <td><input type="checkbox" <?php if ($enable_description): ?>checked<?php endif;?> name="slider[enable][description]"></td>
                        <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
                    </tr>
                    <tr>
                        <td><?php _e('Limit Description (Number of words)', 'crum') ?></td>
                        <td><input type="text" name="slider[words_limit]" value="<?php echo $limit_words; ?>" class="input"></td>
                        <td class="desc"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Display link to full page', 'crum') ?></td>
                        <td><input type="checkbox" <?php if ($enable_link): ?>checked<?php endif;?> name="slider[enable][link]"></td>
                        <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
                    </tr>
                    <?php /*
                    <thead>
                    <tr>
                        <td colspan="3">
                            <h4><?php _e('Slideshow options', 'crum') ?></h4>
                        </td>
                    </tr>
                    </thead>
                    <tr>
                        <td><?php _e('Enable Auto Slider', 'crum') ?></td>
                        <td><input type="checkbox" <?php if ($auto_scroll): ?>checked<?php endif;?> name="slider[auto_mode]"></td>
                        <td class="desc"></td>
                    </tr>
                    <tr>
                        <td><?php _e('Set Slider Timeout (in ms)', 'crum') ?></td>
                        <td><input type="text" name="slider[timeout]" value="<?php echo $auto_timeout; ?>" class="input"></td>
                        <td class="desc"><?php _e('Delay between cycles in milliseconds', 'crum') ?></td>
                    </tr>
                    */ ?>

                    <thead>
                    <tr>
                        <td colspan="3">
                            <h4><?php _e('Select content', 'crum') ?></h4>
                        </td>
                    </tr>
                    </thead>

                    <tr>
                        <td><?php _e('Slider items from Posts/Pages', 'crum') ?></td>
                        <td>
                            <?php

                            echo '<select name="slider[post_select][]" multiple="multiple" style="width: 450px;height: 250px;">';

                            $categ = array('category' /*, 'my-product_category', 'product_cat'*/);

                            foreach ($categ as $cat) {

                                $args = array(
                                    'orderby' => 'id',
                                    'hierarchical' => 'false',
                                    'taxonomy' => $cat
                                );
                                $categories = get_terms($cat, $args);

                                switch ($cat) {
                                    case 'category':
                                        echo '<option value="" disabled="disabled">---------------- Posts categories ------------</option>';
                                        break;
                                    case 'my-product_category':
                                        echo '<option value="" disabled="disabled">---------------- Portfolio categories ------------</option>';
                                        break;
                                    case 'product_cat':
                                        echo '<option value="" disabled="disabled">---------------- Woocommerce categories ------------</option>';
                                        break;
                                }

                                foreach ($categories as $category) {

                                    if(is_array($selected_posts) && in_array($category->slug, $selected_posts)) $selected = 'selected'; else $selected = '';

                                    echo '<option value="' . $category->slug . '" '.$selected.'>"' . $category->name . '"</option>';

                                }

                            }
                            echo '</select>';
                            ?>

                        </td>
                        <td class="desc">Selecting multiple options vary in different operating systems and browsers: <br>
                            <br>
                            For windows: Hold down the control (ctrl) button to select multiple posts/pages<br>
                            For Mac: Hold down the command button to select multiple posts/pages</td>
                    </tr>


                    </tbody>
                </table>
            </div>
		</div>

		<!-- Event Callbacks -->

	</div>

			<button class="button-primary"><?php _e('Save changes', 'crum') ?></button>
			<p class="ls-saving-warning"></p>
			<div class="clear"></div>

</form>