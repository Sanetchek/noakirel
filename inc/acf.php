<?php
add_action('init', function() {
	// Create Theme Options Page
	if(function_exists('acf_add_options_page')) {
		// Main Theme Options Page
		acf_add_options_page(array(
			'page_title' 	=> 'Noakirel Settings',
			'menu_title'	=> 'Noakirel Settings',
			'menu_slug' 	=> 'noakirel-general-settings',
			'position'   	=> 2,
			'capability'	=> 'edit_posts',
			'icon_url' 		=> 'dashicons-admin-generic',
			'redirect'		=> true
		));

		// Header Subpage
		acf_add_options_page(array(
			'page_title' 	=> 'Header Settings',
			'menu_title'	=> 'Header',
			'menu_slug' 	=> 'noakirel-header-settings',
			'capability'	=> 'edit_posts',
			'parent_slug'	=> 'noakirel-general-settings',
			'redirect'		=> false
		));

		// Footer Subpage
		acf_add_options_page(array(
			'page_title' 	=> 'Footer Settings',
			'menu_title'	=> 'Footer',
			'menu_slug' 	=> 'noakirel-footer-settings',
			'capability'	=> 'edit_posts',
			'parent_slug'	=> 'noakirel-general-settings',
			'redirect'		=> false
		));
	}
});