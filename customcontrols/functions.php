<?php
/**
 * Twenty Twelve functions and definitions
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see https://codex.wordpress.org/Theme_Development and
 * https://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, @link https://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) {
	$content_width = 625;
}

/**
 * Twenty Twelve setup.
 *
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 *  custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentytwelve
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentytwelve' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentytwelve' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support(
		'custom-background', array(
			'default-color' => 'e6e6e6',
		)
	);

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'twentytwelve_setup' );

/**
 * Add support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * The use of Open Sans by default is localized. For languages that use
 * characters not supported by the font, the font can be disabled.
 *
 * @since Twenty Twelve 1.2
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function twentytwelve_get_font_url() {
	$fonts_url = '';
	$subsets = 'latin';
	$defaults = skyrocket_generate_defaults();

	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$bodyFont = json_decode( get_theme_mod( 'sample_body_text_font', $defaults['sample_body_text_font'] ), true );

	/* translators: If there are characters in your language that are not supported by Dosis, translate this to 'off'.
	 * Do not translate into your own language.
	 */
	$headerFont = json_decode( get_theme_mod( 'sample_heading_font', $defaults['sample_heading_font'] ), true );

	if ( 'off' !== $bodyFont || 'off' !== $headerFont ) {
		$font_families = array();

		if ( 'off' !== $bodyFont )
			$font_families[] = $bodyFont['font'] . ':' . $bodyFont['regularweight'] . ',' . $bodyFont['italicweight'] . ',' . $bodyFont['boldweight'];

		if ( 'off' !== $headerFont )
			$font_families[] = $headerFont['font'] . ':' . $headerFont['regularweight'] . ',' . $headerFont['italicweight'] . ',' . $headerFont['boldweight'];

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( $subsets ),
			'display' => urlencode( 'fallback' ),
		);
		$fonts_url = add_query_arg( $query_args, "https://fonts.googleapis.com/css" );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Enqueue scripts and styles for front end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Adds JavaScript for handling the navigation menu hide-and-show behavior.
	wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140711', true );

	$font_url = twentytwelve_get_font_url();
	if ( ! empty( $font_url ) ) {
		wp_enqueue_style( 'twentytwelve-fonts', esc_url_raw( $font_url ), array(), null );
	}

	// Loads our main stylesheet.
	wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentytwelve-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentytwelve-style' ), '20121010' );
	$wp_styles->add_data( 'twentytwelve-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Twelve 2.2
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function twentytwelve_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentytwelve_resource_hints', 10, 2 );

/**
 * Filter TinyMCE CSS path to include Google Fonts.
 *
 * Adds additional stylesheets to the TinyMCE editor if needed.
 *
 * @uses twentytwelve_get_font_url() To get the Google Font stylesheet URL.
 *
 * @since Twenty Twelve 1.2
 *
 * @param string $mce_css CSS path to load in TinyMCE.
 * @return string Filtered CSS path.
 */
function twentytwelve_mce_css( $mce_css ) {
	$font_url = twentytwelve_get_font_url();

	if ( empty( $font_url ) ) {
		return $mce_css;
	}

	if ( ! empty( $mce_css ) ) {
		$mce_css .= ',';
	}

	$mce_css .= esc_url_raw( str_replace( ',', '%2C', $font_url ) );

	return $mce_css;
}
add_filter( 'mce_css', 'twentytwelve_mce_css' );

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Main Sidebar', 'twentytwelve' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'First Front Page Widget Area', 'twentytwelve' ),
			'id'            => 'sidebar-2',
			'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => __( 'Second Front Page Widget Area', 'twentytwelve' ),
			'id'            => 'sidebar-3',
			'description'   => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
	/**
	 * Displays navigation to next/previous pages when applicable.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_content_nav( $html_id ) {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) : ?>
			<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
				<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
				<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
			</nav><!-- .navigation -->
		<?php
	endif;
	}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
	/**
	 * Template for comments and pingbacks.
	 *
	 * To override this walker in a child theme without modifying the comments template
	 * simply create your own twentytwelve_comment(), and that function will be used instead.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
		?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
				break;
			default:
				// Proceed with normal comments.
				global $post;
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf(
						'<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf(
						'<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
					?>
				</header><!-- .comment-meta -->

				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

				<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
				</section><!-- .comment-content -->

				<div class="reply">
				<?php
				comment_reply_link(
					array_merge(
						$args, array(
							'reply_text' => __( 'Reply', 'twentytwelve' ),
							'after'      => ' <span>&darr;</span>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						)
					)
				);
?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
		<?php
				break;
		endswitch; // end comment_type check
	}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
	/**
	 * Set up post entry meta.
	 *
	 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
	 *
	 * Create your own twentytwelve_entry_meta() to override in a child theme.
	 *
	 * @since Twenty Twelve 1.0
	 */
	function twentytwelve_entry_meta() {
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

		$date = sprintf(
			'<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);

		$author = sprintf(
			'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
			get_the_author()
		);

		// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
		if ( $tag_list ) {
			$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		} elseif ( $categories_list ) {
			$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		} else {
			$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
		}

		printf(
			$utility_text,
			$categories_list,
			$tag_list,
			$date,
			$author
		);
	}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) ) {
		$classes[] = 'full-width';
	}

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) ) {
			$classes[] = 'two-sidebars';
		}
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) ) {
			$classes[] = 'custom-background-empty';
		} elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) ) {
			$classes[] = 'custom-background-white';
		}
	}

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) ) {
		$classes[] = 'custom-font-enabled';
	}

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjust content width in certain contexts.
 *
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Register postMessage support.
 *
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'            => '.site-title > a',
				'container_inclusive' => false,
				'render_callback'     => 'twentytwelve_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'twentytwelve_customize_partial_blogdescription',
			)
		);
	}
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Twenty Twelve 2.0
 * @see twentytwelve_customize_register()
 *
 * @return void
 */
