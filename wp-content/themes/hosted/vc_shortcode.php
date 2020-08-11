<?php 

// Button
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Button", 'hosted'),
   "base" => "otbutton",
   "class" => "",
   "icon" => "icon-st",
   "category" => 'Hosted Element',
   "params" => array( 
      array(
         "type" => "vc_link",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Button", 'hosted'),
         "param_name" => "btn",
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Button Style", 'hosted'),
         "param_name" => "style",
         "value" => array(                        
                     esc_html__('Default', 'hosted')  => 'btn-default',
                     esc_html__('Dark', 'hosted')     => 'btn-dark',
                     esc_html__('Color', 'hosted')    => 'btn-color',
                  ),
      ),
    )));
}

// Features box
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Features Box", 'hosted'),
   "base" => "servicesbox",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Type Box', 'hosted'),
         "param_name" => "style",
         "value" => array(
            esc_html__('Style 1: Grey Box', 'hosted')  => 'box1',
            esc_html__('Style 2: Icon Left', 'hosted')  => 'box2',
         ), 
      ),  
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon Image", 'hosted'),
         "param_name" => "img",
         "value" => "",
      ),
      array(
         "type" => "iconpicker",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon", 'hosted'),
         "param_name" => "icon",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",
         "value" => "",
         "description" => esc_html__("Title of box", 'hosted')
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'hosted'),
         "param_name" => "content",
         "value" => "",
         "description" => esc_html__("content right.", 'hosted')
      ),
    )
    ));
}

// Icon box
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Icon Box", 'hosted'),
   "base" => "iconbox",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Type Box', 'hosted'),
         "param_name" => "style",
         "value" => array(
            esc_html__('Style 1: Icon Left', 'hosted')  => 'icon1',
            esc_html__('Style 2: White Box', 'hosted')  => 'icon2',
            esc_html__('Style 3: Icon Center', 'hosted')  => 'icon3',
         ), 
      ),  
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon Image", 'hosted'),
         "param_name" => "img",
         "value" => "",
      ),
      array(
         "type" => "iconpicker",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon", 'hosted'),
         "param_name" => "icon",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",
         "value" => "",
         "description" => esc_html__("Title of box", 'hosted')
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'hosted'),
         "param_name" => "content",
         "value" => "",
         "description" => esc_html__("content right.", 'hosted')
      ),
      array(
         "type" => "vc_link",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Button", 'hosted'),
         "param_name" => "btn",
         'dependency'  => array( 'element' => 'style', 'value' => 'icon2' ),
      ),
    )
    ));
}

// Call To Action
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Call To Action", 'hosted'),
   "base" => "callaction",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(  
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",         
      ),
      array(
         "type" => "vc_link",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Button", 'hosted'),
         "param_name" => "btn",
         "value" => "",
      ),
    )
   ));
}


// Domain Search
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Domain Search Form", 'hosted'),
   "base" => "hosted_search_domain",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(  
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Placeholder", 'hosted'),
         "param_name" => "holder",         
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Action Link", 'hosted'),
         "param_name" => "actionlink",
         "value" => "",
      ),
    )
   ));
}

// Domain List
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Domain List", 'hosted'),
   "base" => "prdomain",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(  
      array(
        "type" => 'textfield',
        "heading" => esc_html__("Width (%)", 'hosted'),
        "description" => esc_html__("Example: 25%.", 'hosted'),
        "param_name" => "width",         
      ),
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Domain", 'hosted'),
          'value' => '',
          'param_name' => 'domain',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Domain Name',
                  'param_name' => 'title',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Price',
                  'param_name' => 'price',
               ),
          )
      ),
    )
   ));
}

// Member Team
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Member Team", 'hosted'),
   "base" => "member",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Photo", 'hosted'),
         "param_name" => "photo",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Member Name", 'hosted'),
         "param_name" => "name",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Member Job", 'hosted'),
         "param_name" => "job",
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Details", 'hosted'),
         "param_name" => "content",
         "value" => "",
      ),
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Socials", 'hosted'),
          'value' => '',
          'param_name' => 'social',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'iconpicker',
                  'value' => '',
                  'heading' => 'Social Icon',
                  'param_name' => 'icon',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Social Link',
                  'param_name' => 'link',
               ),
          )
      ),
    )
    ));
}


