# CMB2-Helper
Easier, quicker and cleaner way to create CMB2 Tabs and Fields.

# What is this for?
Creating custom fields with CMB2 (while using tabs*) can be painful. Code gets bigger and dirtier with each field and tab added.

CMB2-Helper is a simple sollution for that problem. It creates arrays of tabs and fields in background, while you use just few methods.

# Example:
Let's say you want to add to your front-page editor a metabox with 3 tabs and few fields for each tab. 
You will probably end with code looking like this:
```php
<?php 

add_action('cmb2_admin_init', 'custom_prefix_page');

function custom_prefix_page() {
    page_();
}

function front_page_() {

    $prefix = __FUNCTION__;

    $box_options = array(
        'id' => $prefix . 'metabox',
        'title' => esc_html__('Front Page Settings', 'cmb2'),
        'object_types' => array('page',),
        'show_on' => array('id' => array(get_option('page_on_front'),)),
        'closed' => false,
    );

    $cmb = new_cmb2_box( $box_options );

    $tabs_setting           = array(
        'config' => $box_options,
        'layout' => 'vertical', // Default : horizontal
        'tabs'   => array()
    );

    $id = "1_";
    $tabs_setting['tabs'][] = array(
        'id'     => $id,
        'title'  => __( 'Section 1', 'cmb2' ),
        'fields' => array(
            array(
                'name' => __( 'Image backgorund in header', 'cmb2' ),
                'id'   => $id . 'main_image',
                'type' => 'file'
            ),
            array(
                'name' => __( 'Text on header', 'cmb2' ),
                'id'   => $id . 'main_text',
                'type' => 'wysiwyg'
            ),   
            array(
                'name' => __( 'Contributors', 'cmb2' ),
                'id'   => $id . 'contributors',
                'type' => 'group',
                'fields' => array(
                    array(
                        'name' => __( 'Photo', 'cmb2' ),
                        'id'   => 'photo',
                        'type' => 'file'
                    ),
                    array(
                        'name' => __( 'Name', 'cmb2' ),
                        'id'   => 'name',
                        'type' => 'text'
                    ),
                    array(
                        'name' => __( 'Biography', 'cmb2' ),
                        'id'   => 'biography',
                        'type' => 'wysiwyg'
                    ),
                ),
            ),
            array(
                'name' => __( 'Email Address', 'cmb2' ),
                'id'   => $id . 'email',
                'type' => 'text'
            ), 
            array(
                'name' => __( 'Background Color of section', 'cmb2' ),
                'id'   => $id . 'background',
                'type' => 'select',
                'options' => array(
                    '#fff' => __( 'White', 'cmb2' ),
                    '#000' => __( 'Black', 'cmb2' ),
                ),
            ),   
            array(
                'name' => __( 'Greeting message', 'cmb2' ),
                'id'   => $id . 'message',
                'type' => 'text',
                'default' => 'Hey my friend! :)'
            ),     
        )
    );

    $id = "2_";
    $tabs_setting['tabs'][] = array(
        'id'     => $id,
        'title'  => __( 'Section 2', 'cmb2' ),
        'fields' => array(
            array(
                'name' => __( 'Title on black area', 'cmb2' ),
                'id'   => $id . 'title',
                'type' => 'text',
            ),
            array(
                'name' => __( 'Text on black area', 'cmb2' ),
                'id'   => $id . 'text',
                'type' => 'wysiwyg',
            ),
        )
    );

    $id = "3_";
    $tabs_setting['tabs'][] = array(
        'id'     => $id,
        'title'  => __( 'Section 3', 'cmb2' ),
        'fields' => array(            
            array(
                'name' => __( 'Text on the left', 'cmb2' ),
                'id'      => $id . 'text_left',
                'type'    => 'wysiwyg',
            ),
            array(
                'name' => __( 'Text on the right', 'cmb2' ),
                'id'      => $id . 'text_right',
                'type'    => 'wysiwyg',
            ),
        )
    );

    $cmb->add_field( array(
        'id'   => '__tabs',
        'type' => 'tabs',
        'tabs' => $tabs_setting
    ) );    
}
```

That's freaking 130 lines of code for 13 fields and 3 tabs. In my opinion it's way too much.
Here is the code made with CMB2-Helper:
```php
<?php 

add_action('cmb2_admin_init', 'custom_prefix_page');

function custom_prefix_page() {

    page_();
}

function page_() {

    $prefix = __FUNCTION__;
    $type = array('page');
    $show_on = array('id' => array(get_option('page_on_front'),));

    $cmb_helper = new cmbField($prefix, 'Front Page Settings', $type, $show_on);

    $cmb_helper->addTab('Section 1');
    $cmb_helper->addField('main_image', 'Image backgorund in header', 'file');
    $cmb_helper->addField('main_text', 'Text on header', 'wysiwyg');
    $cmb_helper->addField('contributors', 'Contributors', 'group');
    $cmb_helper->addField('photo', 'Photo', 'file', 'contributors');
    $cmb_helper->addField('name', 'Name', 'text', 'contributors');
    $cmb_helper->addField('biography', 'Biography', 'wysiwyg', 'contributors');
    $cmb_helper->addField('email', 'Email Address', 'text');
    $options =  array(
        '#fff' => __( 'White', 'cmb2' ),
        '#000' => __( 'Black', 'cmb2' ),
    );
    $cmb_helper->addField('background', 'Background Color of section', 'select', false, $options);
    $cmb_helper->addField('message', 'Greetings message', 'text', false, false, 'Hey my friend! :)');

    $cmb_helper->addTab('Section 2');
    $cmb_helper->addField('title', 'Title on black area', 'text');
    $cmb_helper->addField('text', 'Text on black area', 'wysiwyg');

    $cmb_helper->addTab('Section 3');
    $cmb_helper->addField('text_left', 'Text on the left', 'wysiwyg');
    $cmb_helper->addField('text_right', 'Text on the right', 'wysiwyg');

    $cmb = new_cmb2_box($cmb_helper->generateCMB());
    $cmb->add_field($cmb_helper->generateTabs()); 
}
```
We end up with only 43 lines. Much better, isn't it?

# Installation:
 1. Add files from the repository to your theme's directory
 2. Add:
    ```php
    include 'cmb-helper.php';
    ```
    To your functions.php
 3. Now you can start creating custom fields much quicker and simpler 


# Requirements:
 - [CMB2](https://github.com/CMB2/CMB2) Version 2.2.5 or higher
 - [CMB2-Tabs*](https://github.com/LeadSoftInc/cmb2-tabs) Plugin
 - Optionally [Polylang](https://wordpress.org/plugins/polylang/) Version 0.8.1 or higher
