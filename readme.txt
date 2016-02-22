=== Simple CSV/XLS Exporter ===
Contributors: Ethan Hinson, ethanhinson, mediebruket, Jany-M
Author URL: https://github.com/Jany-M/simple-csv-xls-exporter
Tags: csv, xls, export, excel, custom fields, custom post types
Tested up to: 4.4.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Original author URL: https://github.com/ethanhinson/custom-csv-exporter
Forke from: https://github.com/mediebruket/custom-csv-exporter

== Description ==

This plugin allows you to export posts to CSV or XLS. You can choose any post types and taxonomies (including custom ones).
as well as a list of custom field keys you wish to export. The plugin pulls the values for those fields from all instances of your chosen custom post type and provides a link to export them as a CSV file. 


== Installation ==


1. Upload `wp-ccsve.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings -> Custom CSV to access the plugins settings. 


== Frequently Asked Questions ==

= How do I choose my post type and custom fields? =

First, choose the post type you wish to export from the plugin's Settings page. Then click "Save Changes." At this point, a list of the custom fields associated with that post type will appear. Choose all of the fields you wish to export and click "Save Changes" again. Then click "Export" to get your CSV file. 

= I don't see any custom fields on the Settings page. How come? =

In the current version of the plugin, you mush first choose your post type and click "Save Changes" before you can see a list of the associated custom fields. Be sure to click "Save Changes" again in order to save your choices. 

= Can I export to CSV from frontend? =
Yes, just place this URL where you want the download link/button to be: `<a class="btn" href="?export=csv">Export to CSV</a>`
This will export as per plugin Settings.

= Can I export to XLS from frontend? =
Yes, just place this URL where you want the download link/button to be: `<a class="btn" href="?export=xls">Export to XLS</a>`
This will export as per plugin Settings.

= Can I change the post type, from the frontend URL? =
Yes, use the URL var `?post_type=yourcustomposttypeslug`
Keep in mind however, that it will still look for the taxonomies and custom fields as per plugin Settings.

== Changelog ==

= 1 =
Added xls support
Fixed bug with plugin not finding taxonomies during export because launched too early (init->wp_loaded)

= .4 =
Fixed issue with SYLK format (ID in capital letters gives Excel error for CSV)
Added url parameter post_type, to use in stand-alone url 

= .3 =
Introduce taxonomy and default WordPress field export capabailities.
= .2 = 
*Fixed bug that limited number of posts that could be exported

=======
= .2 =
*Fixed bug that limited number of posts that could be exported

= .1 =
* Initial release of plugin. 