// Single Testimonials
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Single Testimonial", 'hosted'),
   "base" => "testitem",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Photo", 'hosted'),
         "param_name" => "photo",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Name", 'hosted'),
         "param_name" => "name",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Job", 'hosted'),
         "param_name" => "job",
         "value" => "",
      ),
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Rating", 'hosted'),
         "param_name" => "star",
         "value" => array(                        
                     esc_html__('Choose One', 'hosted')   => '',
                     esc_html__('1', 'hosted')   => '1',
                     esc_html__('2', 'hosted')   => '2',
                     esc_html__('3', 'hosted')   => '3',
                     esc_html__('4', 'hosted')   => '4',
                     esc_html__('5', 'hosted')   => '5',
                  ),
         "description" => esc_html__("Default: 5 star.", 'hosted'),
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Details", 'hosted'),
         "param_name" => "content",
         "value" => "",
      ),
      
    )
    ));
}


// Testimonial Slider
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Testimonials", 'hosted'),
   "base" => "testslide",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Style", 'hosted'),
         "param_name" => "style",
         "value" => array(                        
                     esc_html__('Style 1', 'hosted')   => 's1',
                     esc_html__('Style 2', 'hosted')   => 's2',
                  ),
      ),
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Testimonial", 'hosted'),
          'value' => '',
          'param_name' => 'testi',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Name', 'hosted'),
                  'param_name' => 'name',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Job', 'hosted'),
                  'param_name' => 'job',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Text', 'hosted'),
                  'param_name' => 'text',
               ),
          )
      ),
      array(
         "type" => "checkbox",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Dark Text", 'hosted'),
         "param_name" => "dark",
         "value" => "",
      ),
    )));
}

// Testimonial Slider 2
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Testimonials 2", 'hosted'),
   "base" => "testslide2",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Testimonial", 'hosted'),
          'value' => '',
          'param_name' => 'testi',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Text', 'hosted'),
                  'param_name' => 'text',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Name', 'hosted'),
                  'param_name' => 'name',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Job', 'hosted'),
                  'param_name' => 'job',
               ),
               array(
                  'type' => 'attach_image',
                  'value' => '',
                  'heading' => esc_html__('Avatar', 'hosted'),
                  'param_name' => 'photo',
               ),
          )
      ),
    )));
}


// Pricing Table
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Pricing Table", 'hosted'),
   "base" => "table",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Style", 'hosted'),
         "param_name" => "style",
         "value" => array(                        
                     esc_html__('Style 1', 'hosted')   => 'style1',
                     esc_html__('Style 2', 'hosted')   => 'style2',
                     esc_html__('Style 3', 'hosted')   => 'style3',
                  ),
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",
         "value" => "",
         "description" => esc_html__("Title of table", 'hosted')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Price", 'hosted'),
         "param_name" => "price",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Per", 'hosted'),
         "param_name" => "per",
         'dependency'  => array( 'element' => 'style', 'value' => array('style1', 'style3') ),
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("VAT", 'hosted'),
         "param_name" => "vat",
         'dependency'  => array( 'element' => 'style', 'value' => 'style3' ),
         "value" => "",
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Description", 'hosted'),
         "param_name" => "content",
         "value" => "",
      ),
      array(
        'type' => 'vc_link',
         "heading" => esc_html__("Button", 'hosted'),
         "param_name" => "linkbox",         
         "description" => esc_html__("Add link to Button.", 'hosted'),
      ),
      array(
         "type" => "checkbox",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__('Featured Table?', 'hosted'),
         'dependency'  => array( 'element' => 'style', 'value' => array('style1', 'style2') ),
         "param_name" => "feature",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Featured Text", 'hosted'),
         "param_name" => "feat",
         "value" => "",
         'dependency'  => array( 'element' => 'style', 'value' => 'style2' ),
         "description" => esc_html__("Featured text display on top table.", 'hosted')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Width", 'hosted'),
         "param_name" => "width",
         "value" => "",
         'dependency'  => array( 'element' => 'style', 'value' => 'style2' ),
         "description" => esc_html__("Width of Table.", 'hosted')
      ),
    )));
}


