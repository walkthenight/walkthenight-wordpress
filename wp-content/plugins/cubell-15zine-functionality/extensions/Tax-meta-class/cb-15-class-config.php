<?php
require_once("Tax-meta-class.php");
if ( is_admin() ){
  $prefix = 'cb_';

  $config = array(
    'id' => 'cb_cat_meta',          // meta box id, unique per meta box
    'title' => 'Category Extra Meta',          // meta box title
    'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );

  $cb_cat_meta =  new Tax_Meta_Class($config);
  $cb_cat_meta->addSelect($prefix.'cat_style_field_id',array('style-a'=>'Blog Style A','style-b'=>'Blog Style B','style-c'=>'Blog Style C (No sidebar)','style-d'=>'Blog Style D','style-e'=>'Blog Style E','style-f'=>'Combo A + D','style-g'=>'Combo B + D','style-h'=>'Blog Style Grid','style-i'=>'Blog Style Grid (No sidebar)'),array('name'=> __('Blog Style ','tax-meta'), 'std'=> array('style-a')));
  $cb_cat_meta->addSelect($prefix.'cat_infinite',array('cb-off'=>'Number Pagination','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> 'Infinite Scroll', 'std'=> array('cb-off') ) );
  $cb_cat_meta->addColor($prefix.'color_field_id',array('name'=> __('Category Global Color','tax-meta'), 'desc'=> 'This color is used on menu hover and review colors. '));
  $cb_cat_meta->addSelect($prefix.'cat_featured_op',array('Off' => 'Off', 's-1fw'=>'Full-screen Slider (1 post)', 's-1'=>'Full-Width Slider (1 post)', 's-2'=>'Slider (2 Posts)', 's-3'=>'Full-Width Slider (3 Posts)', 'grid-3'=>'Grid - 3', 'grid-4'=>'Grid - 4','grid-5'=> 'Grid - 5','grid-6'=> 'Grid - 6' ),array('name'=>  'Show grid or slider ', 'std'=> array('Off'), 'desc'=> 'Show a grid or slider of posts above the blog style posts list on the category page.'));
  $cb_cat_meta->addSelect($prefix.'cat_offset',array('on'=>'On', 'off'=>'Off'),array('name'=> __('Offset Posts ','tax-meta'), 'std'=> array('on'),  'desc'=> 'This option will offset the posts so you do not have duplicate posts in the grid + blog list below.'));
  $cb_cat_meta->addSelect($prefix.'cat_sidebar',array('off'=>'Off','on'=>'On'),array('name'=> __('Custom Sidebar ','tax-meta'), 'std'=> array('off'), 'desc'=> 'This option allows you to use a unique sidebar for this category, when enabled, you will find a new sidebar area with the category name in Appearance -> Widgets.' ));
  $cb_cat_meta->addSelect($prefix.'cat_sidebar_location',array('sidebar'=>'Right','sidebar_left'=>'Left'),array('name'=> __('Sidebar Location','tax-meta'), 'std'=> array('cb-sidebar-right'), 'desc'=> 'This option allows you to put the sidebar on the category page on the left or right (only applies on blog styles with sidebars).' ));
  $cb_cat_meta->addImage($prefix.'bg_image_field_id',array('name'=> __('Category Background Image ','tax-meta')));
  $cb_cat_meta->addSelect($prefix.'bg_image_setting_op',array('1' => 'Fit Screen', '2'=>'Repeat', '3'=>'No-Repeat'),array('name'=> 'Background Image Settings', 'std'=> array('1')));
  $cb_cat_meta->addColor($prefix.'bg_color_field_id',array('name'=> __('Category Background Color','tax-meta')));
  $cb_cat_meta->addWysiwyg($prefix.'cat_ad',array('name'=> __('Category Ad','tax-meta')));
  $cb_cat_meta->Finish();

  $config = array(
    'id' => 'cb_tag_meta',          // meta box id, unique per meta box
    'title' => 'Tags Extra Meta',          // meta box title
    'pages' => array('post_tag'),        // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),            // list of meta fields (can be added by field arrays)
    'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );

   $cb_tag_meta =  new Tax_Meta_Class($config);
   $cb_tag_meta->addSelect($prefix.'cat_style_field_id',array('style-a'=>'Blog Style A','style-b'=>'Blog Style B','style-c'=>'Blog Style C (No sidebar)','style-d'=>'Blog Style D','style-e'=>'Blog Style E','style-f'=>'Combo A + D','style-g'=>'Combo B + D','style-h'=>'Blog Style Grid','style-i'=>'Blog Style Grid (No sidebar)'),array('name'=> __('Blog Style ','tax-meta'), 'std'=> array('style-a')));
  $cb_tag_meta->addSelect($prefix.'cat_style_color',array('cb-light-blog'=>'Light','cb-dark-blog'=>'Dark'),array('name'=> __('Blog Style Colors ','tax-meta'), 'std'=> array('cb-light-blog')));
  $cb_tag_meta->addSelect($prefix.'cat_infinite',array('cb-off'=>'Number Pagination','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> 'Infinite Scroll', 'std'=> array('cb-off') ) );
  $cb_tag_meta->addSelect($prefix.'cat_featured_op',array('Off' => 'Off', 's-1fw'=>'Full-screen Slider (1 post)', 's-1'=>'Full-Width Slider (1 post)', 's-2'=>'Slider (2 Posts)', 's-3'=>'Full-Width Slider (3 Posts)', 'grid-3'=>'Grid - 3', 'grid-4'=>'Grid - 4','grid-5'=> 'Grid - 5','grid-6'=> 'Grid - 6' ),array('name'=>  'Show grid or slider ', 'std'=> array('Off'), 'desc'=> 'Show a grid or slider of posts above the blog style posts list on the tag page.'));
  $cb_tag_meta->addSelect($prefix.'cat_offset',array('on'=>'On', 'off'=>'Off'),array('name'=> __('Offset Posts ','tax-meta'), 'std'=> array('on'),  'desc'=> 'This option will offset the posts so you do not have duplicate posts in the grid + blog list below.'));
  $cb_tag_meta->addImage($prefix.'bg_image_field_id',array('name'=> __('Tag Background Image ','tax-meta')));
  $cb_tag_meta->addSelect($prefix.'bg_image_setting_op',array('1' => 'Full-Width Stretch', '2'=>'Repeat', '3'=>'No-Repeat'),array('name'=> __('Background Image Settings','tax-meta'), 'std'=> array('1')));
  $cb_tag_meta->addColor($prefix.'bg_color_field_id',array('name'=> __('Tag Background Color','tax-meta')));
  $cb_tag_meta->addWysiwyg($prefix.'cat_ad',array('name'=> __('Tag Ad','tax-meta')));
  $cb_tag_meta->Finish();

}