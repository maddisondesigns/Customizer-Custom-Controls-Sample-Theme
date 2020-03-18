# Customizer Custom Controls Sample Theme #

**Author:** Anthony Hortin  
**Author URI:** https://maddisondesigns.com  
**License:** GNU General Public License v2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  
**Version:** 1.0.5

## Description ##

This is a sample theme to show how to implement my Customizer Custom Controls (and the core default controls). My Customizer Controls can be found at [https://github.com/maddisondesigns/customizer-custom-controls](https://github.com/maddisondesigns/customizer-custom-controls).

This example theme shows how to incorporate Customizer functionality into your theme (or plugin), including examples of how to create Panels, Sections and how to update the Live Preview window. As well as showing the usage of the (built-in) core controls, there are also a number of Custom Controls, the details of which can be found in the abovementioned repo.

The example code in /inc/customizer.php will create a new Panel in the Customizer called **Header & Navigation** which contains three sections (Social Icons, Contact & Search). It also creates two new Sections. One called **Sample Custom Controls**, which contains examples of all the custom controls I created. The other new Section, **Default Controls**, contains examples of all the core controls that are included in WordPress.

This theme is a modified version of the default TwentyTwelve theme. The following changes have been made:

- Added customizer code and sample functions into `functions.php` (starting from line 631)  
- Added our sample social icons into `header.php`  
- Added our sample Tiny MCE content into `footer.php`  
- Added files to /inc folder which contains code for adding Customizer Panels, Sections, Settings & Controls. Also includes code for Custom Controls.  
- Added files to /js folder which contains our jQuery for our Custom Controls and for refreshing the preview for some sample controls  
- Added files to /css for styling our Customizer controls and for Font Awesome usage  
- Added /images folder which contains sample images used by several controls and an image used by the Skyrocket_Customize_Alpha_Color_Control Control  
- Added /fonts folder which contains the Font Awesome fonts. These are used to show some icons in our sample Single Accordion Control and also to show our social icons  
- Added example code to `front-page.php` template for outputting the datta from our Sample Controls and Default Controls.  

The `front-page.php` template has been modified so that it outputs all the values for our Sample Controls and Default Controls. This will show you examples of the type of data you can expect from each control. These values will dispay at the bottom of the homepage and are purely for providing examples of how to output each control.

If you'd like to learn more about Customizer development, you can check out the links to my Customizer Developer's Guide, below.

## Further Reading ##

For more details, check out my Customizer Developers Guide:  
[The WordPress Customizer – A Developers Guide (Part 1)](https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-1)  
[The WordPress Customizer – A Developers Guide (Part 2)](https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-2)

## Changelog ##

= 1.0.5 =
- Updated theme with latest version of Customizer code (1.1.4)

= 1.0.4 =
- Updated theme with latest version of Customizer code (1.1.3)

= 1.0.3 =
- Updated theme with latest version of Customizer code (1.1.2)

= 1.0.2 =
- Fixed issue with Sortable Pill Checkbox Custom Control

= 1.0.1 =
- Added new Sortable Pill Checkbox Custom Control

= 1.0.0 =
- Initial release.