// Pricing Table Compare
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Pricing Table Compare", 'hosted'),
   "base" => "pricingtable2",
   "class" => "",
   "category" => 'Content',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "checkbox",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Header Column?", 'hosted'),
         "param_name" => "head",
         "value" => "",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title Pricing", 'hosted'),
         "param_name" => "title",
         "value" => "",
         'dependency'  => array( 'element' => 'head', 'is_empty' => true ),
         "description" => esc_html__("Title display in Pricing Table.", 'hosted')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Price Pricing", 'hosted'),
         "param_name" => "price",
         "value" => "",
         'dependency'  => array( 'element' => 'head', 'is_empty' => true ),
         "description" => esc_html__("Price display in Pricing Table.", 'hosted')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Time", 'hosted'),
         "param_name" => "per",
         "value" => "",
         'dependency'  => array( 'element' => 'head', 'is_empty' => true ),
         "description" => esc_html__("Per Month or Year display in Pricing Table.", 'hosted')
      ),
      array(
         "type" => "textarea_html",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Detail Pricing", 'hosted'),
         "param_name" => "content",
         "value" => "",
         "description" => esc_html__("Content Pricing Table.", 'hosted')
      ),
     array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Label Button", 'hosted'),
         "param_name" => "btn",
         "value" => "",
         'dependency'  => array( 'element' => 'head', 'is_empty' => true ),
         "description" => esc_html__("Text display in button.", 'hosted')
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Link Button", 'hosted'),
         "param_name" => "link",
         "value" => "",
         'dependency'  => array( 'element' => 'head', 'is_empty' => true ),
         "description" => esc_html__("Link in button.", 'hosted')
      ),
    )));
}


// Data Center
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Data Center", 'hosted'),
   "base" => "datacenter",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Center List", 'hosted'),
          'value' => '',
          'param_name' => 'data',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'attach_image',
                  'value' => '',
                  'heading' => esc_html__('Photo', 'hosted'),
                  'param_name' => 'photo',
               ),
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Name', 'hosted'),
                  'param_name' => 'name',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Details', 'hosted'),
                  'param_name' => 'des',
               ),
               array(
                  'type' => 'vc_link',
                  'value' => '',
                  'heading' => esc_html__('Link Button', 'hosted'),
                  'param_name' => 'linkbox',
               ),
          )
      ),
    )));
}


// FAQs
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT FAQs", 'hosted'),
   "base" => "otfaqs",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
          'type' => 'param_group',
          'heading' => esc_html__("FAQs", 'hosted'),
          'value' => '',
          'param_name' => 'faqs',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => 'Title',
                  'param_name' => 'title',
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => 'Description',
                  'param_name' => 'des',
               ),
          )
      ),
    )
    ));
}


// Our Facts
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Fun Facts", 'hosted'),
   "base" => "facts",
   "class" => "",
   "admin_enqueue_css" => get_template_directory_uri() . '/css/vc/icon-field.css',
   "icon" => "icon-st",
   "category" => 'Hosted Element',
   "params" => array(
      array(
         "type" => "dropdown",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Style", 'hosted'),
         "param_name" => "style",
         "value" => array(                        
                     esc_html__('Style 1', 'hosted')   => 'style1',
                     esc_html__('Style 2', 'hosted')   => 'style2',
                  ),
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",
      ),
      array(
         "type" => "iconpicker",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Icon", 'hosted'),
         "param_name" => "icon",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Number", 'hosted'),
         "param_name" => "num",
         "description" => esc_html__("Number of box", 'hosted')
      ),
     
    )));
}

// Popup Video
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Popup Video", 'hosted'),
   "base" => "popupvideo",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(  
      array(
        'type' => 'textfield',
         "heading" => esc_html__("Link Video", 'hosted'),
         "param_name" => "link",         
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Title", 'hosted'),
         "param_name" => "title",
         "value" => "",
      ),
    )
   ));
}


// Portfolio Filter
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Portfolio Filter", 'hosted'),
   "base" => "portfoliof",
   "class" => "",
   "icon" => "icon-st",
   "category" => 'Hosted Element',
   "params" => array( 
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Number Show", 'hosted'),
         "param_name" => "num",
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Text Show All", 'hosted'),
         "param_name" => "all",
      ),
      array(
         "type" => "dropdown",
         "heading" => esc_html__('Column', 'hosted'),
         "param_name" => "col",
         "value" => array(
                     esc_html__('3 Columns', 'hosted')     => '3', 
                     esc_html__('4 Columns', 'hosted')     => '4',
                     esc_html__('2 Columns', 'hosted')     => '2',
                  ), 
      ),
      array(
         "type" => "checkbox",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Popup", 'hosted'),
         "param_name" => "popup",
      ),
    )));
}


