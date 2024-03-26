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
    wp_enqueue_script('google-map', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=', array(), true, true);
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

function pizza_header_tabs_html(){
    echo '
<section class="kc-elm kc-css-824890 kc_row"><div class="kc-row-container  kc-container"><div class="kc-wrap-columns">
    <div class="kc-elm kc-css-656687 kc_col-sm-12 kc_column kc_col-sm-12"><div class="stretch-full-width kc-col-container">
        <div data-open-on-mouseover="" data-tab-active="1" data-effect-option="" class="kc-elm kc-css-29983 kc_tabs group products-with-gallery-tabs">
            <div class="kc_wrapper ui-tabs kc_clearfix">

                <ul class="kc_tabs_nav ui-tabs-nav kc_clearfix original">
                    <li class="ui-tabs-active">
                        <a href="#" data-prevent="scroll"><i class="icon-menus"></i>Combinados</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-uramakis"></i>Uramaki</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-hosomakis"></i>Hosomaki</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-gunkan"></i>Gunkan</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-niguiris"></i>Niguiri</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-sashimi"></i>Sashimi</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-tataki"></i>Tataki</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-tartaro"></i>Tártaro</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-ceviche"></i>Ceviche</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-temaki"></i>Temaki</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-quentes"></i>Quentes</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-bebidas"></i>Bebidas</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-sobremesa"></i>Sobremesas</a>
                    </li>
                    <li>
                        <a href="#" data-prevent="scroll"><i class="icon-extras"></i>Extras</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</sectoin>    
    ';
}
function pizza_header_tabs() {
    echo do_shortcode('
        [kc_row use_container="yes" _id="824890" cols_gap="{`kc-css`:{}}" force="__empty__"]
            [kc_column width="12/12" _id="656687" col_container_class="stretch-full-width"]
                [kc_tabs active_section="1" _id="29983" class="products-with-gallery-tabs" type="horizontal_tabs"]
                    [kc_tab title="Combinados" _id="178532" icon_option="yes" icon="icon-menus" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="691737" shortcode_tag="product_category" limit="4" columns="4" category="64"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Uramaki" _id="986533" icon_option="yes" icon="icon-uramakis"]
                        [pizzaro_products_with_gallery orderby="date" order="desc" _id="231958" shortcode_tag="product_category" limit="4" columns="4" category="63"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Hosomaki" _id="512358" icon_option="yes" icon="icon-hosomakis"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="799695" shortcode_tag="product_category" limit="4" columns="4" category="64"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Gunkan" _id="101054" icon_option="yes" icon="icon-gunkan"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="886009" shortcode_tag="product_category" limit="4" columns="4" category="65"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Niguiri" _id="321731" icon_option="yes" icon="icon-niguiris"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="310713" shortcode_tag="product_category" limit="4" columns="4" category="66"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Sashimi" _id="668016" icon_option="yes" icon="icon-sashimi"]
                        [pizzaro_products_with_gallery orderby="date" order="__empty__" _id="630038" shortcode_tag="product_category" limit="4" columns="4" category="67"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Tataki" _id="349417" icon_option="yes" icon="icon-tataki"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="516535" shortcode_tag="product_category" limit="4" columns="4" category="68"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Tártaro" _id="931914" icon_option="yes" icon="icon-tartaro"]
                        [pizzaro_products_with_gallery orderby="date" order="__empty__" _id="296089" shortcode_tag="product_category" limit="4" columns="4" category="69"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Ceviche" _id="799082" icon_option="yes" icon="icon-ceviche" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="521617" shortcode_tag="product_category" limit="4" columns="4" category="70"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Temaki" _id="984832" icon_option="yes" icon="icon-temaki" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="135382" shortcode_tag="product_category" limit="4" columns="4" category="71"]
                        [/pizzaro_products_with_gallery][/kc_tab][kc_tab title="Quentes" _id="365288" icon_option="yes" icon="icon-quentes" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="192925" shortcode_tag="product_category" limit="4" columns="4" category="72"][/pizzaro_products_with_gallery]
                    [/kc_tab]
                    [kc_tab title="Bebidas" _id="79750" icon_option="yes" icon="icon-bebidas" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="176395" shortcode_tag="product_category" limit="4" columns="4" category="73"]
                        [/pizzaro_products_with_gallery]
                    [/kc_tab]
                    [kc_tab title="Sobremesas" _id="956262" icon_option="yes" icon="icon-sobremesa" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="705947" shortcode_tag="product_category" limit="4" columns="4" category="74"]
                        [/pizzaro_products_with_gallery]
                    [/kc_tab]
                    [kc_tab title="Extras" _id="309816" icon_option="yes" icon="icon-extras" css_custom="{`kc-css`:{`any`:{`typography`:{`font-family|`:`Open Sans`}}}}"]
                        [pizzaro_products_with_gallery orderby="__empty__" order="__empty__" _id="663783" shortcode_tag="product_category" limit="4" columns="4" category="76"]
                        [/pizzaro_products_with_gallery]
                    [/kc_tab]
                [/kc_tabs]
            [/kc_column]
        [/kc_row]
    ');
}

add_action('wp_footer', 'add_custom_css');
function add_custom_css() {
    global $current_user;
    ?>
    <script>
        jQuery(document).ready(function($) {

        if ($('.kc_tabs_nav').length > 0) {

            <?php if ( is_user_logged_in() ) { ?>
                console.log('2 is_user_logged_in');
                $('ul.kc_tabs_nav').addClass('original').clone().insertAfter('ul.kc_tabs_nav').addClass('cloned').css('position','fixed').css('top','100.06px').css('margin-top','100.06px').css('z-index','9999999').removeClass('original').hide();
              <?php } else { ?> 
                console.log('2 not is_user_logged_in');
                $('ul.kc_tabs_nav').addClass('original').clone().insertAfter('ul.kc_tabs_nav').addClass('cloned').css('position','fixed').css('top','70.06px').css('margin-top','70.06px').css('z-index','9999999').removeClass('original').hide();
              <?php } ?> 

            //$('ul.original li').removeClass('ui-tabs-active');
            $('.select-city-phone-numbers').after('<div id="arr_ow"></div>');

            $('ul.original li, ul.cloned li').each(function(index, el) {
                //$(el).removeClass('ui-tabs-active');
                $(el).attr('data-num', index);
                var name = $(el).find('a i').attr('class').split('-');
                var name = $(el).find('a').text().toLowerCase().replace(" ", "");

                var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
                  var to   = "aaaaaeeeeeiiiiooooouuuunc------";
                  for (var i=0, l=from.length ; i<l ; i++) {
                    name = name.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                  }

                var link = $(el).find('a').attr('href', '<?php echo get_bloginfo('url'); ?>/'+name);
                $(el).addClass(name);
            });

            // $('ul.cloned li').each(function(index, el) {
            //     $(el).attr('data-num', index);
            //     if(index == 0){
            //         $(el).addClass('ui-tabs-active');
            //     }
            // });




            $('ul.original li a').click(function(event) {
                console.log($(this));
                //var tabsactive = $('ul.original .ui-tabs-active').attr('data-num');
                var tabsactive = $(this).parent('li').attr('data-num');
                console.log(tabsactive);
                $('ul.cloned li').removeClass('ui-tabs-active');
                $('ul.cloned li').each(function(index, el) {
                    if($(el).attr('data-num') == tabsactive){
                        $(el).addClass('ui-tabs-active');
                    }
                });
                window.location.href = $(this).attr('href');
            });
            $('ul.cloned li a').click(function(event) {
                console.log($(this));
                //var tabsactive = $('ul.original .ui-tabs-active').attr('data-num');
                var tabsactive = $(this).parent('li').attr('data-num');
                console.log(tabsactive);
                $('ul.original li').removeClass('ui-tabs-active');
                $('ul.original li').each(function(index, el) {
                    if($(el).attr('data-num') == tabsactive){
                        $(el).addClass('ui-tabs-active');
                    }
                });
                window.location.href = $(this).attr('href');
            });




            scrollIntervalID = setInterval(stickIt, 10);


            function stickIt() {

              var orgElementPos = $('.original').offset();

              <?php if ( is_user_logged_in() ) { ?>
                //console.log('is_user_logged_in');
                orgElementTop = orgElementPos.top-100.06;
              <?php } else { ?> 
                //console.log('not is_user_logged_in');
                orgElementTop = orgElementPos.top-70.06; 
              <?php } ?>             

              if ($(window).scrollTop() >= (orgElementTop)) {
                // scrolled past the original position; now only show the cloned, sticky element.

                // Cloned element should always have same left position and width as original element.     
                orgElement = $('.original');
                


                coordsOrgElement = orgElement.offset();
                leftOrgElement = coordsOrgElement.left;  
                widthOrgElement = orgElement.css('width');
                $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
                $('.original').css('visibility','hidden');
              } else {
                // not scrolled past the menu; only show the original menu.
                $('.cloned').hide();
                $('.original').css('visibility','visible');
              }
            }
        }     

            
        });

    </script>
    <style>
        .kc_tabs_nav.ui-tabs-nav {
            z-index: 99999999 !important;
        }
        .products .owl-item>.product.hover, .products .owl-item>.product:hover, ul.products li.product.hover, ul.products li.product:hover {
            z-index: 1;
        }
        .yith_magnifier_zoom_wrap {
            z-index: 1;
        }
        .ywapo_input_container_radio:not(.pz-radio-default) label span {
            z-index: 0;
        }
/*        .yith_magnifier_mousetrap {
            z-index: 1;
        }*/
        .shop-archive-header {
            display: none;
        }
        .cart_item .variation-Baseprice {
            display: none;
        }
        @media (max-width: 1200px) {
            .kc-css-824890 {
                display: none;
            }
        }
        @media (min-width: 1200px) {
            .products-with-gallery-tabs.kc_tabs .kc_tabs_nav li a {
                padding: 10px 10px .692em;
            }
        }
        @media (max-width: 700px) {
            .kc_tabs_nav.ui-tabs-nav.kc_clearfix.cloned {
                display: none !important;
            }
        }
    </style>
    <?php
}


add_filter('request', function( $vars ) {
    global $wpdb;
    if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
        $slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
        $exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
        if( $exists ){
            $old_vars = $vars;
            $vars = array('product_cat' => $slug );
            if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
                $vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
            if ( !empty( $old_vars['orderby'] ) )
                $vars['orderby'] = $old_vars['orderby'];
            if ( !empty( $old_vars['order'] ) )
                $vars['order'] = $old_vars['order'];
        }
    }
    return $vars;
});
add_filter('term_link', 'term_link_filter', 10, 3);
function term_link_filter( $url, $term, $taxonomy ) {
    $url=str_replace("/./","/",$url);
     return $url;
}