function twentytwelve_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Twenty Twelve 2.0
 * @see twentytwelve_customize_register()
 *
 * @return void
 */
function twentytwelve_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );


/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since Twenty Twelve 2.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function twentytwelve_widget_tag_cloud_args( $args ) {
	$args['largest']  = 22;
	$args['smallest'] = 8;
	$args['unit']     = 'pt';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentytwelve_widget_tag_cloud_args' );


/* ================================================
 * Customizer Custom Controls
 * ================================================ */

/**
 * Enqueue scripts and styles.
 * Our sample Social Icons are using Font Awesome icons so we need to include the FA CSS when viewing our site
 * The Single Accordion Control is also displaying some FA icons in the Customizer itself, so we need to enqueue FA CSS in the Customizer too
 *
 * @return void
 */
if ( ! function_exists( 'skyrocket_scripts_styles' ) ) {
	function skyrocket_scripts_styles() {
		// Register and enqueue our icon font
		// We're using the awesome Font Awesome icon font. http://fortawesome.github.io/Font-Awesome
		wp_register_style( 'fontawesome', trailingslashit( get_template_directory_uri() ) . 'css/fontawesome-all.min.css' , array(), '5.8.2', 'all' );
		wp_enqueue_style( 'fontawesome' );
	}
}
add_action( 'wp_enqueue_scripts', 'skyrocket_scripts_styles' );
add_action( 'customize_controls_print_styles', 'skyrocket_scripts_styles' );

/**
 * Enqueue scripts for our Customizer preview
 *
 * @return void
 */
if ( ! function_exists( 'skyrocket_customizer_preview_scripts' ) ) {
	function skyrocket_customizer_preview_scripts() {
		wp_enqueue_script( 'skyrocket-customizer-preview', trailingslashit( get_template_directory_uri() ) . 'js/customizer-preview.js', array( 'customize-preview', 'jquery' ) );
	}
}
add_action( 'customize_preview_init', 'skyrocket_customizer_preview_scripts' );

/**
 * Check if WooCommerce is active
 * Use in the active_callback when adding the WooCommerce Section to test if WooCommerce is activated
 *
 * @return boolean
 */
function skyrocket_is_woocommerce_active() {
	if ( class_exists( 'woocommerce' ) ) {
		return true;
	}
	return false;
}

/**
 * Filter our social icons to add an email icon on the end
 * This is a sample function to test the skyrocket_social_icons_list filter.
 */
function skyrocket_add_email_to_social_icons( $social_list ) {
	$social_list[] = sprintf( '<li class="%1$s"><a href="%2$s" title="%3$s"><i class="%4$s"></i><span class="assistive-text">%3$s</span></a></li>',
		'email',
		esc_url( home_url( '/contact' ) ),
		__( 'Get in touch', 'ephemeris' ),
		'far fa-envelope'
	);

	return $social_list;
}
add_filter( 'skyrocket_social_icons_list', 'skyrocket_add_email_to_social_icons' );

/**
 * Set our Social Icons URLs.
 * Only needed for our sample customizer preview refresh
 *
 * @return array Multidimensional array containing social media data
 */
if ( ! function_exists( 'skyrocket_generate_social_urls' ) ) {
	function skyrocket_generate_social_urls() {
		$social_icons = array(
			array( 'url' => 'behance.net', 'icon' => 'fab fa-behance', 'title' => esc_html__( 'Follow me on Behance', 'skyrocket' ), 'class' => 'behance' ),
			array( 'url' => 'bitbucket.org', 'icon' => 'fab fa-bitbucket', 'title' => esc_html__( 'Fork me on Bitbucket', 'skyrocket' ), 'class' => 'bitbucket' ),
			array( 'url' => 'codepen.io', 'icon' => 'fab fa-codepen', 'title' => esc_html__( 'Follow me on CodePen', 'skyrocket' ), 'class' => 'codepen' ),
			array( 'url' => 'deviantart.com', 'icon' => 'fab fa-deviantart', 'title' => esc_html__( 'Watch me on DeviantArt', 'skyrocket' ), 'class' => 'deviantart' ),
			array( 'url' => 'discord.gg', 'icon' => 'fab fa-discord', 'title' => esc_html__( 'Join me on Discord', 'skyrocket' ), 'class' => 'discord' ),
			array( 'url' => 'dribbble.com', 'icon' => 'fab fa-dribbble', 'title' => esc_html__( 'Follow me on Dribbble', 'skyrocket' ), 'class' => 'dribbble' ),
			array( 'url' => 'etsy.com', 'icon' => 'fab fa-etsy', 'title' => esc_html__( 'favorite me on Etsy', 'skyrocket' ), 'class' => 'etsy' ),
			array( 'url' => 'facebook.com', 'icon' => 'fab fa-facebook-f', 'title' => esc_html__( 'Like me on Facebook', 'skyrocket' ), 'class' => 'facebook' ),
			array( 'url' => 'flickr.com', 'icon' => 'fab fa-flickr', 'title' => esc_html__( 'Connect with me on Flickr', 'skyrocket' ), 'class' => 'flickr' ),
			array( 'url' => 'foursquare.com', 'icon' => 'fab fa-foursquare', 'title' => esc_html__( 'Follow me on Foursquare', 'skyrocket' ), 'class' => 'foursquare' ),
			array( 'url' => 'github.com', 'icon' => 'fab fa-github', 'title' => esc_html__( 'Fork me on GitHub', 'skyrocket' ), 'class' => 'github' ),
			array( 'url' => 'instagram.com', 'icon' => 'fab fa-instagram', 'title' => esc_html__( 'Follow me on Instagram', 'skyrocket' ), 'class' => 'instagram' ),
			array( 'url' => 'kickstarter.com', 'icon' => 'fab fa-kickstarter-k', 'title' => esc_html__( 'Back me on Kickstarter', 'skyrocket' ), 'class' => 'kickstarter' ),
			array( 'url' => 'last.fm', 'icon' => 'fab fa-lastfm', 'title' => esc_html__( 'Follow me on Last.fm', 'skyrocket' ), 'class' => 'lastfm' ),
			array( 'url' => 'linkedin.com', 'icon' => 'fab fa-linkedin-in', 'title' => esc_html__( 'Connect with me on LinkedIn', 'skyrocket' ), 'class' => 'linkedin' ),
			array( 'url' => 'medium.com', 'icon' => 'fab fa-medium-m', 'title' => esc_html__( 'Follow me on Medium', 'skyrocket' ), 'class' => 'medium' ),
			array( 'url' => 'patreon.com', 'icon' => 'fab fa-patreon', 'title' => esc_html__( 'Support me on Patreon', 'skyrocket' ), 'class' => 'patreon' ),
			array( 'url' => 'pinterest.com', 'icon' => 'fab fa-pinterest-p', 'title' => esc_html__( 'Follow me on Pinterest', 'skyrocket' ), 'class' => 'pinterest' ),
			array( 'url' => 'plus.google.com', 'icon' => 'fab fa-google-plus-g', 'title' => esc_html__( 'Connect with me on Google+', 'skyrocket' ), 'class' => 'googleplus' ),
			array( 'url' => 'reddit.com', 'icon' => 'fab fa-reddit-alien', 'title' => esc_html__( 'Join me on Reddit', 'skyrocket' ), 'class' => 'reddit' ),
			array( 'url' => 'slack.com', 'icon' => 'fab fa-slack-hash', 'title' => esc_html__( 'Join me on Slack', 'skyrocket' ), 'class' => 'slack.' ),
			array( 'url' => 'slideshare.net', 'icon' => 'fab fa-slideshare', 'title' => esc_html__( 'Follow me on SlideShare', 'skyrocket' ), 'class' => 'slideshare' ),
			array( 'url' => 'snapchat.com', 'icon' => 'fab fa-snapchat-ghost', 'title' => esc_html__( 'Add me on Snapchat', 'skyrocket' ), 'class' => 'snapchat' ),
			array( 'url' => 'soundcloud.com', 'icon' => 'fab fa-soundcloud', 'title' => esc_html__( 'Follow me on SoundCloud', 'skyrocket' ), 'class' => 'soundcloud' ),
			array( 'url' => 'spotify.com', 'icon' => 'fab fa-spotify', 'title' => esc_html__( 'Follow me on Spotify', 'skyrocket' ), 'class' => 'spotify' ),
			array( 'url' => 'stackoverflow.com', 'icon' => 'fab fa-stack-overflow', 'title' => esc_html__( 'Join me on Stack Overflow', 'skyrocket' ), 'class' => 'stackoverflow' ),
			array( 'url' => 'tumblr.com', 'icon' => 'fab fa-tumblr', 'title' => esc_html__( 'Follow me on Tumblr', 'skyrocket' ), 'class' => 'tumblr' ),
			array( 'url' => 'twitch.tv', 'icon' => 'fab fa-twitch', 'title' => esc_html__( 'Follow me on Twitch', 'skyrocket' ), 'class' => 'twitch' ),
			array( 'url' => 'twitter.com', 'icon' => 'fab fa-twitter', 'title' => esc_html__( 'Follow me on Twitter', 'skyrocket' ), 'class' => 'twitter' ),
			array( 'url' => 'vimeo.com', 'icon' => 'fab fa-vimeo-v', 'title' => esc_html__( 'Follow me on Vimeo', 'skyrocket' ), 'class' => 'vimeo' ),
			array( 'url' => 'weibo.com', 'icon' => 'fab fa-weibo', 'title' => esc_html__( 'Follow me on weibo', 'skyrocket' ), 'class' => 'weibo' ),
			array( 'url' => 'youtube.com', 'icon' => 'fab fa-youtube', 'title' => esc_html__( 'Subscribe to me on YouTube', 'skyrocket' ), 'class' => 'youtube' ),
		);

		return apply_filters( 'skyrocket_social_icons', $social_icons );
	}
}

/**
 * Return an unordered list of linked social media icons, based on the urls provided in the Customizer Sortable Repeater
 * This is a sample function to display some social icons on your site.
 * This sample function is also used to show how you can call a PHP function to refresh the customizer preview.
 * Add the following code to header.php if you want to see the sample social icons displayed in the customizer preview and your theme.
 * Before any social icons display, you'll also need to add the relevent URL's to the Header Navigation > Social Icons section in the Customizer.
 * <div class="social">
 *	 <?php echo skyrocket_get_social_media(); ?>
 * </div>
 *
 * @return string Unordered list of linked social media icons
 */
if ( ! function_exists( 'skyrocket_get_social_media' ) ) {
	function skyrocket_get_social_media() {
		$defaults = skyrocket_generate_defaults();
		$output = array();
		$social_icons = skyrocket_generate_social_urls();
		$social_urls = explode( ',', get_theme_mod( 'social_urls', $defaults['social_urls'] ) );
		$social_newtab = get_theme_mod( 'social_newtab', $defaults['social_newtab'] );
		$social_alignment = get_theme_mod( 'social_alignment', $defaults['social_alignment'] );
		$contact_phone = get_theme_mod( 'contact_phone', $defaults['contact_phone'] );

		if( !empty( $contact_phone ) ) {
			$output[] = sprintf( '<li class="%1$s"><i class="%2$s"></i>%3$s</li>',
				'phone',
				'fas fa-phone fa-flip-horizontal',
				$contact_phone
			);
		}

		foreach( $social_urls as $key => $value ) {
			if ( !empty( $value ) ) {
				$domain = str_ireplace( 'www.', '', parse_url( $value, PHP_URL_HOST ) );
				$index = array_search( strtolower( $domain ), array_column( $social_icons, 'url' ) );
				if( false !== $index ) {
					$output[] = sprintf( '<li class="%1$s"><a href="%2$s" title="%3$s"%4$s><i class="%5$s"></i></a></li>',
						$social_icons[$index]['class'],
						esc_url( $value ),
						$social_icons[$index]['title'],
						( !$social_newtab ? '' : ' target="_blank"' ),
						$social_icons[$index]['icon']
					);
				}
				else {
					$output[] = sprintf( '<li class="nosocial"><a href="%2$s"%3$s><i class="%4$s"></i></a></li>',
						$social_icons[$index]['class'],
						esc_url( $value ),
						( !$social_newtab ? '' : ' target="_blank"' ),
						'fas fa-globe'
					);
				}
			}
		}

		if( get_theme_mod( 'social_rss', $defaults['social_rss'] ) ) {
			$output[] = sprintf( '<li class="%1$s"><a href="%2$s" title="%3$s"%4$s><i class="%5$s"></i></a></li>',
				'rss',
				home_url( '/feed' ),
				'Subscribe to my RSS feed',
				( !$social_newtab ? '' : ' target="_blank"' ),
				'fas fa-rss'
			);
		}

		if ( !empty( $output ) ) {
			$output = apply_filters( 'skyrocket_social_icons_list', $output );
			array_unshift( $output, '<ul class="social-icons ' . $social_alignment . '">' );
			$output[] = '</ul>';
		}

		return implode( '', $output );
	}
}

/**
 * Append a search icon to the primary menu
 * This is a sample function to show how to append an icon to the menu based on the customizer search option
 * The search icon wont actually do anything
 */
if ( ! function_exists( 'skyrocket_add_search_menu_item' ) ) {
	function skyrocket_add_search_menu_item( $items, $args ) {
		$defaults = skyrocket_generate_defaults();

		if( get_theme_mod( 'search_menu_icon', $defaults['search_menu_icon'] ) ) {
			if( $args->theme_location == 'primary' ) {
				$items .= '<li class="menu-item menu-item-search"><a href="#" class="nav-search"><i class="fa fa-search"></i></a></li>';
			}
		}
		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'skyrocket_add_search_menu_item', 10, 2 );

/**
 * Return a string containing the sample TinyMCE Control
 * This is a sample function to show how you can use the TinyMCE Control for footer credits in your Theme
 * Add the following three lines of code to your footer.php file to display the content of your sample TinyMCE Control
 * <div class="footer-credits">
 *		<?php echo skyrocket_get_credits(); ?>
 *	</div>
 */
if ( ! function_exists( 'skyrocket_get_credits' ) ) {
	function skyrocket_get_credits() {
		$defaults = skyrocket_generate_defaults();

		// wpautop this so that it acts like the new visual text widget, since we're using the same TinyMCE control
		return wpautop( get_theme_mod( 'sample_tinymce_editor', $defaults['sample_tinymce_editor'] ) );
	}
}

/**
 * Output our Customizer styles in the site header
 *
 * @since Ephemeris 1.0
 *
 * @return string	css styles
 */
function skyrocket_customizer_css_styles() {
	$defaults = skyrocket_generate_defaults();
	$styles = '';
	$bodyFont = json_decode( get_theme_mod( 'sample_body_text_font', $defaults['sample_body_text_font'] ), true );
	$headerFont = json_decode( get_theme_mod( 'sample_heading_font', $defaults['sample_heading_font'] ), true );

	// Body Header color styles
	$styles .= "h1, h2, h3, h4, h5, h6 { font-family: '" . $headerFont['font'] . "'," . $headerFont["category"] . "}";

	// Body Text color styles
	$styles .= "body p { font-family: '" . $bodyFont['font'] . "'," . $bodyFont["category"] . "}";

	echo '<style type="text/css">' . $styles . '</style>';
}
add_action( 'wp_head', 'skyrocket_customizer_css_styles' );

/**
* Set our Customizer default options
*/
if ( ! function_exists( 'skyrocket_generate_defaults' ) ) {
	function skyrocket_generate_defaults() {
		$customizer_defaults = array(
			'social_newtab' => 0,
			'social_urls' => '',
			'social_alignment' => 'alignright',
			'social_rss' => 0,
			'social_url_icons' => '',
			'contact_phone' => '',
			'search_menu_icon' => 0,
			'woocommerce_shop_sidebar' => 1,
			'woocommerce_product_sidebar' => 0,
			'sample_toggle_switch' => 0,
			'sample_slider_control' => 48,
			'sample_slider_control_small_step' => 2,
			'sample_sortable_repeater_control' => '',
			'sample_image_radio_button' => 'sidebarright',
			'sample_text_radio_button' => 'right',
			'sample_image_checkbox' => 'stylebold,styleallcaps',
			'sample_single_accordion' => '',
			'sample_alpha_color' => 'rgba(209,0,55,0.7)',
			'sample_wpcolorpicker_alpha_color' => 'rgba(55,55,55,0.5)',
			'sample_wpcolorpicker_alpha_color2' => 'rgba(33,33,33,0.8)',
			'sample_pill_checkbox' => 'tiger,elephant,hippo',
			'sample_pill_checkbox2' => 'captainmarvel,msmarvel,squirrelgirl',
			'sample_pill_checkbox3' => 'author,categories,comments',
			'sample_simple_notice' => '',
			'sample_dropdown_select2_control_single' => 'vic',
			'sample_dropdown_select2_control_multi' => 'Antarctica/McMurdo,Australia/Melbourne,Australia/Broken_Hill',
			'sample_dropdown_posts_control' => '',
			'sample_tinymce_editor' => '',
			'sample_google_font_select' => json_encode(
				array(
					'font' => 'Open Sans',
					'regularweight' => 'regular',
					'italicweight' => 'italic',
					'boldweight' => '700',
					'category' => 'sans-serif'
				)
			),
			'sample_default_text' => '',
			'sample_email_text' => '',
			'sample_url_text' => '',
			'sample_number_text' => '',
			'sample_hidden_text' => '',
			'sample_date_text' => '',
			'sample_default_checkbox' => 0,
			'sample_default_select' => 'jet-fuel',
			'sample_default_radio' => 'spider-man',
			'sample_default_dropdownpages' => '1548',
			'sample_default_textarea' => '',
			'sample_default_color' => '#333',
			'sample_default_media' => '',
			'sample_default_image' => '',
			'sample_default_cropped_image' => '',
			'sample_date_only' => '2017-08-28',
			'sample_date_time' => '2017-08-28 16:30:00',
			'sample_date_time_no_past_date' => date( 'Y-m-d' ),
			'sample_body_text_font' => json_encode(
				array(
					'font' => 'Open Sans',
					'regularweight' => 'regular',
					'italicweight' => 'italic',
					'boldweight' => '700',
					'category' => 'sans-serif'
				)
			),
			'sample_heading_font' => json_encode(
				array(
					'font' => 'Muli',
					'regularweight' => 'regular',
					'italicweight' => 'italic',
					'boldweight' => '700',
					'category' => 'sans-serif'
				)
			),
			'sample_h1_heading_style' => 'normal',
			'sample_h1_heading_weight' => 'bold',
			'sample_h1_heading_text_transform' => 'capitalize',
			'sample_h1_heading_line_height' => 1.5,
			'sample_h1_heading_letter_spacing' => 0,
			'sample_h1_heading_color_normal' => '#333',
			'sample_h1_heading_color_link' => '#234634',
			'sample_h1_heading_color_hover' => '#763562',
			'sample_h1_heading_color_visited' => '#567890',
		);

		return apply_filters( 'skyrocket_customizer_defaults', $customizer_defaults );
	}
}

/**
* Load all our Customizer options
*/
include_once trailingslashit( dirname(__FILE__) ) . 'inc/customizer.php';
