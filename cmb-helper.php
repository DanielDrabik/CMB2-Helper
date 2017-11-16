<?php
/**
 * CMB2 Helper
 * @author 	Daniel Drabik (d.drabik@outlook.com)
 * @version 0.1
 */

	/**
	 * Add CMB Helper Classes
	 */
	include 'cmbHelper/cmb_field.php';
	include 'cmbHelper/cmb_option.php';

	/**
	 * Returns post/page custom field value
	 * 
	 * @param string $field_id Unique identificator for custom field
	 * @param null|int|string|object(type post) $id Post identificator
	 * @return array|string|bool Returns saved field based on its ID or false if empty 
	 */
	function get_the_field($field_id, $id = null) {
		if ( empty( $id ) && isset( $GLOBALS['post'] ) ) {
        	$post = $GLOBALS['post'];
        	return get_post_meta($post->ID, $field_id, true);        	
		}

		if (is_integer($id))
			return get_post_meta($id, $field_id, true); 

		if(is_object($id)) 
			return get_post_meta($id->ID, $field_id, true);  

		if(is_string($id))
			return get_post_meta(intval($id), $field_id, true);		

		return false;
	}


	/**
	 * Displays formatted custom field value
	 * 
	 * @param string $field_id Unique identificator for custom field
	 * @param null|int|string|object(type post) $id Post identificator
	 * @param bool $filters Defines if function should add the_content filters
	 */
	function the_field($field_id, $id = null, $filters = false) {

		if($filters)
			content_field(get_the_field($field_id, $id));		
		else
			echo get_the_field($field_id, $id);
	}


	/**
	 * Checks whether field has saved any value or is empty
	 * 
	 * @param string $field_id Unique identificator for custom field
	 * @param null|int|string|object(type post) $id Post identificator
	 * @return boolean Returns true if field is not empty or false if it has not any value stored
	 */
	function is_field($field_id, $id = null) {
		return !empty(get_the_field($field_id, $id));
	}


	/**
	 * Returns custom field from the options page
	 * 
	 * @param string $option_key Some kind of custom field prefix 
	 * @param string $option_id Unique identificator for custom field
	 * @return array|string Returns saved field based on its ID
	 */
	function get_the_option($option_key, $option_id) {

		if(function_exists('pll_current_language'))
			return cmb2_get_option($option_key, pll_current_language() . '_' .$option_id);
		
		return cmb2_get_option($option_key, $option_id);
	}


	/**
	 * Displays formatted field from the options page
	 * 
	 * @param string $option_key Some kind of custom field prefix 
	 * @param string $option_id Unique identificator for custom field
	 * @param bool $filters Defines if function should add the_content filters
	 */
	function the_option($option_key, $option_id, $filters = false) {

		if($filters)
			content_field(get_the_option($option_key, $option_id));
		else
			echo get_the_option($option_key, $option_id);
	}	


	/**
	 * Checks whether option has saved any value or is empty
	 * 
	 * @param string $option_key Some kind of custom field prefix 
	 * @param string $option_id Unique identificator for custom field
	 * @return boolean Returns true if option is not empty or false if it has not any value stored
	 */
	function is_option($option_key, $option_id) {
		return !empty(get_the_option($option_key, $option_id));
	}


	/**
	 * Apply filters (Required for wysiwyg fields inside group fields)
	 * 
	 * @param string $string Text that needs filters (Wysiwyg fields)
	 * @return string Filtered text
	 */
	function get_content_field($string) {
		return apply_filters( 'the_content', $string );
	}


	/**
	 * Displays filtered text (Required for wysiwyg fields inside group fields)
	 * 
	 * @param string $string Text that needs filters (Wysiwyg fields)
	 */
	function content_field($string) {
		echo get_content_field($string);
	}

	
