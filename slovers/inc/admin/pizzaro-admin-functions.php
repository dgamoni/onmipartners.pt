<?php
/**
 * Pizzaro Admin Functions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get all Pizzaro screen ids.
 *
 * @return array
 */

function pizzaro_get_screen_ids() {

	$wc_screen_id = sanitize_title( esc_html__( 'Pizzaro', 'pizzaro' ) );
	$screen_ids   = array(
		'page',
	);

	foreach ( wc_get_order_types() as $type ) {
		$screen_ids[] = $type;
		$screen_ids[] = 'edit-' . $type;
	}

	return apply_filters( 'pizzaro_screen_ids', $screen_ids );
}

/**
 * Display a Pizzaro help tip.
 *
 *
 * @param  string $tip        Help tip text
 * @param  bool   $allow_html Allow sanitized HTML if true or escape
 * @return string
 */
function pizzaro_help_tip( $tip, $allow_html = false ) {
    if ( $allow_html ) {
        $tip = wc_sanitize_tooltip( $tip );
    } else {
        $tip = esc_attr( $tip );
    }

    return '<span class="pizzaro-help-tip" data-tip="' . $tip . '"></span>';
}

function pizzaro_custom_primary_color_page() {
	?><h1><?php echo esc_html__( 'Enter Custom Primary Color CSS', 'pizzaro' ); ?></h1>
	<p><?php echo esc_html__( 'The generated custom primary color CSS is given below', 'pizzaro' ); ?></p>
	<textarea style="width:100%; height: 600px; font-family: monospace;"><?php echo wp_kses_post( redux_get_custom_color_css() ); ?></textarea>
	<h2><?php echo esc_html__( 'Instructions', 'pizzaro' );?></h2>
	<ol>
		<li><?php echo esc_html__( 'Create a file named custom-color.css in your child theme like wp-content/themes/pizzaro-child/custom-color.css. Latest versions of pizzaro-child comes with an empty custom-color.css so you don\'t have to create one', 'pizzaro' ); ?></li>
		<li><?php echo esc_html__( 'If you do not use a child theme, please use one otherwise all your custom changes will be lost during update', 'pizzaro' ); ?></li>
		<li><?php echo esc_html__( 'Copy the CSS above and paste in the custom-color.css file created in step 1', 'pizzaro' ); ?></li>
		<li><?php echo esc_html__( 'Thats it. Your custom-color.css will be loaded automatically.', 'pizzaro' ); ?></li>
	</ol><?php
}
