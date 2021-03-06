<?php

class MVB_Qr
{
    /**
	 * The modules settings
	 *
	 * @access public
	 * @param none
	 * @return array settings
	 */

    public static function settings()
    {
        return array(
            'title'           =>      __('The QR module', 'mvb'),
            'description'     =>      __('Adds the QR code', 'mvb'),
            'identifier'      =>      __CLASS__,
            'icon'            =>      'appbar.page.text.png',
            'class'            =>      'fa fa-list-alt',
            'section'         =>      'content',
            'color'           =>      'gray'
        );
    }//end settings()

    /**
	 * The shortcodes attributes with the field options
	 *
	 * @access private
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function fields()
    {
        global $mvb_metro_factory;

        $the_fields = array(
            'main_title' => array(
                'type'      =>      'text',
				's_title'   =>      TRUE,
                'label'     =>      __('Title', 'mvb'),
            ),
			
			'separator' => array('type' =>  'separator'),
			
			'icon_content' => array(
				'type'      =>      'icon',
				'label'     =>      __('Icon', 'mvb'),
				'col_span'  =>      'lbl_half'
			),
			
			'qr_content' => array(
                'type'      =>      'textarea',
                'label'     =>      __('QR content', 'mvb'),
				'col_span'  =>      'lbl_half'
			),
			
			'separator' => array('type' =>  'separator'),
			
			'content' => array(
				'type'		=>		'textarea',
				'label'		=>		__('Content', 'mvb'),
			),
	        'css' => array(
		        'type'      =>      'text',
		        'label'     =>      __('Additional CSS classes', 'mvb'),
		        'help'      =>      __('Separated by space', 'mvb'),
		        'col_span'  =>      'lbl_third'
	        ),
	        'css_styles' => array(
		        'type'      =>      'text',
		        'label'     =>      __('Additional CSS styles', 'mvb'),
		        'help'      =>      __('Separated by <b>;</b>', 'mvb'),
		        'col_span'  =>      'lbl_full'
	        ),
        );
		
		$the_fields = apply_filters('mvb_fields_filter', $the_fields);

        return $the_fields;
    }//end fields();


    /**
	 * The private code for the shortcode. used in the custom editor
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */

    public static function admin_render( $atts = array(), $content = '' )
    {
        global $mvb_metro_factory;
        global $mvb_metro_form_builder;
        $form_fields = self::fields();

        $load = shortcode_atts( $mvb_metro_factory->defaults($form_fields), $atts );
        $load['content'] = $content;

        if( $mvb_metro_factory->show_pill_sc OR $mvb_metro_factory->show_pill_sc_column )
        {
            if( method_exists(__CLASS__, 'the_pill') )
            {
                return self::the_pill($load, self::settings());
            }
            else
            {
                return $mvb_metro_factory->the_pill($load, self::settings());
            }

        }
        else
        {
            $load['form_fields_html'] = $mvb_metro_form_builder->build_form($form_fields, $load);
            $load['settings'] = self::settings();
            $load['form_fields'] = $form_fields;
            $load['module_action'] = $mvb_metro_factory->module_action;
            $load['content'] = $content;

            return $mvb_metro_factory->_load_view('html/private/mvb_form.php', $load);
        }//endif

    }//end admin_render();

    /**
	 * The public code for the shortcode
	 *
	 * @access public
	 * @param array $atts
	 * @return shortcode output
	 */
    public static function render( $atts, $content = '' )
    {
        global $mvb_metro_factory;

        $load = $atts;
		$load['content'] = $content;

        return $mvb_metro_factory->_load_view('html/public/mvb_qr.php', $load);
    }//end render();
}//end class