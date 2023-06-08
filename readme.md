# Customizer Custom Controls Sample Theme #

**Author:** Anthony Hortin  
**Author URI:** https://maddisondesigns.com  
**License:** GNU General Public License v2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  
**Version:** 1.2.0

## Description ##

This is a sample theme to show how to implement my Customizer Custom Controls (and the core default controls). My Customizer Controls can be found at [https://github.com/maddisondesigns/customizer-custom-controls](https://github.com/maddisondesigns/customizer-custom-controls).

This example theme shows how to incorporate Customizer functionality into your theme (or plugin), including examples of how to create Panels, Sections and how to update the Live Preview window. As well as showing the usage of the (built-in) core controls, there are also a number of Custom Controls, the details of which can be found in the abovementioned repo.

The example code in /inc/customizer.php will:  

- Creates a new Panel in the Customizer called **Typography** which contains three sections (Body Text, All Headings & Heading 1 (H1)).  
- Creates a new Panel in the Customizer called **Header & Navigation** which contains three sections (Social Icons, Contact & Search).  
- Creates a new section called **Sample Custom Controls** which contains examples of all the custom controls I created.  
- Creates a new section called **Default Controls** which contains examples of all the core controls that are included in WordPress.

This theme is a modified version of the default TwentyTwelve theme. The following changes have been made:

- Added customizer code and sample functions into `functions.php` (starting from line 631). Also includes an example of using the `skyrocket_social_icons_list` filter for adding extra icons to the social icons list  
- Added our sample social icons into `header.php`  
- Added our sample Tiny MCE content into `footer.php`  
- Added files to /inc folder which contains code for adding Customizer Panels, Sections, Settings & Controls. Also includes code for Custom Controls.  
- Added files to /js folder which contains our jQuery for our Custom Controls and for refreshing the preview for some sample controls  
- Added files to /css for styling our Customizer controls and for Font Awesome usage  
- Added /images folder which contains sample images used by several controls and an image used by the Skyrocket_Customize_Alpha_Color_Control Control  
- Added /fonts folder which contains the Font Awesome fonts. These are used to show some icons in our sample Single Accordion Control and also to show our social icons  
- Added example code to `front-page.php` template for outputting the data from our Sample Controls and Default Controls.  
- Customizer Typography settings will control the main body text, & headings within the theme.  
- Customizer Header & Navigation settings add the social icons & contact information in the theme header and the search icon will be appended to the main menu.  
- If the WooCommerce plugin is active a **WooCommerce Layout** Panel will be created with some example controls.  

The `front-page.php` template has been modified so that it outputs all the values for our Sample Controls Section and Default Controls Section. This will show you examples of the type of data you can expect from each control. These values will dispay at the bottom of the homepage and are purely for providing examples of how to output each control.

If you'd like to learn more about Customizer development, you can check out the links to my Customizer Developer's Guide, below.

## Further Reading ##

For more details, check out my Customizer Developers Guide:  
[The WordPress Customizer – A Developers Guide (Part 1)](https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-1)  
[The WordPress Customizer – A Developers Guide (Part 2)](https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-2)

## Changelog ##

= 1.2.0 =
- Updated theme with latest version of Customizer code (1.3.0) which includes new Divider Control
- Update Font Awesome to v6.4.0

= 1.1.3 =
- Updated theme with latest version of Customizer code (1.2.2)

= 1.1.2 =
- Updated theme with latest version of Customizer code (1.2.1)

= 1.1.1 =
- Updated theme with latest version of Customizer code (1.1.8)

= 1.1.0 =
- Updated theme with latest version of Customizer code (1.1.7)
- Updated Customizer Typography settings to show an example of how you can use the Google Font control
- Updated Readme description to better describe theme changes

= 1.0.7 =
- Updated theme with latest version of Customizer code (1.1.6)

= 1.0.6 =
- Updated theme with latest version of Customizer code (1.1.5)

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
