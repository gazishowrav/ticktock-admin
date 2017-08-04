<?php
/*
Plugin Name: Tick Tock Admin
Description: Tick Tock WordPress admin customisations.
*/

//
//  REMOVE DEFAULT DASHBOARD WIDGETS
//––––––––––––––––––––––––––––––––––––––––––––––––––

function remove_dashboard_widgets() {
  global $wp_meta_boxes;
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
  unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
  unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


//
//  CUSTOM DASHBOARD WIDGETS
//––––––––––––––––––––––––––––––––––––––––––––––––––

// This function is hooked into the 'wp_dashboard_setup' action below.
function ticktock_add_dashboard_widgets() {

  wp_add_dashboard_widget(
    'ticktock_pages',         // Widget slug.
    'Pages',         // Title.
    'ticktock_pages_function' // Display function.
  );  
}
add_action( 'wp_dashboard_setup', 'ticktock_add_dashboard_widgets' );

// Create the function to output the contents of our Dashboard Widget.
function ticktock_pages_function() {

  // Exclude irrelevant post types.
  $post_type_exclusions = array(
    'attachment',
    'revision',
    'nav_menu_item',
    'custom_css',
    'customize_changeset',
    'acf-field-group',
    'acf-field'
  );


  // Find all post types.
  foreach (get_post_types( '', 'objects' ) as $post_type) {

    $exclude_flag = false;
    $post_type_name = null;
    $post_type_name = $post_type->name;
    $menu_icon = null;

    // Loop through excluded post types.
    foreach ( $post_type_exclusions as $post_type_exclusion ) {

      // If the current post type matches an excluded post type.
      if ( $post_type_exclusion == $post_type_name ) {

        // Make sure it is ignored.
        $exclude_flag = true;
      }
    }

    // If the current post type should not be ignored.
    if ( $exclude_flag == false ) {

      echo '<p>' . $post_type->name . '<br>';

      // If it's a post.
      if ( $post_type_name == 'post' ) {
        $menu_icon = 'dashicons-admin-post';

      // If it's a page.
      } else if ( $post_type_name == 'page' ) {
        $menu_icon = 'dashicons-admin-page';

      // If it's any other kind of custom post type.
      } else {
        $menu_icon = $post_type->menu_icon;
      }
      // echo 'menu icon: ' . $menu_icon;
      echo '<div class="dashicons-before ' . $menu_icon . '"></div>';
      echo '</p>';
    }
  }



  global $wp_post_types;
  $page_obj = $wp_post_types['testimonials'];
  // $page_name =  $page_obj->labels->singular_name;

  // echo '<pre>';
    // print_r($page_obj);
  // echo '</pre>';

  $page_menu_icon = $page_obj->menu_icon;
  // echo $page_menu_icon;

  $page_output = '';

  $page_output .= '<div class="main">';
    $page_output .= '<a href="" class="button button-hero">';
      $page_output .= '<div class="dashicons-before dashicons-admin-page"></div>';
      $page_output .= 'Create Page';
    $page_output .= '</a>';
  $page_output .= '</div>';

  // echo $page_output; 
}


//
//––––––––––––––––––––––––––––––––––––––––––––––––––
//  CUSTOM ADMIN CSS
//––––––––––––––––––––––––––––––––––––––––––––––––––
//
function ticktock_load_custom_wp_admin_style(){
    // wp_register_style( 'custom_wp_admin_css', plugin_dir_path( __FILE__ ) . 'css/admin.css', false, '1.0.0' );
    wp_register_style( 'custom_wp_admin_css', plugins_url('/css/admin.css', __FILE__), false, '1.0.0' );
    wp_enqueue_style( 'custom_wp_admin_css' );
}
add_action('admin_enqueue_scripts', 'ticktock_load_custom_wp_admin_style');


/* Stop Adding Functions Below this Line */
?>