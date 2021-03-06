=== List Draft Posts ===
Contributors: LesBessant
Donate link: http://lcb.me.uk/losingit/donations/
Tags: draft, drafts, sidebar 
Requires at least: 2.0.2
Tested up to: 3.0-Alpha
Stable tag: 3.0.1

This plugin is no longer being developed or tested.

== Description ==

List Draft Posts is a simple plugin which outputs a list of the titles of all posts currently saved as drafts. An options page allows configuration of the output. Its default options will put everything in an unordered list item, the heading in &lt;h2&gt; tags, and the list of posts as an unordered list. 

The options page allows the user to change the markup used to suit other layouts, and to change the heading and the text used to describe posts saved without a title.

When deactivated, the plugin will clear its options.

Typical use would be in your sidebar, where you can now have a list of forthcoming items as a "teaser" for your readers, or as a reminder to authors that they really need to finish those posts they started. It will probably not be of interest to many people, but I like it.

== Installation ==


1. Upload `lcb_list_draft_posts.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Make any changes you require to the *List Draft Posts* page under the *Options* menu in WordPress
4. Place `<?php if (function_exists('lcb_ldp')) lcb_ldp(); ?>` in a template file, most likely sidebar.php

== Frequently Asked Questions ==

= Widget? =

See my <a href="http://wordpress.org/extend/plugins/list-drafts-widget/">List Drafts Widget</a> for the same thing in a more widgety form.

= Can you add a feature? =



I will not be making any further changes to this plugin. Anyone is more than welcome to create a more sophisticated and more useful version.



== Changelog ==



= 3.0.1 = 

* Minor edits, confirming as final version and that it works up to v3.0-Alpha

= 3.0 =


* First full release




== Screenshots ==

1. The options page, showing the default values
2. Sample output

