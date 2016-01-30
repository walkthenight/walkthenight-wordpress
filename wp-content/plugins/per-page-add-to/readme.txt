=== Per page add to head ===
Contributors: Erikvona
Plugin Name: Per page add to head
Tags: head, css, favicon
Author URI: http://evona.nl/over-mij
Author: Erik von Asmuth (Erikvona)
Requires at least: 3.5
Tested up to: 4.2.1
Stable tag: 1.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


This plugin adds content between the head tags for specific WordPress posts, or every WordPress post.

== Description ==

Ever got really annoyed how much effort it took to add style tags for just one page into the head section of a page, using WordPress? Well, I did. So I made this plugin for exactly that purpose. It just adds whatever you give it to the head tag. With a size of 8KB, and no use of any client side code, efficiency is taken care of. You can also use it to add meta tags, for SEO, auto-refresh, Google Analytics, or anything else you want to put in there.

Of course, you can also use it to add your own stylesheets and JavaScript files. Anything that normally goes in the head section is fine.

Add to head also features an option under settings to add some text inside head on every page. Ideal for favicons, Modern UI start screen icons, or style sheets if you’re too lazy to make a child theme.

Just install the plugin, activate it, make sure it is showing in your post editor by clicking screen options and checking add to head while editing a page, and add stuff!

**Warning:** Don't put stuff in the head tags that shouldn't be there! This plugin does not validate anything, and it is really easy to invalidate your HTML by making mistakes in your head tag. Don't forget to add style or script tags

== Installation ==

Installation is plain and simple

1. Add the plugin to WordPress by searching and installing, uploading a zip, FTP copy, or some other way, and activate it
1. Make sure the add to head box is visible, by checking add to head in screen options within the plugin/post editor
1. Add your head stuff to the posts!
1. You can also add head to all posts! Just use settings -> per page add to head

== Changelog ==
= 1.2.1 =
- Fixed a critical installation error introduced in version 1.2

= 1.2 =
- Added support for user roles: you can prevent certain user roles from editing the head segment. Note: administrators can't be excluded, and edit the "add head to every page" segment.
- Added support for custom post types. Note: only works when the post type is displayed "like a page"
**NOTE: when updating from an older version to version 1.2, make sure you go to settings -> per page add to head, and check the roles and post types you want to use after the update. New installations will have administrator, page and post checked automatically, old ones receiving an update won't**

= 1.1.2 =
- Changes the output order to global content first, then page specific content.
- Moves the per page add to head output down the queue on the wp_head hook, so the content is inserted at the end of the head tag

= 1.1.1 =
- Includes Spanish translation thanks to Andrew Kurtis from WebHostingHub

= 1.1 =
- Now supports l18n!
- Includes Dutch translation.

= 1.0 =
- Now uses $_SERVER superglobal to locate current page url
- Now properly preserves whitespace. Whitespace is visible in the source code, as well as in the meta box of the posts
- Compatibility with Evona Config Manager (to be released, allows you to keep this plugin from removing its config files upon deinstallation).

= 0.3 =
Fixed an issue that could occur when WordPress was hosted inside a subfolder of the domain

= 0.2 beta =
Initial release for the WordPress plugin repository


