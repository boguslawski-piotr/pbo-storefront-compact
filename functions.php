<?php
/*
 Theme Name:   autodbalnia
 Theme URI:    autodbalnia.pl
 Description:  Theme for autodbalnia.pl internet shop
 Author:       Piotr Boguslawski
 Template:     storefront
 Version:      1.0.0
 Text Domain:  storefront
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Settings
 */

$is_mobile = class_exists( 'PBO_User_Device' ) ? PBO_User_Device::is_mobile() : false;
if ( $is_mobile &&  ! in_array(PBO_User_Device::$device, [ 'iphone' ] ) ) {
	//echo 'MOBILE: ' . PBO_User_Device::$device . ' -> ';
	//echo $_SERVER['HTTP_USER_AGENT'];
	if ( PBO_User_Device::$device === 'ipad' ) {
		$is_mobile = false;
	} else {
		$doc_width = PBO_User_Device::try_to_get_document_width();
		//echo $doc_width;
		if ( ( isset( $doc_width ) && $doc_width >= 768 ) ) {
			$is_mobile = false;
		}
	}
}

$a_settings = [ ];

$a_settings['excerpt_image_size']  = 'thumbnail';
$a_settings['excerpt_image_float'] = 'alignleft';
$a_settings['excerpt_word_count']  = $is_mobile ? 25 : 45;
$a_settings['excerpt_end']         = '...';

$a_settings['products_per_page']        = $is_mobile ? 6 : 15;
$a_settings['product_columns']          = $is_mobile ? 1 : 3;
$a_settings['product_columns_homepage'] = $is_mobile ? 2 : 3;

add_action( 'pre_get_posts',
	function ( $query ) {
		global $is_mobile;
		if ( $query->is_home() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', $is_mobile ? 3 : 6 );
		}
	}
);

add_filter( 'woocommerce_related_products_args',
	function ( $args ) {
		global $a_settings;
		$aargs['columns']       = $a_settings['product_columns'];
		$args['posts_per_page'] = $a_settings['product_columns'];

		return $args;
	}
);


/**
 * Remove storefront credit link in footer
 */
add_filter( 'storefront_credit_link',
	function () {
		return false;
	}
);

//echo 'body_width: ' . PBO_User_Device::try_to_get_document_width();


/**
 * Initialization
 */

add_action( 'after_setup_theme',
	function () {
		load_theme_textdomain( 'autodbalnia', dirname( __FILE__ ) . '/languages/' );
	}
);


function a_init() {
	global $a_settings;
	global $is_mobile;

	// Change fields order on mobile view: secondary menu first then search box
	remove_action( 'storefront_header', 'storefront_product_search', 40 );
	add_action( 'storefront_header', 'storefront_product_search', 55 );

	// Insert link to Wishlist into header
	if ( is_plugin_active( 'yith-woocommerce-wishlist/init.php' ) ) {
		add_action( 'storefront_header', 'a_wishlist_link', 25 );
	}

	// Change single product fields presentation order
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 7 );

	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 9 );

	// Apply the excerpt replacing the content block on the archive page
	remove_action( 'storefront_loop_post', 'storefront_post_content', 30 );
	add_action( 'storefront_loop_post', 'a_post_excerpt', 30 );

	// ...
	remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 10 );
	add_action( 'storefront_content_top', 'a_woocommerce_breadcrumb', 10 );

	// Category/product columns on archives pages
	add_filter( 'loop_shop_columns', function () {
		global $a_settings;

		return $a_settings['product_columns'];
	}, 999 );

	// Products per page
	add_filter( 'loop_shop_per_page', function ( $cols ) {
		global $a_settings;

		return $a_settings['products_per_page'];
	}, 20 );
}

add_action( 'init', 'a_init', 999 );


/**
 * Stylesheets, scripts
 */

function a_enqueue_styles() {
	if ( is_child_theme() ) {
		// Load parent stylesheet first.
		wp_enqueue_style( 'storefront-style', trailingslashit( get_template_directory_uri() ) . 'style.css', false );
	}

	// Load active theme stylesheet but later than specified plugins.
	wp_enqueue_style( 'a_style', get_stylesheet_uri(),
		[
			'storefront-style',
			'storefront-woocommerce-style',
			'storefront-top-bar',
			'easy_social_share_buttons-frontend',
			'yith-wcwl-main',
			'su-box-shortcodes',
			'searchwp-live-search',
			'simple-favorites',
			'basecss',                                 // EU Cookie Law
		]
	);
}

add_action( 'wp_enqueue_scripts', 'a_enqueue_styles' );


/**
 * @param $short_code
 * @param $caption
 * @param $style
 * @param $max_rows
 */
function a_X_products( $short_code, $caption, $style, $max_rows ) {
	global $a_settings;
	echo "<h3 style='$style'>" . $caption . '</h3>';
	echo execute_shortcode( $short_code,
		array(
			'per_page' => (int) $max_rows * $a_settings['product_columns_homepage'],
			'columns'  => $a_settings['product_columns'],
		) );
}


function a_featured_products( $style, $max_rows ) {
	if ( wc_get_featured_product_ids() ) {
		a_X_products( 'featured_products', esc_html__( 'Featured products', 'autodbalnia' ), $style, $max_rows );
	}
}


function a_sale_products( $style, $max_rows ) {
	if ( wc_get_product_ids_on_sale() ) {
		a_X_products( 'sale_products', esc_html__( 'Products on sale', 'autodbalnia' ), $style, $max_rows );
	}
}


