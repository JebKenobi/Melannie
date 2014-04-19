<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" class="wrap" id="ls-slider-form">

<input type="hidden" name="posted_add" value="1">

<h2>
    <?php _e('Add New Slider', 'crum') ?>
    <a href="?page=<?php echo $plugin_slug; ?>" class="add-new-h2"><?php _e('Back to the list', 'crum') ?></a>
</h2>

<div id="ls-pages">

    <div class="ls-page ls-settings active">

        <div id="post-body-content">
            <div id="titlediv">
                <div id="titlewrap">
                    <input type="text" name="title" value="" id="title" autocomplete="off" placeholder="<?php _e('Slider name', 'crum') ?>">
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
                            <option value='1b-4s'><?php _e('1 Big and 4 small tiles', 'crum') ?></option>
                            <option value='4s-1b'><?php _e('4 small and 1 Big tiles', 'crum') ?></option>
                            <option value='8s'><?php _e('8 small tiles', 'crum') ?></option>
                            <option value='2b'><?php _e('2 Big tiles', 'crum') ?></option>
                        </select>
                    <td class="desc"><?php _e('Select template to display post in one slide item', 'crum') ?></td>
                </tr> -->

                <tr>
                    <td><?php _e('Choose Sorting of Posts/Pages', 'crum') ?></td>
                    <td>
                        <select name="slider[sort]">
                            <option value='date'><?php _e('Date', 'crum') ?></option>
                            <option value='ID'><?php _e('Post ID', 'crum') ?></option>
                            <option value='name'><?php _e('Slug', 'crum') ?></option>
                            <option value='title'><?php _e('Title', 'crum') ?></option>
                        </select>
                    <td class="desc"></td>
                </tr>
                <tr>
                    <td><?php _e('Choose Order of Posts/Pages', 'crum') ?></td>
                    <td>
                        <select name="slider[sort_order]">
                            <option value='asc'> <?php _e('Ascending', 'crum') ?></option>
                            <option value='desc'><?php _e('Descending', 'crum') ?></option>
                            <option value='rand'><?php _e('Random', 'crum') ?></option>
                        </select>

                    </td>
                    <td class="desc"></td>
                </tr>
                <tr>
                    <td><?php _e('Number of Posts/Pages slides', 'crum') ?></td>
                    <td>
                        <select name="slider[posts]">
							<?php for ($i = 3; $i <= 10; $i++): ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php endfor; ?>
                        </select>
                    </td>
                    <td class="desc"><?php _e('Select how many slides will be shown on the slider.', 'crum') ?></td>
                </tr>

                <tr>
                    <td><?php _e('Cache time', 'crum') ?></td>
                    <td><input type="text" name="slider[cache]" value="10" class="input"></td>
                    <td class="desc"><?php _e('Enter time in minutes to cache slider for more high performance. Set 0 to disable slider cache.', 'crum') ?></td>
                </tr>

                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Slider elements', 'crum') ?></h4>
                    </td>
                </tr>
                </thead>

                <tr>
                    <td><?php _e('Enable Post/Page title', 'crum') ?></td>
                    <td><input type="checkbox" name="slider[enable][title]"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
                </tr>
                <tr>
                    <td><?php _e('Enable Post description', 'crum') ?></td>
                    <td><input type="checkbox" name="slider[enable][description]"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
                </tr>
                <tr>
                    <td><?php _e('Limit Description (Number of words)', 'crum') ?></td>
                    <td><input type="text" name="slider[words_limit]" value="30" class="input"></td>
                    <td class="desc"></td>
                </tr>
                <tr>
                    <td><?php _e('Enable link to full page', 'crum') ?></td>
                    <td><input type="checkbox" name="slider[enable][link]"></td>
                    <td class="desc"><?php _e('If checked - element will be displayed, clean checkbox to hide element', 'crum') ?></td>
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
					<td><input type="checkbox" name="slider[auto_cycling]" value="1" class="input"></td>
					<td class="desc"><?php _e('Enable automatic cycling', 'crum') ?></td>
				</tr>

				<tr>
					<td><?php _e('Cycle Interval', 'crum') ?></td>
					<td><input type="text" name="slider[cycle_interval]" value="5000" class="input"></td>
					<td class="desc"><?php _e('Delay between cycles in milliseconds.', 'crum') ?></td>
				</tr>
                <thead>
                <tr>
                    <td colspan="3">
                        <h4><?php _e('Select content', 'crum') ?></h4>
                    </td>
                </tr>
                </thead>

                <tr>
                    <td><?php _e('Custom slider items', 'crum') ?></td>
                    <td>


                        <?php

                        echo '<select name="slider[post_select][]" multiple="multiple" style="width: 450px;height: 250px;">';

                        $categ = array('category'/*, 'my-product_category', 'product_cat'*/);


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

                                echo '<option value="' . $category->slug . '">' . $category->name . '</option>';

                            }

                        }
                        echo '</select>';

                        ?>

                    </td>
                    <td class="desc">Selecting multiple options vary in different operating systems and browsers: <br>
                        <br>
                        For windows: Hold down the control (ctrl) button to select multiple posts/pages<br>
                        For Mac: Hold down the command button to select multiple posts/pages
                    </td>
                </tr>


                </tbody>
            </table>
        </div>
    </div>

</div>

<div class="inner">
    <button class="button-primary"><?php _e('Save changes', 'crum') ?></button>
    <p class="ls-saving-warning"></p>

    <div class="clear"></div>
</div>

</form>