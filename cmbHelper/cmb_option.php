<?php
/**
 * cmbOption - Metabox Helper for custom options
 *  
 * @author Daniel Drabik (daniel.drabik@outlook.com)
 * @version 0.2
 * 
 */
class cmbOption {

	public $prefix;
	public $option_key;
	public $title;

	private $metabox;

	private $tabsSetting;
	private $currentTab = null;
	private $currentTabPrefix;
	private $lang = '';

	private $currentField = null;

	public function __construct($option_key, $title, $icon = false) {

		$this->option_key = $option_key;
		$this->title = $title;

		$this->metabox = array(
			'id'          => $this->option_key . '_metabox',
			'title'       => __( $this->title, 'cmb2' ),
			'show_names'  => true,
			'object_type' => 'options-page',
			'show_on'     => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->option_key )
			),
		);

		$this->tabsSetting  = array(
	        'config' => $this->metabox,
	        'layout' => 'vertical', // Default : horizontal
	        'tabs'   => array()
	    );

	    if($icon)
	    	$this->metabox['icon_url'] = $icon;
	}

	public function addTab($prefix, $title) {

		if(function_exists('pll_current_language')) 
			$this->lang = pll_current_language() . '_';

		$prefix = $this->lang . $prefix;

		if($this->currentField != null) {
			$this->currentTab['fields'][] = $this->currentField;
			$this->currentField = null;
		}				

		if($this->currentTab != null) 
			$this->tabsSetting['tabs'][] = $this->currentTab;

		$this->currentTabPrefix = $prefix;
		$this->currentTab = array(
	        'id'     => $prefix,
	        'title'  => __( $title, 'cmb2' ),
	        'fields' => array()
	    );
	}

	public function addField($id, $name, $type, $group_id = false, $options = false, $default = false) {

		if($group_id) {

			if(!$options)
			$this->currentField['fields'][] =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $id,
			        'type' => $type,
			    );	
			else 		
				$this->currentField['fields'][] =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $id,
			        'type' => $type,
			        'options' => $options,
			    );	

			return true;		
		}
		else {

			if($this->currentField != null)
				$this->currentTab['fields'][] = $this->currentField;

			
			if($type == 'group') 
			
				$this->currentField =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $this->currentTabPrefix .'_'. $id,
			        'type' => $type,
			        'options' => array(
			            'group_title' => __('Element {#}', 'cmb2'), // since version 1.1.4, {#} gets replaced by row number			            
			            'sortable' => true, // beta
			            'closed' => true, // true to have the groups closed by default
			        ),
			    );
			
			else 

				$this->currentField =  array(
			        'name' => __( $name, 'cmb2' ),
			        'id'   => $this->currentTabPrefix .'_'. $id,
			        'type' => $type,
			    );
			
		}

		if($options) 
			$this->currentField['options'] = $options;
		
		if($default !== false) 
			$this->currentField['default'] = $default;

	}

	public function generateCMB() {

		if($this->currentField != null)
				$this->currentTab['fields'][] = $this->currentField;

		if($this->currentTab != null) 
			$this->tabsSetting['tabs'][] = $this->currentTab;

		return $this->metabox;
	}

	public function generateTabs() {

		$tabs = array(
	        'id'   => $this->option_key . '__tabs',
	        'type' => 'tabs',
	        'tabs' => $this->tabsSetting,
	    );

	    return $tabs;
	}

}
