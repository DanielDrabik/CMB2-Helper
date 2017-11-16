<?php 

add_action('cmb2_admin_init', 'custom_prefix_page');

function custom_prefix_page() {

    page_();
}

function page_() {

    /**
     * Caution: Order of fields is important
     */

    $prefix = __FUNCTION__;

    /**
     * Pick post type if necessary
     */
    $type = array('page');

    /**
     * Define custom show_on param for cmb2 metabox
     */
    $show_on = array('id' => array(get_option('page_on_front'),));

    /** Create new cmbField object
      * $prefix is will be used to retrieve value from field
      * Second param is a title of metabox 
      * Third param defines post type to display this metabox on
      * Forth param defines custom show_on of cmb2 metabox
      */
    $cmb_helper = new cmbField($prefix, 'Front Page Settings', $type, $show_on);

    /** Create New Tab
      * First param is a tab title
      */
    $cmb_helper->addTab('Section 1');

    /** Begin adding field to the tab created above
      * First param is a unique id of the field. 
      * Second param is a field title
      * Third param is a field type defined in cmb2
      */
    $cmb_helper->addField('main_image', 'Image backgorund in header', 'file');
    $cmb_helper->addField('main_text', 'Text on header', 'wysiwyg');

    $cmb_helper->addField('contributors', 'Contributors', 'group');
    /** In case of creating repeatable group field, to add fields inside it
      * You have to pass group id as Forth param
      */
    $cmb_helper->addField('photo', 'Photo', 'file', 'contributors');
    $cmb_helper->addField('name', 'Name', 'text', 'contributors');
    $cmb_helper->addField('biography', 'Biography', 'wysiwyg', 'contributors');

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
    $cmb_helper->addField('background', 'Background Color of section', 'select', false, $options);

    /** Last param is a default value */
    $cmb_helper->addField('message', 'Greetings message', 'text', false, false, 'Hey my friend! :)');


    // If you want to add more tabs with fields
    $cmb_helper->addTab('Section 2');
    $cmb_helper->addField('title', 'Title on black area', 'text');
    $cmb_helper->addField('text', 'Text on black area', 'wysiwyg');

    $cmb_helper->addTab('Section 3');
    $cmb_helper->addField('text_left', 'Text on the left', 'wysiwyg');
    $cmb_helper->addField('text_right', 'Text on the right', 'wysiwyg');

    /** When you are done
      * Call these methods
      */
    $cmb = new_cmb2_box($cmb_helper->generateCMB());
    $cmb->add_field($cmb_helper->generateTabs()); 
}
