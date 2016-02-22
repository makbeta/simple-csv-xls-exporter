=== Simple CSV/XLS Exporter ===
Contributors: Ethan Hinson, ethanhinson, mediebruket, Jany-M
Author URL: https://github.com/Jany-M/simple-csv-xls-exporter
Tags: csv, xls, export, excel, custom fields, custom post types
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

This plugin allows you to export posts to CSV or XLS, through a simple link/button, from either backend or frontend.
You can choose any post types and taxonomies (including custom ones).
as well as a list of custom field keys you wish to export. The plugin pulls the values for those fields from all instances of your chosen custom post type and provides a link to export them as a CSV file.

	You can set the default post type, with its taxonomies and custom fields, that you wish to export, from the Settings page.
After that, anytime you will use the urls `https://yoursite.com/?export=csv` for a CSV file, or `https://yoursite.com/?export=xls`, you will get that post type data.

	You must choose the post type and save the settings before you can see the taxonomies or custom fields for a custom post type. Once the page reloads, you will see the connected taxonomies and custom fields for the post type.

	If you want to export from a different post type than the one saved in these settings, also from frontend, use the url `https://yoursite.com/?export=csv&post_type=your_post_type_slug` for a CSV file, or `https://yoursite.com/?export=xls&post_type=your_post_type_slug` to get a XLS.

	When opening the exported xls, Excel will prompt the user with a warning, but the file is perfectly fine and can then be opened. Unfortunately this can't be avoided, [read more here](http://blogs.msdn.com/b/vsofficedeveloper/archive/2008/03/11/excel-2007-extension-warning.aspx).

* [Original plugin's version](https://github.com/ethanhinson/custom-csv-exporter)
* [Last forked plugin's version](https://github.com/mediebruket/custom-csv-exporter)

== Installation ==


1. Upload `simple-csv-xls-export.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Tools -> CSV/XLS Export to access the plugins settings and export files. 


== Frequently Asked Questions ==

= How do I choose my post type, taxonomies and custom fields? =

Head over to the plugin's settings page, choose the post type. Then click "Save Changes" at the end of the page.
At this point, a list of the custom taxonomies and fields associated with that post type will appear.
Choose all of the fields you wish to export (use CTRL+click to select multiple ones) and click "Save Changes" again. Then click on the "Export" buttons to get your CSV or XLS file. 

= I don't see any custom fields on the Settings page. How come? =

You mush first choose your post type and click "Save Changes" before you can see a list of the associated custom fields.
Be sure to click "Save Changes" again in order to save your choices. 

= Can I export to CSV from frontend? =
Yes, just place this URL where you want the download link/button to be: `<a class="btn" href="?export=csv">Export to CSV</a>`
This will export as per plugin Settings.

= Can I export to XLS from frontend? =
Yes, just place this URL where you want the download link/button to be: `<a class="btn" href="?export=xls">Export to XLS</a>`
This will export as per plugin Settings.

= Can I change the post type, from the frontend URL? =
Yes, use the URL var `?post_type=yourcustomposttypeslug`
Keep in mind however, that it will still look for the taxonomies and custom fields as per plugin Settings.

== Screenshots ==

1.
2.
3.

== Changelog ==

= 1 =
* Added xls support
* Fixed bug with plugin not finding taxonomies during export because launched too early `(init->wp_loaded)`

= .4 =
* Fixed issue with SYLK format (ID in capital letters gives Excel error for CSV)
* Added url parameter `&post_type`, to use in stand-alone url 

= .3 =
* Introduce taxonomy and default WordPress field export capabailities

= .2 = 
* Fixed bug that limited number of posts that could be exported

= .1 =
* Initial release of plugin