<?php

class crum_contacts_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'crum_contacts_widget',
            __( 'Widget: Contacts block', 'dfd' ), // Name
            array( 'description' =>  __( 'Displays the author&apos;s contact information&#44; such as address&#44; phone etc&#46;', 'dfd')), 
			array('width' => 500, 'height' => 350)
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    function widget( $args, $instance ) {
        extract( $args );
        $title = $instance['title'];
        $text = $instance['text'];
        echo $before_widget;

        if ( ! empty( $title ) )

            echo $before_title . $title . $after_title;

            echo $text;

		echo '<div class="text-center"><div class="widget soc-icons">';
		crum_social_networks(true);
		echo '</div></div>';
		
        echo $after_widget;
    }


    function update($new, $old){
        $new = wp_parse_args($new, array(
            'title' => '',
            'text' => '',
        ));
        return $new;
    }

    function form( $instance ) {
        $instance = wp_parse_args($instance, array(
            'title' => '',
            'text' => '',
        ));
?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'dfd'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>"/>
    </p>
    <p>
        <textarea class="widefat" rows="20" cols="40" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $instance['text']; ?></textarea>
    </p>

    <?php
    }
}


