<?php
/**
 * Pizzaro Child
 *
 * @package pizzaro-child
 */
/**
 * Include all your custom code here
 */

function pz_child_header_v2_customize()
{
    remove_action('pizzaro_header_v2', 'pizzaro_header_navigation_link', 40);
    remove_action('pizzaro_header_v2', 'pizzaro_header_cart', 50);
    add_action('pizzaro_header_v2', 'pizzaro_header_phone', 40);
}

add_action('init', 'pz_child_header_v2_customize');

function pz_child_footer_v1_customize()
{
//    remove_action('pizzaro_before_footer_v1', 'pizzaro_footer_static_content', 100);
    remove_action('pizzaro_after_footer_v1', 'pizzaro_footer_v1_map', 10);
    remove_action('pizzaro_footer_v1', 'pizzaro_social_icons', 10);
    remove_action('pizzaro_footer_v1', 'pizzaro_footer_logo', 20);
    remove_action('pizzaro_footer_v1', 'pizzaro_footer_address', 30);
    remove_action('pizzaro_footer_v1', 'pizzaro_credit', 40);
    remove_action('pizzaro_footer_v1', 'pizzaro_footer_action', 50);
    add_action('pizzaro_footer_v1', 'pizzaro_footer_logo', 10);
    add_action('pizzaro_footer_v1', 'pizzaro_social_icons', 20);
    add_action('pizzaro_footer_v1', 'pizzaro_footer_newsletter', 30);
    add_action('pizzaro_footer_v1', 'pizzaro_footer_menu', 40);
    add_action('pizzaro_footer_v1', 'pizzaro_footer_address', 50);
    add_action('pizzaro_footer_v1', 'pizzaro_credit', 60);
}

add_action('init', 'pz_child_footer_v1_customize');

function pizzaro_child_scripts()
{
    wp_enqueue_style('pizzaro-custom-fonts', get_stylesheet_directory_uri() . '/pizzaro-custom-fonts.css');
}

add_action('wp_enqueue_scripts', 'pizzaro_child_scripts', 100);


function pz_child_enqueue_styles()
{
    wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBeXvPAtj9HDj5jMgeqjCtat5DXmQCXV7g', array(), true, true);
    wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/scripts/custom.js', array(), true, true);
}

add_action('wp_enqueue_scripts', 'pz_child_enqueue_styles');
if (function_exists('acf_add_options_page')) {

    $option_page = acf_add_options_page(array(
        'page_title' => 'Options',
        'menu_title' => 'Options',
        'menu_slug' => 'theme-general-options',
        'capability' => 'edit_posts',
        'redirect' => false
    ));

}
add_filter('pizzaro_map_content', function () {
    ob_start(); ?>


    <?php if (have_rows('locations', 'option')): ?>
        <div class="acf-map" style="height: 500px">
            <?php while (have_rows('locations', 'option')) : the_row();
                $location = get_sub_field('location');
                if (!$location) {
                    continue;
                }
                ?>
                <div class="marker" data-lat="<?php echo $location['lat']; ?>"
                     data-lng="<?php echo $location['lng']; ?>">
                    <h4><?php the_sub_field('title'); ?></h4>
                    <!--                    <p class="address">--><?php //echo $location['address']; ?><!--</p>-->
                </div>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>

    <?php $content = ob_get_clean();
    return $content;
}, 20, 1);


add_filter( 'pizzaro_newsletter_form',function ($newsletter_form){
    $newsletter_form = do_shortcode('[mc4wp_form id="215"]');
    return $newsletter_form;
}, 1,20);

add_filter( 'woocommerce_product_add_to_cart_text' , 'custom_woocommerce_product_add_to_cart_text', 100, 1 );
function custom_woocommerce_product_add_to_cart_text() {
    global $product;    
    $product_type = $product->product_type; 
    switch ( $product_type ) {
        case 'variable':
        case 'simple':
            return __( 'Seleccionar', 'woocommerce' );
            break;
        case 'default': 
                return __( 'Seleccionar', 'woocommerce' );
            break;
    }
}

/*add_filter( 'get_terms', 'get_subcategory_terms', 100, 3 );

function get_subcategory_terms( $terms, $taxonomies, $args ) {

    if ( $_SERVER['REQUEST_URI'] != '/carta/' ) return;
    $new_terms = array();

    // if a product category and on the shop page
    if ( in_array( 'product_cat', $taxonomies ) && ! is_admin() ) {

        foreach ( $terms as $key => $term ) {

            if ( ! in_array( $term->slug, array( 'Combinados', 'Extras' ) ) ) {
                $new_terms[] = $term;
            }

        }

        $terms = $new_terms;
    }

    return $terms;
}*/

function logo_size_change(){
	remove_theme_support( 'custom-logo' );
	add_theme_support( 'custom-logo', array(
		'height'      => 50,
		'width'       => 50,
		'flex-height' => true,
		'flex-width'  => true,
	) );
}
add_action( 'after_setup_theme', 'logo_size_change', 11 );

add_filter( 'pizzaro_order_steps', function ($steps) {
    return array(
	    'cart' => array(
		    'step'	=> 1,
		    'text'	=> esc_html__( 'Carrinho', 'pizzaro' ),
	    ),
	    'checkout'	=> array(
		    'step'	=> 2,
		    'text'	=> esc_html__( 'Finalizar encomenda', 'pizzaro' ),
	    ),
	    'complete'	=> array(
		    'step'	=> 3,
		    'text'	=> esc_html__( 'Encomenda completa', 'pizzaro' )
	    )
    );
} );