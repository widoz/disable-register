=== Disable Register ===
Contributors: wido
Tags: register, login, disable
Requires at least: 5.1
Requires PHP: 7.1
Tested up to: 5.1.1
Stable tag: 2.0.2
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Disable registration through the wp-login page.

== Description ==

Disable the user registration through the wp-login.php page, also redirect all actions like lostpassword, resetpass etc...

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the plugin files to the `/wp-content/plugins/disable-register` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Plugin Name screen to configure the plugin
1. (Make your instructions match the desired user flow for activating and installing your plugin. Include any steps that might be needed for explanatory purposes)

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 2.0.2 =
* Fix: Indefined index `action` in REQUEST

= 2.0.1 =
* Fix: Compatibility with WordPress not allowing php 7.1 in the repo because of a commit pre-hook

= 2.0.0 =
* Complete Refactor

= 1.0.0 =
* Initial Release
