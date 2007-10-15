<?php
/*
Plugin Name: List Draft Posts
Plugin URI: http://lcb.me.uk/losingit/2007/10/14/list-draft-posts-a-wordpress-plugin
Description: Outputs a list of titles of draft posts. New improved version with an options page. 
Version: 3.0
Author: Les Bessant
Author URI: http://lcb.me.uk/losingit/
*/


/*
List Draft Posts: A simple plugin for the WordPress publishing platform.
Copyright (c) 2007 Les Bessant

Usage: add this code where you want the list of drafts to appear

<?php if (function_exists('lcb_ldp'))  lcb_ldp(); ?>



This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License along
with this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/


function lcb_ldp() {
	global $wpdb;
	
	// initialise the variables
	
	$start = get_option('lcb_ldp_start');
	$finish = get_option('lcb_ldp_finish');
	$before_heading = get_option('lcb_ldp_before_heading');
	$heading = get_option('lcb_ldp_heading');
	$after_heading = get_option('lcb_ldp_after_heading');
	$before_list = get_option('lcb_ldp_before_list');
	$after_list = get_option('lcb_ldp_after_list');
	$before_item = get_option('lcb_ldp_before_item');
	$after_item = get_option('lcb_ldp_after_item');
	$untitled = get_option('lcb_ldp_untitled');
	
	
/*	This is where we extract the draft titles - Adapted from code provided by mdawaffe in the Wordpress Forum:
	http://wordpress.org/support/topic/34503#post-195148
*/
	
	$my_drafts = $wpdb->get_results("SELECT post_title FROM $wpdb->posts WHERE post_status = 'draft'");
	if ($my_drafts) {
		$my_draft_list = $start . $before_heading . $heading .$after_heading . $before_list;
		foreach ($my_drafts as $my_draft) {
			$my_title = $my_draft->post_title;
			if ($my_title != '') {
				$my_draft_list .= $before_item . $my_title . $after_item;
			}
			else {
				$my_draft_list .= $before_item . $untitled . $after_item;
			}
		}
		$my_draft_list .= $after_list . $finish;
		echo $my_draft_list;
	}
}


function lcb_set_ldp_options(){
	add_option('lcb_ldp_start','<li>','Beginning of output');
	add_option('lcb_ldp_finish','</li>','End of output');
	add_option('lcb_ldp_before_heading','<h2>', 'Begin the heading');
	add_option('lcb_ldp_heading','Coming soon','The heading');
	add_option('lcb_ldp_after_heading','</h2>','End the heading');
	add_option('lcb_ldp_before_list','<ul>','Begin the list');
	add_option('lcb_ldp_after_list','</ul>','End the list');
	add_option('lcb_ldp_before_item','<li>','Begin each item');
	add_option('lcb_ldp_after_item','</li>','End each item');
	add_option('lcb_ldp_untitled','A mystery post','Label for untitled posts');
}

function lcb_unset_ldp_options(){
	delete_option('lcb_ldp_start');
	delete_option('lcb_ldp_finish');
	delete_option('lcb_ldp_before_heading');
	delete_option('lcb_ldp_heading');
	delete_option('lcb_ldp_after_heading');
	delete_option('lcb_ldp_before_list');
	delete_option('lcb_ldp_after_list');
	delete_option('lcb_ldp_before_item');
	delete_option('lcb_ldp_after_item');
	delete_option('lcb_ldp_untitled');
}


// Housekeeping: set the default options when the plugin is activated, and remove them when it's deactivated.

register_activation_hook(__FILE__,'lcb_set_ldp_options');
register_deactivation_hook(__FILE__,'lcb_unset_ldp_options');


// the options page

function admin_lcb_ldp_options(){
	?><div class="wrap"><h2>List Draft Post Options</h2>
	
	<p>This plugin will output a list of all draft posts. By default, it wraps the output in an unordered list item, the header in a &lt;h2&gt; and the list of post titles in an unordered list. Any drafts that do not have titles saved will be labelled with the value set below.</p>
	
	<p>Usage: add</p>
	<p><code>&lt;?php if (function_exists('lcb_ldp'))  lcb_ldp(); ?&gt; </code></p>
	
	<p>where you want the list to appear - typically in your sidebar.</p>
	
	
	<?php
	
	if($_REQUEST['submit']){
		update_lcb_ldp_options();
	}
	print_lcb_ldp_form();
	?></div><?php
}

