<?php

/**
 * Define our settings sections
 *
 * array key=$id, array value=$title in: add_settings_section( $id, $title, $callback, $page );
 * @return array
 */
function DrTheme_options_page_sections() {
	$sections = array();
	$sections['general_section']	= __('General setting Options', 'drtheme');
	return $sections;
}

/**
 * Define our form fields (options) 
 *
 * @return array
 */
function DrTheme_options_page_fields() {
	
	$options[] = array(
		"section" => "general_section",
		"id"      => DRTHEME_SHORTNAME . "_enable_sidebar_front_page",
		"title"   => __( 'Display Sidebar on Front Page', 'drtheme' ),
		"desc"    => __( 'Enable Sidebar on Front page.', 'drtheme' ),
		"type"    => "checkbox",
		"std"     => 1,
	);

	return $options;
}

/**
 * Contextual Help
 */
function DrTheme_options_page_contextual_help() {
	$text 	= "<h3>" . __('DrTheme Settings - Contextual Help','drtheme') . "</h3>";
	$text 	.="<p>" . __('Please fell free to ask me. <a href="mailto:rachmat.yanuarsyah@gmail.com?Subject=ask%20help%20for%20DrTheme" target="_top">rachmat.yanuarsyah@gmail.com.</a>','drtheme') . "</p>";

	return $text;
}