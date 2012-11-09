<?php

/*
 * Plugin Name: WP staff web portfolio
 * Plugin URI: https://github.com/fazleelahhee/wpMailToFriend
 * Author: Fazle Elahee
 * Description: This is a simple portfolio plugins for staff/ employee
 * version: 1.0
 * Author URI: http://careers.stackoverflow.com/fazleelahee
 * 
 *
    Staff portfolio plugins for wordpress
    Copyright (C) 2012  Fazle Elahee

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

if(!defined('ABSPATH')) {
    header("Location: /");
    exit;
}
include_once dirname( __FILE__ ).'/class-staff.php';
include_once dirname( __FILE__ ).'/class-options.php';
add_action( 'init', 'create_post_type_wp_employee_web_portfolio' );
function create_post_type_wp_employee_web_portfolio() {
	register_post_type( 'wp_emp_portfolio',
		array(
			'labels' => array(
				'name' => __( 'Staff portfolio' ),
				'singular_name' => __( 'Staff portfolio' )
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'capability_type' => 'post',
			'menu_position'=> 20,
			'supports'=>array('title','editor','thumbnail','excerpt','page-attribute','post-formats','page-attributes'),
			'has_archive' => true,
                        'rewrite' => array('slug' => 'portfolio')
		)
	);
        
}

function wp_employee_web_portfolio_flush() {
    include_once dirname( __FILE__ ).'/install.php';
    wp_staff_portfolio_install();
    create_post_type_wp_employee_web_portfolio();
    flush_rewrite_rules();
    $so = new StaffOption();
    if(!$so->isOptionSaved()) {
        $so->save(array(
        'list_page_title' => 'Staff Portfolio',
        'list_page_content' => 'Archive contents',
        'list_thumb_image' => '1',
        'list_thumb_image_height'=>'70',
        'list_thumb_image_width'=> '70',
        'list_job_title' => '1',
        'show_job_title' => '1',
        'show_address' => '1',
        'show_work_phone' => '1',
        'show_mobile' => '1',
        'show_email' => '1',
        'show_website' => '1',
        'show_thumb_image' => '1',
        'thumb_image_height' => '150',
        'thumb_image_width' => '150' 
        ));
    }
}
register_activation_hook( __FILE__, 'wp_employee_web_portfolio_flush' );

add_action( 'wp_enqueue_scripts', 'wp_employee_web_portfolio_css' );

function wp_employee_web_portfolio_css() {
    // Respects SSL, Style.css is relative to the current file
    wp_register_style( 'wp_employee_web_portfolio', plugins_url('css/staff-web-portfolio.css', __FILE__ ));
    wp_enqueue_style( 'wp_employee_web_portfolio' );
}

function get_wp_employee_web_portfolio_single_template($single_template) {
     global $post;

     if ($post->post_type == 'wp_emp_portfolio') {
          $single_template = dirname( __FILE__ ) . '/template/single-wp_emp_portfolio.php';
     }
     return $single_template;
}

add_filter( "single_template", "get_wp_employee_web_portfolio_single_template" );

function get_wp_employee_web_portfolio_archive_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'wp_emp_portfolio' ) ) {
          $archive_template = dirname( __FILE__ ) . '/template/archive-wp_emp_portfolio.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'get_wp_employee_web_portfolio_archive_template' ) ;

add_action('admin_menu', 'register_wp_portolio_options');

function register_wp_portolio_options() {
	add_submenu_page( 'edit.php?post_type=wp_emp_portfolio', 'Portfolio  Settings', 'Settings', 'manage_options', 'staff-portfolio-settings', 'portfolio_settings_callback' ); 
}

function portfolio_settings_callback() {
    	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
        
        echo '<div class="wrap">';
        include_once 'settings.php';
        echo '</div>';

}

/* Artist Details */
add_action( 'add_meta_boxes', 'employee_web_portfolio_custom_box' );

function employee_web_portfolio_custom_box() {
    add_meta_box( 
        'staff_details',
        __( 'Staff Info', 'staff_details' ),
        'employee_web_portfolio_custom_box_inner',
        'wp_emp_portfolio' 
    );
}

/* Prints the box content */

function employee_web_portfolio_custom_box_inner( $post ) {
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'staff_details_noncename' );
 
  $staff = new Staff($post->ID);
  
  ?>
			
			<table style="margin-bottom:40px">
                            <tbody>
                            <tr>
                                <th style="text-align:left;" colspan="2">
                                </th>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align:right;">Job Title:</th>
                                <td> <input value="<?php echo $staff->getProperty('position'); ?>" type="text" name="staff_position" style="width: 450px;"> </td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align:right;">Work Address:</th>
                                <td> <input value="<?php echo $staff->getProperty('address');?>" type="text" name="staff_address" style="width: 450px;"> </td>
                            </tr>
                            
                            <tr>
                                <th scope="row" style="text-align:right;">Work Phone:</th>
                                <td> <input value="<?php echo $staff->getProperty('work_phone'); ?>" type="text" name="staff_work_phone" style="width: 450px;"> </td>
                            </tr>
                             <tr>
                                <th scope="row" style="text-align:right;">Mobile:</th>
                                <td> <input value="<?php echo $staff->getProperty('mobile'); ?>" type="text" name="staff_mobile" style="width: 450px;"> </td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align:right;">Email:</th>
                                <td> <input value="<?php echo $staff->getProperty('email'); ?>" type="text" name="staff_email" style="width: 450px;"> </td>
                            </tr>
                            <tr>
                                <th scope="row" style="text-align:right;">Web site:</th>
                                <td> <input value="<?php echo $staff->getProperty('website'); ?>" type="text" name="staff_website" style="width: 450px;"> </td>
                            </tr>
                                                       
                            </tbody>
                        </table>
		
  <?php
}

add_action( 'save_post', 'staff_details_save_postdata' );

/* When the post is saved, saves our custom data */
function staff_details_save_postdata( $post_id ) {

  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( !wp_verify_nonce( $_POST['staff_details_noncename'], plugin_basename( __FILE__ ) ) )
      return;
  

  $staff = new Staff($post_id);
  $staff->save($_POST);
}

add_action('init', 'staff_options_save_init');

function staff_options_save_init(){
    if(isset($_POST['staff_portolio_options']) && $_POST['staff_portolio_options'] != '') {
        $so= new StaffOption();
        $so->save($_POST);
        echo json_encode(array('response'=>'success'));
    }
}