<?php
//Child Theme Functions File

// customize add to cart url with multipe variables and quantities ********************************************/
// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wm_quote', 'woocommerce_add_multiple_products_to_cart', 15 );
function woocommerce_add_multiple_products_to_cart( $url = false ) {
	global $woocommerce;
	global $wp_session;

	// Make sure WC is installed, and add-to-cart qauery arg exists, and contains at least one comma.
	if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['add-to-cart'] ) || false === strpos( $_REQUEST['add-to-cart'], ',' ) ) {
		return;
	}

	// Remove WooCommerce's hook, as it's useless (doesn't handle multiple products).
	remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), 20 );

	$woocommerce->cart->empty_cart();

	if(isset($_GET['coupon']) && !empty($_GET['coupon'])) {
		WC()->cart->add_discount( $_GET['coupon'] );
	}

	session_start();

    if( ! is_admin() && isset($_GET['insurance']) ) {
        $_SESSION['wp_quote_insurance'] = $_GET['insurance'];
        WC()->session->__unset('wp_quote_insurance');
    }	

	$product_ids = explode( ',', $_REQUEST['add-to-cart'] );
	$count       = count( $product_ids );
	$number      = 0;


	foreach ( $product_ids as $id_and_quantity ) {
		// Check for quantities defined in curie notation (<product_id>:<product_quantity>)
		// https://dsgnwrks.pro/snippets/woocommerce-allow-adding-multiple-products-to-the-cart-via-the-add-to-cart-query-string/#comment-12236
		$id_and_quantity = explode( ':', $id_and_quantity );
		$product_id = $id_and_quantity[0];

		$_REQUEST['quantity'] = ! empty( $id_and_quantity[1] ) ? absint( $id_and_quantity[1] ) : 1;

		if ( ++$number === $count ) {
			// Ok, final item, let's send it back to woocommerce's add_to_cart_action method for handling.
			$_REQUEST['add-to-cart'] = $product_id;
			


			return WC_Form_Handler::add_to_cart_action( $url );
		}

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			continue;
		}

		$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );

		// Variable product handling
		if ( 'variable' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_variable', $product_id );

		// Grouped Products
		} elseif ( 'grouped' === $add_to_cart_handler ) {
			woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_grouped', $product_id );

		// Custom Handler
		} elseif ( has_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler ) ){
			do_action( 'woocommerce_add_to_cart_handler_' . $add_to_cart_handler, $url );

		// Simple Products
		} else {
			// woo_hack_invoke_private_method( 'WC_Form_Handler', 'add_to_cart_handler_simple', $product_id );
			WC()->cart->add_to_cart($product_id, $_REQUEST['quantity']);
			}
	}

}




/**
 * Invoke class private method
 *
 * @since   0.1.0
 *
 * @param   string $class_name
 * @param   string $methodName
 *
 * @return  mixed
 */
function woo_hack_invoke_private_method( $class_name, $methodName ) {
	if ( version_compare( phpversion(), '5.3', '<' ) ) {
		throw new Exception( 'PHP version does not support ReflectionClass::setAccessible()', __LINE__ );
	}

	$args = func_get_args();
	unset( $args[0], $args[1] );
	$reflection = new ReflectionClass( $class_name );
	$method = $reflection->getMethod( $methodName );
	$method->setAccessible( true );

	$args = array_merge( array( $class_name ), $args );
	return call_user_func_array( array( $method, 'invoke' ), $args );
}



/** Add a custom% surcharge to your cart / checkout * change the $percentage to set the surcharge to a value to suit ***************/
add_action( 'woocommerce_cart_calculate_fees','woocommerce_custom_surcharge' );
function woocommerce_custom_surcharge() {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if(isset($_SESSION['wp_quote_insurance']) && ! WC()->session->__isset('wp_quote_insurance') ){
        $value = $_SESSION['wp_quote_insurance'];
        WC()->session->set('wp_quote_insurance', $value );
    }

    if( WC()->session->__isset('wp_quote_insurance') ) {
       $insurance = WC()->session->get('wp_quote_insurance');
       WC()->cart->add_fee( 'insurance', $insurance);
    }
	
}


// DEFINIZIONE DEL DATAMODEL x ROUTE
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'wm_route_quote',
	'title' => 'Date e preventivo',
	'fields' => array(
		array(
			'key' => 'wm_route_quote_tab_model',
			'label' => 'Modello',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_product',
			'label' => 'Modello product',
			'name' => 'product',
			'type' => 'relationship',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'product',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
			),
			'elements' => '',
			'min' => 1,
			'max' => 5,
			'return_format' => 'id',
		),
		array(
			'key' => 'wm_route_quote_dates',
			'label' => 'Partenza (periodi di date)',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_dates_periods_repeater',
			'label' => 'Periodi di partenza',
			'name' => 'departures_periods',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'table',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_dates_period_name',
					'label' => 'Nome del periodo',
					'name' => 'name',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array(
					'key' => 'wm_route_quote_dates_period_start',
					'label' => 'Inizio Periodo',
					'name' => 'start',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array(
					'key' => 'wm_route_quote_dates_period_stop',
					'label' => 'Fine periodo',
					'name' => 'stop',
					'type' => 'date_picker',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
				array(
					'key' => 'wm_route_quote_dates_period_week_days',
					'label' => 'Giorni della settimana',
					'name' => 'week_days',
					'type' => 'checkbox',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array(
						'mon' => 'mon',
						'tue' => 'tue',
						'wed' => 'wed',
						'thu' => 'thu',
						'fri' => 'fri',
						'sat' => 'sat',
						'sun' => 'sun',
					),
					'allow_custom' => 0,
					'default_value' => array(
					),
					'layout' => 'horizontal',
					'toggle' => 0,
					'return_format' => 'value',
					'save_custom' => 0,
				),
			),
		),
		array(
			'key' => 'wm_route_quote_dates_specific_tab',
			'label' => 'Partenza (date specifiche)',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_dates_specific_repeater',
			'label' => 'Date specifiche di partenza',
			'name' => 'departure_dates',
			'type' => 'repeater',
			'instructions' => 'Inserisci una o più date per la partenza',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5d02059174143',
			'min' => 1,
			'max' => 0,
			'layout' => 'table',
			'button_label' => 'Aggiuni data',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_dates_specific',
					'label' => 'Data',
					'name' => 'date',
					'type' => 'date_picker',
					'instructions' => 'Inserisci una data',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'display_format' => 'd/m/Y',
					'return_format' => 'd/m/Y',
					'first_day' => 1,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'route',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
