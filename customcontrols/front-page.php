<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-page-image">
						<?php the_post_thumbnail(); ?>
					</div><!-- .entry-page-image -->
				<?php endif; ?>

				<?php get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php
				echo '<div class="entry-content">'; 

				echo '<h2>Customizer Settings</h2>';
				echo '<p>To see examples of how to use your controls in your theme, have a look at the <code>front-page.php</code> template.</p>';
				echo '<p>These are the settings currently saved in the <strong>Sample Custom Controls</strong> and <strong>Default Controls</strong> Customizer Sections.</p>';
				echo '<h2>Sample Custom Controls</h2>';
				echo '<p>';
				echo '<strong>sample_toggle_switch</strong> = ' . get_theme_mod( 'sample_toggle_switch' ) . '</br>';
				echo '<strong>sample_slider_control</strong> = ' . get_theme_mod( 'sample_slider_control' ) . '</br>';
				echo '<strong>sample_slider_control_small_step</strong> = ' . get_theme_mod( 'sample_slider_control_small_step' ) . '</br>';
				echo '<strong>sample_sortable_repeater_control</strong> = ' . get_theme_mod( 'sample_sortable_repeater_control' ) . '</br>';
				echo '<strong>sample_image_radio_button</strong> = ' . get_theme_mod( 'sample_image_radio_button' ) . '</br>';
				echo '<strong>sample_image_radio_button</strong> = ' . get_theme_mod( 'sample_image_radio_button' ) . '</br>';
				echo '<strong>sample_text_radio_button</strong> = ' . get_theme_mod( 'sample_text_radio_button' ) . '</br>';
				echo '<strong>sample_alpha_color</strong> = ' . get_theme_mod( 'sample_alpha_color' ) . '</br>';
				echo '<strong>sample_wpcolorpicker_alpha_color</strong> = ' . get_theme_mod( 'sample_wpcolorpicker_alpha_color' ) . '</br>';
				echo '<strong>sample_wpcolorpicker_alpha_color2</strong> = ' . get_theme_mod( 'sample_wpcolorpicker_alpha_color2' ) . '</br>';
				echo '<strong>sample_pill_checkbox</strong> = ' . get_theme_mod( 'sample_pill_checkbox' ) . '</br>';
				echo '<strong>sample_pill_checkbox2</strong> = ' . get_theme_mod( 'sample_pill_checkbox2' ) . '</br>';
				echo '<strong>sample_pill_checkbox3</strong> = ' . get_theme_mod( 'sample_pill_checkbox3' ) . '</br>';
				echo '<strong>sample_dropdown_select2_control_single</strong> = ' . get_theme_mod( 'sample_dropdown_select2_control_single' ) . '</br>';
				echo '<strong>sample_dropdown_select2_control_multi</strong> = ' . get_theme_mod( 'sample_dropdown_select2_control_multi' ) . '</br>';
				echo '<strong>sample_dropdown_posts_control</strong> = ' . get_theme_mod( 'sample_dropdown_posts_control' ) . '</br>';
				echo '<strong>sample_tinymce_editor</strong> = ' . wpautop( get_theme_mod( 'sample_tinymce_editor' ) ) . '</br>';
				echo '<strong>sample_google_font_select</strong> = ' . get_theme_mod( 'sample_google_font_select' ) . '</br>';
				echo '</p>';

				echo '<h2>Default Controls</h2>';
				echo '<p>';
				echo '<strong>sample_default_text</strong> = ' . get_theme_mod( 'sample_default_text' ) . '</br>';
				echo '<strong>sample_email_text</strong> = ' . get_theme_mod( 'sample_email_text' ) . '</br>';
				echo '<strong>sample_url_text</strong> = ' . get_theme_mod( 'sample_url_text' ) . '</br>';
				echo '<strong>sample_number_text</strong> = ' . get_theme_mod( 'sample_number_text' ) . '</br>';
				echo '<strong>sample_hidden_text</strong> = ' . get_theme_mod( 'sample_hidden_text' ) . '</br>';
				echo '<strong>sample_date_text</strong> = ' . get_theme_mod( 'sample_date_text' ) . '</br>';
				echo '<strong>sample_default_checkbox</strong> = ' . get_theme_mod( 'sample_default_checkbox' ) . '</br>';
				echo '<strong>sample_default_select</strong> = ' . get_theme_mod( 'sample_default_select' ) . '</br>';
				echo '<strong>sample_default_radio</strong> = ' . get_theme_mod( 'sample_default_radio' ) . '</br>';
				echo '<strong>sample_default_dropdownpages</strong> = ' . get_theme_mod( 'sample_default_dropdownpages' ) . '</br>';
				echo '<strong>sample_default_textarea</strong> = ' . get_theme_mod( 'sample_default_textarea' ) . '</br>';
				echo '<strong>sample_default_color</strong> = ' . get_theme_mod( 'sample_default_color' ) . '</br>';
				echo '<strong>sample_default_media</strong> = ' . get_theme_mod( 'sample_default_media' ) . '</br>';
				echo '<strong>sample_default_image</strong> = ' . get_theme_mod( 'sample_default_image' ) . '</br>';
				echo '<strong>sample_default_cropped_image</strong> = ' . get_theme_mod( 'sample_default_cropped_image' ) . '</br>';
				echo '<strong>sample_date_only</strong> = ' . get_theme_mod( 'sample_date_only' ) . '</br>';
				echo '<strong>sample_date_time</strong> = ' . get_theme_mod( 'sample_date_time' ) . '</br>';
				echo '<strong>sample_date_time_no_past_date</strong> = ' . get_theme_mod( 'sample_date_time_no_past_date' ) . '</br>';
				echo '</p>';

				echo '</div>'; 
			?>
				
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>