function lcb_ldp_modify_menu(){
	add_options_page(
					'List Draft Posts',
					'List Draft Posts',
					'manage_options',
					__FILE__,
					'admin_lcb_ldp_options'
					);
}

add_action('admin_menu','lcb_ldp_modify_menu');



// check to see if anything was changed, and that the changes have been saved

function update_lcb_ldp_options(){
	$ok = false;
	
	if($_REQUEST['lcb_ldp_start']){
		update_option('lcb_ldp_start',$_REQUEST['lcb_ldp_start']);
		$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_finish']){
			update_option('lcb_ldp_finish',$_REQUEST['lcb_ldp_finish']);
			$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_before_heading']){
				update_option('lcb_ldp_before_heading',$_REQUEST['lcb_ldp_before_heading']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_heading']){
				update_option('lcb_ldp_heading',$_REQUEST['lcb_ldp_heading']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_after_heading']){
				update_option('lcb_ldp_after_heading',$_REQUEST['lcb_ldp_after_heading']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_before_list']){
				update_option('lcb_ldp_before_list',$_REQUEST['lcb_ldp_before_list']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_after_list']){
				update_option('lcb_ldp_after_list',$_REQUEST['lcb_ldp_after_list']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_before_item']){
				update_option('lcb_ldp_before_item',$_REQUEST['lcb_ldp_before_item']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_after_item']){
				update_option('lcb_ldp_after_item',$_REQUEST['lcb_ldp_after_item']);
				$ok = true;
	}
	
	if($_REQUEST['lcb_ldp_untitled']){
				update_option('lcb_ldp_untitled',$_REQUEST['lcb_ldp_untitled']);
				$ok = true;
	}
	
	
	if($ok){
		?><div id="message" class="updated fade">
			<p>Options saved.</p>
		</div><?php
	}
	
	else{
		?><div id="message" class="error fade">
			<p>Failed to save options</p>
		</div><?php
	}
}

// form on the options page

function print_lcb_ldp_form(){
	$default_start = get_option('lcb_ldp_start');
	$default_finish = get_option('lcb_ldp_finish');
	$default_before_heading = get_option('lcb_ldp_before_heading');
	$default_heading = get_option('lcb_ldp_heading');
	$default_after_heading = get_option('lcb_ldp_after_heading');
	$default_before_list = get_option('lcb_ldp_before_list');
	$default_after_list = get_option('lcb_ldp_after_list');
	$default_before_item = get_option('lcb_ldp_before_item');
	$default_after_item = get_option('lcb_ldp_after_item');
	$default_untitled = get_option('lcb_ldp_untitled');	
	?>
	
	<form method="post">
	<?php
	if ( function_exists('wp_nonce_field') )
		wp_nonce_field('lcb_ldp-update-options_main');
?>
	<table class="optiontable">
	<tr><td><label for="lcb_ldp_start">Beginning of output:</td>
		<td><input type="text" name="lcb_ldp_start" value="<?=$default_start?>" />
	</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_finish">End of output:</td>
			<td><input type="text" name="lcb_ldp_finish" value="<?=$default_finish?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_before_heading">Begin heading with:</td>
			<td><input type="text" name="lcb_ldp_before_heading" value="<?=$default_before_heading?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_heading">Heading:</td>
			<td><input type="text" name="lcb_ldp_heading" value="<?=$default_heading?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_after_heading">End heading with:</td>
			<td><input type="text" name="lcb_ldp_after_heading" value="<?=$default_after_heading?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_before_list">Beginning of item list:</td>
			<td><input type="text" name="lcb_ldp_before_list" value="<?=$default_before_list?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_after_list">End of item list:</td>
			<td><input type="text" name="lcb_ldp_after_list" value="<?=$default_after_list?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_before_item">Precede each item with:</td>
			<td><input type="text" name="lcb_ldp_before_item" value="<?=$default_before_item?>" />
		</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_after_item">Follow each item with:</td>
				<td><input type="text" name="lcb_ldp_after_item" value="<?=$default_after_item?>" />
			</label>
	</td></tr>
	<tr><td><label for="lcb_ldp_untitled">Description for untitled drafts:</td>
				<td><input type="text" name="lcb_ldp_untitled" value="<?=$default_untitled?>" />
			</label>
	</td></tr>
	<tr><td><input type="submit" name="submit" value="Update options" /></td><td>&nbsp;</td></tr>
	</table>
	<?php
}
	
	
// that's it	

?>