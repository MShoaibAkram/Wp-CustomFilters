<?php
/*
Plugin Name: My Custom Plugin
Plugin URI: https://www.google.com
Description: The first test plugin for all of my FL community
Version: 0.0.1
Author: M Shoaib Akram
Author URI: https://www.google.com
Text Domain: wp-custom-plugin
Domain Path: all
*/

//Life cycle of plugin activation deactivation and uninstall we can register hooks for these 

//define('ABSPATH') or die("Hi You idot. don't try this again");

class WpFilters{
	function __construct(){
		add_action('init', array($this, 'custom_post_type'));
	}
	
	function register(){
		add_action('admin_enqueue_scripts', array($this, 'enqueue'));
	}
	
	function activate(){
		//Add custom post type
		$this->custom_post_type();
		//Flush database and reinit it
		flush_rewrite_rules();
	}
	function deactivate(){
		
		//Flush database and reinit it
		flush_rewrite_rules();
	}
	
	function custom_post_type(){
		register_post_type('filter', ['public'=> true, 'label'=>'Filters']);
	}
	
	function enqueue(){
		//Enqueue all our scripts and css
		wp_enqueue_style('custom_filter_style', plugins_url('/assets/custom_filter_style.css', __FILE__));
	}
}

if( class_exists('WpFilters')){
	$wpFilters  = new WpFilters();
    $wpFilters->register();
	register_activation_hook(__FILE__, array($wpFilters, 'activate'));
	register_deactivation_hook(__FILE__, array($wpFilters, 'deactivate'));
}