// Logo Clients
if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Logo Clients", 'hosted'),
   "base" => "clients",
   "class" => "",
   "category" => 'Hosted Element',
   "icon" => "icon-st",
   "params" => array(
      array(
         "type" => "attach_images",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__('Images', 'hosted'),
         "param_name" => "gallery",
         "value" => "",
         "description" => esc_html__("Use link out for logo client by enter link input caption image, View guide here: http://vegatheme.com/images/add-link-logo.jpg , Recomended Size: 200 x 130. ", 'hosted')
      ), 
      array(
         "type" => "textfield",
         "heading" => esc_html__('Visible Number', 'hosted'),
         "param_name" => "col",
         "value" => '',
         "description" => esc_html__('Number columns each rows. Recommend: 4, 5 or 6. Default: 6.', 'hosted')
      ),     
    )
    ));
}

//Google Map

if(function_exists('vc_map')){
   vc_map( array(
   "name"      => __("OT Google Maps", 'hosted'),
   "base"      => "maps",
   "class"     => "",
   "icon" => "icon-st",
   "category"  => 'Content',
   "params"    => array(
      
      array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Latitude", 'hosted'),
         "param_name"=> "latitude",
         "value"     => 40.706187,
         "description" => __("", 'hosted')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Longitude", 'hosted'),
         "param_name"=> "longitude",
         "value"     => -74.008833,
         "description" => __("", 'hosted')
      ),     
     array(
         "type"      => "attach_image",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Location Image", 'hosted'),
         "param_name"=> "imgmap",
         "value"     => "",
         "description" => __("Upload Location Image.", 'hosted')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Zoom map number", 'hosted'),
         "param_name"=> "zoom",
         "value"     => '',
         "description" => __("", 'hosted')
      ),
     array(
         "type"      => "textfield",
         "holder"    => "div",
         "class"     => "",
         "heading"   => __("Height (px)", 'hosted'),
         "param_name"=> "height",
         "value"     => '',
         "description" => __("Ex: 400px.", 'hosted')
      ),
    )));
}

//Google Map2

if(function_exists('vc_map')){
   vc_map( array(
   "name" => esc_html__("OT Multiple Markers Map", 'hosted'),
   "base" => "ggmap2",
   "class" => "",
   "icon" => "icon-st",
   "category" => 'Content',
   "params" => array( 
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Height Map", 'hosted'),
         "param_name" => "height",
         "value" => 320,
         "description" => esc_html__("Please enter number height Map, 300, 350, 380, ..etc. Default: 420.", 'hosted')
      ),    
      array(
          'type' => 'param_group',
          'heading' => esc_html__("Address", 'hosted'),
          'value' => '',
          'param_name' => 'address',
          // Note params is mapped inside param-group:
          'params' => array(
               array(
                  'type' => 'textfield',
                  'value' => '',
                  'heading' => esc_html__('Latitude and Longitude', 'hosted'),
                  'param_name' => 'llong',
                  "description" => esc_html__("Please enter http://www.latlong.net/ Latitude,Longitude google map. Example: 39.98978,-83.00632.", 'hosted')
               ),
               array(
                  'type' => 'textarea',
                  'value' => '',
                  'heading' => esc_html__('Infomation', 'hosted'),
                  'param_name' => 'info',
               ),
          )
      ),
      array(
         "type" => "textfield",
         "holder" => "div",
         "class" => "",
         "heading" => esc_html__("Zoom Map", 'hosted'),
         "param_name" => "zoom",
         "value" => "",
         "description" => esc_html__("Please enter Zoom Map, Default: 15", 'hosted')
      ),
    array(
         "type" => "attach_image",
         "holder" => "div",
         "class" => "",
         "heading" => "Icon Map marker",
         "param_name" => "icon",
         "value" => "",
         "description" => esc_html__("Icon Map marker, 47 x 68", 'hosted')
      ),  
       
    )));

}