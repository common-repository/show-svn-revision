<?php
/*
Plugin Name: Show SVN Revision
Plugin URI: http://wordpress.org/extend/plugins/show-svn-revision/
Description: Display the SVN revision you're running in the admin footer
Author: Dan Coulter
Version: 0.2
Author URI: http://dancoulter.com
*/

/** 
 * Copyright 2008  Dan Coulter (dan@blogsforbands.com)
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You can get a copy of this license here: http://www.gnu.org/licenses/gpl-2.0.html
 * And a (more) human readable copy here: http://creativecommons.org/licenses/GPL/2.0/
 */

function cm_show_svn_display() {
	if ( !get_option('show-svn-tooltip-only') && is_file(ABSPATH . '.svn/entries') ) {
		$file = file(ABSPATH . '.svn/entries');
		echo 'SVN Path: <a href="' . attribute_escape(trim($file[4])) . '">' . strip_tags(trim($file[4])) . '</a> | Revision: ' . strip_tags($file[3]) . '<br />';
	}
}

function cm_show_svn_tooltip($text) {
	if ( is_file(ABSPATH . '.svn/entries') ) {
		$file = file(ABSPATH . '.svn/entries');
		$text = preg_replace('|(version )([^ ]*)|i', '\\1<span title="You are running SVN revision ' . attribute_escape(trim($file[3])) . '">\\2</span>', $text);
	}
	return $text;
}

function cm_show_svn_activation() {
	if ( get_option('show-svn-tooltip-only') === false ) {
		add_option('show-svn-tooltip-only', 0);
	}
}

add_action('in_admin_footer', 'cm_show_svn_display');
add_filter('update_footer', 'cm_show_svn_tooltip', 11);
register_activation_hook( __FILE__, 'cm_show_svn_activation' );

?>
