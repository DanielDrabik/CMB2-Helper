<?php

add_action( 'cmb2_admin_init', 'custom_prefix_settings' );

function custom_prefix_settings() {
    
    settings_();
}


function settings_() {

    /**
     * Caution: Order of fields is important
     */

    $prefix = __FUNCTION__;

    /** Create new cmbOption object
      * $prefix is will be used to retrieve value from option field
      * Second param is a title of option page 
      * Third param defines wordpress dashboard menu icon
      */
    $cmb_helper = new cmbOption($prefix, 'Template Settings', 'dashicons-admin-appearance');

    /** Create New Tab
      * First param will be needed to retrieve value from option field
      * Second param is a title of the tab
      */
    $cmb_helper->addTab('header', 'Header');

    /** Begin adding field to the tab created above
      * First param is a unique id of the field. 
      * Second param is a field title
      * Third param is a field type defined in cmb2
      */
    $cmb_helper->addField('logo', 'Main logo', 'file');

    $cmb_helper->addField('links', 'Social links ', 'group');

    /** In case of creating repeatable group field, to add fields inside it
      * You have to pass group id as Forth param
      */
    $cmb_helper->addField('link', 'URL to the profile', 'text', 'links');

    /** To stop adding fields into group field s
      * simply add field with forth param blank or false value
      */
    $cmb_helper->addField('email', 'Email Address', 'text');

    /** In case you need to add option parameter in cmb2 field
      * You can pass an array inside fifth param
      */
    $options =  array(
        '#fff' => __( 'White', 'cmb2' ),
        '#000' => __( 'Black', 'cmb2' ),
    );
    $cmb_helper->addField('background', 'Background Color', 'select', false, $options);

    /** Last param is a default value */
    $cmb_helper->addField('message', 'Greetings message', 'text', false, false, 'Hey my friend! :)');


    // If you want to add more tabs with fields
    $cmb_helper->addTab('footer', 'Footer');
    $cmb_helper->addField('partners', 'Partner\'s Logo', 'group');
    $cmb_helper->addField('logo', 'Logo', 'file', 'partners');


    /** When you are done
      * Call these methods
      */
    $cmb = new_cmb2_box($cmb_helper->generateCMB());
    $cmb->add_field($cmb_helper->generateTabs());  
}