function a_recent_products( $style, $max_rows ) {
	a_X_products( 'recent_products', esc_html__( 'Recent products', 'autodbalnia' ), $style, $max_rows );
}


function a_best_selling_products( $style, $max_rows ) {
	a_X_products( 'best_selling_products', esc_html__( 'Best selling products', 'autodbalnia' ), $style, $max_rows );
}


function a_top_rated_products( $style, $max_rows ) {
	a_X_products( 'top_rated_products', esc_html__( 'Top rated products', 'autodbalnia' ), $style, $max_rows );
}


/**
 * Shortcodes in excerpts
 */
function a_post_excerpt() {
	global $a_settings;
	?>
	<div class="entry-content" itemprop="articleBody">
		<?php
		if ( has_post_thumbnail() ) {
			$thumb_size = $a_settings['excerpt_image_size'];
			$img_class  = ( $thumb_size == 'thumbnail' ) ? apply_filters( 'woa_sf_blog_excerpt_image_float', $a_settings['excerpt_image_float'] ) : '';
			the_post_thumbnail( $thumb_size, array(
				'itemprop' => 'image',
				'class'    => "attachment-$thumb_size $img_class"
			) );
		}
		$content = do_shortcode( ( has_excerpt( get_the_ID() ) ) ? get_the_excerpt() : get_the_content() );
		$content = wp_trim_words( $content, $a_settings['excerpt_word_count'], $a_settings['excerpt_end'] );
		echo apply_filters( 'the_excerpt', $content );
		?>
		<p class="read-more"><a class="button"
		                        href="<?php the_permalink(); ?>"><?php echo __( 'Continue reading', 'autodbalnia' ); ?></a>
		</p>
	</div><!-- .entry-content -->
	<?php
}


/**
 * Breadcrumb only on post and shop (products, categories, etc.) pages
 */
function a_woocommerce_breadcrumb( $args = array() ) {
	if ( 'page' !== get_post_type() ) {
		woocommerce_breadcrumb( $args );
	}
}


/**
 *
 */
function a_wishlist_link() { ?>
	<div class="site-header-wishlist">
		<a href="<?php echo esc_url( get_permalink( 2568 ) ) ?>"><?php echo esc_html__( 'View Wishlist', 'autodbalnia' ); ?></a>
	</div>
	<?php
}


/**
 *
 */
function storefront_skip_links() {
	// nothing
}


/**
 * Replace Woocommerce products search box with standard Wordpress search box
 */
function storefront_product_search() { ?>
	<div class="site-search">
		<?php the_widget( 'WP_Widget_Search' ); ?>
	</div>
	<?php
}


/**
 * Display the page header
 * PB: no post thumbnail (image)
 */
function storefront_page_header() {
	?>
	<header class="entry-header">
		<?php
		//storefront_post_thumbnail( 'full' );
		the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		?>
	</header><!-- .entry-header -->
	<?php
}


/**
 * Display the post header with a link to the single post
 * PB: date of post under post title ;)
 */
function storefront_post_header() { ?>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
			storefront_posted_on();
		} else {
			the_title( sprintf( '<h1 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			if ( 'post' == get_post_type() ) {
				storefront_posted_on();
			}
		}
		?>
	</header><!-- .entry-header -->
	<?php
}


/**
 * Display the post content
 * PB: featured image off on full post pages
 */
function storefront_post_content() {
	?>
	<div class="entry-content" itemprop="articleBody">
		<?php
		//storefront_post_thumbnail( 'full' );

		the_content(
			sprintf(
				__( 'Continue reading %s', 'storefront' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<?php
}


/**
 * Display the post meta
 * PB: code rearrange in order to not insert empty <aside ...></aside> section
 */
function storefront_post_meta() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ', 'storefront' ) );

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );

	if ( ( $categories_list && storefront_categorized_blog() ) || $tags_list ) : ?>
		<aside class="entry-meta">
			<?php
			if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
				if ( $categories_list && storefront_categorized_blog() ) : ?>
					<span class="cat-links">
						<?php
						echo '<span class="screen-reader-text">' . esc_attr( __( 'Categories: ', 'storefront' ) ) . '</span>';
						echo wp_kses_post( $categories_list );
						?>
					</span>
				<?php endif; // End if categories
				?>

				<?php
				if ( $tags_list ) : ?>
					<span class="tags-links">
						<?php
						echo '<span class="screen-reader-text">' . esc_attr( __( 'Tags: ', 'storefront' ) ) . '</span>';
						echo wp_kses_post( $tags_list );
						?>
					</span>
				<?php endif; // End if $tags_list
				?>

			<?php endif; // End if 'post' == get_post_type() ?>
		</aside>
		<?php
	endif;
}


/**
 * Hack for YITH Wishlist, because it not work correctly with advanced Add To Cart funcionality (see woocommerce/loop/add-to-cart.php)
 */

$add_to_cart_template_from_wishlist = 0;

function bwishlist_hack() {
	global $add_to_cart_template_from_wishlist;
	$add_to_cart_template_from_wishlist ++;
}

function awishlist_hack() {
	global $add_to_cart_template_from_wishlist;
	$add_to_cart_template_from_wishlist --;
}

add_action( 'yith_wcwl_before_wishlist', 'bwishlist_hack' );
add_action( 'yith_wcwl_after_wishlist', 'awishlist_hack' );


/* ================================================ TEST AREA ================================================ */


?>

