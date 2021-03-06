<?php
//Child Theme Functions File

// customize add to cart url with multipe variables and quantities ********************************************/
// Fire before the WC_Form_Handler::add_to_cart_action callback.
add_action( 'wm_quote', 'woocommerce_add_multiple_products_to_cart', 15 );
function woocommerce_add_multiple_products_to_cart( $url = false ) {
	global $woocommerce;
	global $wp_session;

	// Make sure WC is installed, and add-to-cart qauery arg exists, and contains at least one comma. ------   || false === strpos( $_REQUEST['add-to-cart'], ',' )
	if ( ! class_exists( 'WC_Form_Handler' ) || empty( $_REQUEST['add-to-cart'] )  ) {
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

	$add_to_cart = $_REQUEST['add-to-cart'];
	if (preg_match('/,/',$_REQUEST['add-to-cart'])) { // checks if there are more than 1 product variation

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
	} else {
		
		// Check for quantities defined in curie notation (<product_id>:<product_quantity>)
		// https://dsgnwrks.pro/snippets/woocommerce-allow-adding-multiple-products-to-the-cart-via-the-add-to-cart-query-string/#comment-12236
		$id_and_quantity = explode( ':', $_REQUEST['add-to-cart'] );
		$product_id = $id_and_quantity[0];

		$_REQUEST['quantity'] = ! empty( $id_and_quantity[1] ) ? absint( $id_and_quantity[1] ) : 1;

        $count       = 1;
		$number      = 0;
		if ( ++$number === $count ) {
			// Ok, final item, let's send it back to woocommerce's add_to_cart_action method for handling.
			$_REQUEST['add-to-cart'] = $product_id;
			


			return WC_Form_Handler::add_to_cart_action( $url );
		}

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $product_id ) );
		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		// if ( ! $adding_to_cart ) {
		// 	continue;
		// }

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

		//choosing the language
		// if( $_GET['lang'] == 'en') {
		// 	echo 'pedram';
		// 	$variable_to_send = 'your-order/?lang=en';
		// 	wp_redirect( home_url() .$variable_to_send );

		function custom_add_to_cart_redirect() { 
			if( isset( $_REQUEST['add-to-cart'] ) && $_GET['lang'] == 'en') {
			return 'https://verde-natura.it/your-order/?lang=en'; 
			}
		}
		add_filter( 'woocommerce_add_to_cart_redirect', 'custom_add_to_cart_redirect' );
		// apply_filters( 'woocommerce_get_cart_url', wc_get_page_permalink( 'your-order/?lang=en' ) );
		// }
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
       WC()->cart->add_fee( __('Cancellation insurance' ,'wm-child-verdenatura'), $insurance);
    }
	
}

/**
 * Display field value of departure date on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );
function my_custom_checkout_field_display_admin_order_meta( $order ){
	$order_id = method_exists( $order, 'get_id' ) ? $order->get_id() : $order->id;
	$coupon = $order->get_used_coupons();
	$coupon_name = $coupon['0'];
	$post = get_posts( array( 
		'name' => $coupon_name, 
		'post_type' => 'shop_coupon'
	) );

	foreach ( $post as $info) {
		$description = $info->post_excerpt;
	}
	$desc = json_decode($description, JSON_PRETTY_PRINT);
	foreach ($desc as $val => $key){
        if ($val == 'departureDate') {
			$date = $key;
			$departure_date = date("Y-m-d", strtotime($date));
		}
	}

	// add newsletter privacy and terms to to backend order edit page
	$newsletter_acceptance = 'No';
	$privacy_policy = 'No';
	$terms_conditions = 'No';
	$item_meta_data = $order->get_meta_data();
	foreach($item_meta_data as $meta_data_item ) {
		foreach ($meta_data_item->get_data() as $key => $value){ 
			if ( $value == '_newsletter_acceptance'){
				$newsletter_acceptance = __('Yes','wm-child-verdenatura');
			}
			if ( $value == '_privacy_policy'){
				$privacy_policy = __('Yes','wm-child-verdenatura');
			}
			if ( $value == '_terms_conditions'){
				$terms_conditions = __('Yes','wm-child-verdenatura');
			}
		}
	}
	echo '<p><strong>'.__('Subscribe to Newsletter','wm-child-verdenatura').':</strong> '.$newsletter_acceptance. '</p>';
	echo '<p><strong>'.__('Privacy & policy accepted','wm-child-verdenatura').':</strong> '.$privacy_policy. '</p>';
	echo '<p><strong>'.__('Terms & conditions accepted','wm-child-verdenatura').':</strong> '.$terms_conditions. '</p>';
	update_field('order_departure_date', $departure_date, $order_id);
	echo '<p><strong>'.__('Departure date','wm-child-verdenatura').':</strong> ' . $departure_date . '</p>';
	
}

// hide coupon field on cart page
function hide_coupon_field_on_cart( $enabled ) {
	if ( is_cart() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );

// hide coupon field on checkout page
function hide_coupon_field_on_checkout( $enabled ) {
	if ( is_checkout() ) {
		$enabled = false;
	}
	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

// remove add to cart Alerts
add_filter( 'wc_add_to_cart_message_html', '__return_false' );


// Removes cart notices from the checkout page
function sv_remove_cart_notice_on_checkout() {
	if ( function_exists( 'wc_cart_notices' ) ) {
		remove_action( 'woocommerce_before_checkout_form', array( wc_cart_notices(), 'add_cart_notice' ) );
	}
}
add_action( 'init', 'sv_remove_cart_notice_on_checkout' );

// remove add coupon input in cart page
add_action( 'woocommerce_before_checkout_form', 'remove_checkout_coupon_form', 9 );
function remove_checkout_coupon_form(){
    remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
}

//remove delete button and thumbnail from order list in cart page
add_filter( 'woocommerce_cart_item_thumbnail', '__return_false' );
add_filter( 'woocommerce_cart_item_remove_link', '__return_false' );


// remove alert di coupon cart page
add_filter( 'woocommerce_coupon_message', '__return_empty_string' );


function change_quantity_input( $product_quantity, $cart_item_key, $cart_item ) {
    $product_id = $cart_item['product_id'];
    // whatever logic you want to determine whether or not to alter the input
    //$product_quantity = "<p>4</p>";
	//echo  "<p> $number </p>";
    $num = $product_quantity;

	$format = '%s';
	echo sprintf($format, $num);

    //return $product_quantity;
}
add_filter( 'woocommerce_cart_item_quantity', 'change_quantity_input', 10, 3);


// removes eliminate button from cart totals in cart page
function change_remove ($coupon_html, $coupon, $discount_amount_html) {
	$coupon_html          = $discount_amount_html ;
	return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'change_remove', 10, 3);



// adds the deposit amount to cart page after total number
add_action( 'woocommerce_cart_totals_after_order_total','show_deposit_amount' );
function show_deposit_amount() {
	$deposit_to_pay = WC()->cart->total * 0.25 ;
	$deposit_to_pay_formated = number_format($deposit_to_pay, 2);
	?>
	<tr class="order_deposit">
		<th><?php _e( '25% Deposit', 'woocommerce' ); ?></th>
		<td data-title="<?php esc_attr_e( '25% Deposit', 'woocommerce' ); ?>"><?php echo $deposit_to_pay_formated  ?>€</td>
	</tr><?php
    
    
}

/*** @snippet       Remove Cart Item Link - WooCommerce Cart  */
 
add_filter( 'woocommerce_cart_item_permalink', '__return_null' );
add_filter( 'woocommerce_order_item_permalink', '__return_false' );

add_action('woocommerce_cart_loaded_from_session', 'wh_cartOrderItemsbyNewest');

function wh_cartOrderItemsbyNewest() {

    //if the cart is empty do nothing
    if (WC()->cart->get_cart_contents_count() == 0) {
        return;
    }

    //array to collect cart items
    $cart_sort_hotel = [];
    $cart_sort_extra = [];

    //add cart item inside the array
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		if ( has_term( 'hotel', 'product_cat', $cart_item['product_id'] ) ) {
			array_push($cart_sort_hotel, $cart_item);
		} else {
			array_push($cart_sort_extra, $cart_item);
		}
	}
	$cart_sort = array_merge($cart_sort_hotel, $cart_sort_extra);
    //replace the cart contents with in the reverse order
    WC()->cart->cart_contents = $cart_sort;
}
    
//add privacy policy and terms and conditions on checkout page
add_action( 'woocommerce_review_order_before_submit', 'bbloomer_add_checkout_privacy_policy', 9 );
    
function bbloomer_add_checkout_privacy_policy() {
   
	woocommerce_form_field( 'newsletter_acceptance', array(
	'type'          => 'checkbox',
	'class'         => array('form-row privacy'),
	'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
	'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
	'required'      => false,
	'label'         => 'I agree to receive the newsletter',
	)); 

	woocommerce_form_field( 'privacy_policy', array(
	'type'          => 'checkbox',
	'class'         => array('form-row privacy'),
	'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
	'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
	'required'      => true,
	'label'         => 'I\'ve read and accept the <a href="/privacy/?lang=en">Privacy Policy</a>',
	)); 

	woocommerce_form_field( 'terms_conditions', array(
	'type'          => 'checkbox',
	'class'         => array('form-row privacy'),
	'label_class'   => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
	'input_class'   => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
	'required'      => true,
	'label'         => 'I\'ve read and accept the <a href="/general-terms-and-conditions-of-travel-packages-sale-contract/?lang=en">terms & conditions</a>',
	)); 
   
}
// Save custom checkout field value as custom order meta data and user meta data too
add_action( 'woocommerce_checkout_create_order', 'custom_checkout_field_update_order_meta', 20, 2 );
function custom_checkout_field_update_order_meta( $order, $data ) {
    if ( isset( $_POST['newsletter_acceptance'] ) ) {
        // Save custom checkout field value
        $order->update_meta_data( '_newsletter_acceptance', esc_attr( $_POST['newsletter_acceptance'] ) );

        // Save the custom checkout field value as user meta data
        if( $order->get_customer_id() )
            update_user_meta( $order->get_customer_id(), 'newsletter_acceptance', esc_attr( $_POST['newsletter_acceptance'] ) );
    }
    if ( isset( $_POST['privacy_policy'] ) ) {
        // Save custom checkout field value
        $order->update_meta_data( '_privacy_policy', esc_attr( $_POST['privacy_policy'] ) );

        // Save the custom checkout field value as user meta data
        if( $order->get_customer_id() )
            update_user_meta( $order->get_customer_id(), 'privacy_policy', esc_attr( $_POST['privacy_policy'] ) );
    }
    if ( isset( $_POST['terms_conditions'] ) ) {
        // Save custom checkout field value
        $order->update_meta_data( '_terms_conditions', esc_attr( $_POST['terms_conditions'] ) );

        // Save the custom checkout field value as user meta data
        if( $order->get_customer_id() )
            update_user_meta( $order->get_customer_id(), 'terms_conditions', esc_attr( $_POST['terms_conditions'] ) );
    }
}
   
// Show notice if customer does not tick
    
add_action( 'woocommerce_checkout_process', 'bbloomer_not_approved_privacy' );
   
function bbloomer_not_approved_privacy() {
    if ( ! (int) isset( $_POST['privacy_policy'] ) ) {
        wc_add_notice( __( 'Please acknowledge the Privacy Policy' ), 'error' );
    }
    if ( ! (int) isset( $_POST['terms_conditions'] ) ) {
        wc_add_notice( __( 'Please acknowledge the terms & conditions' ), 'error' );
    }
}


/**
 * Register meta box in wc order backend to show rooms details
 */
function vn_register_meta_box_order_admin() {
    add_meta_box( 'vn_order_quote_details', __( 'Rooms detail', 'wm-child-verdenatura' ), 'vn_order_admin_metabox_callback', 'shop_order', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'vn_register_meta_box_order_admin' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function vn_order_admin_metabox_callback( $post ) {
	$order = new WC_Order($post->ID);
	$coupon = $order->get_used_coupons();
	$coupon_name = $coupon['0'];
	$post = get_posts( array( 
		'name' => $coupon_name, 
		'post_type' => 'shop_coupon'
	) );
	$departure_date = '';
    $nightsBefore = '';
    $insurance_name = '';
    $insurance_price = '';
	$club_name = '';
	$place = '';
	$place_s = '';
	foreach ( $post as $info) {
		$description = $info->post_excerpt;
	}
	$desc = json_decode($description, JSON_PRETTY_PRINT);
	?>
    <div class="rooms-composition"> <!------- rooms composition -- ---->
    <?php
    
    foreach ($desc as $val => $key){
		if ($val == 'boat_trip') { //check if the route is in boat or not
			$place = __('cabin','wm-child-verdenatura'); 
			$place_s = __('cabins','wm-child-verdenatura'); 
		} else {
			$place = __('room','wm-child-verdenatura');
			$place_s = __('rooms','wm-child-verdenatura');
		}
        if ($val == 'departureDate') {
            $date = $key;
            $departure_date = date("Y-m-d", strtotime($date));
        }
        if ($val == 'nightsBefore') {
            $nightsBefore = $key;
        }
        if ($val == 'insurance') {
			$insurance_name = $key['name'];
			$insurance_price = $key['price'];
        }
        if ($val == 'club') {
            $club_name = $key['name'];
        }
    }
    foreach ($desc as $val => $key){
        if ($val == 'rooms') {
            $rooms = $key;?>
            <?php 
                echo '<div class="tour-general-info"><p><strong>';
                echo __('Departure date:' ,'wm-child-verdenatura').' </strong>';
                echo $departure_date.'</p>';
            if ( $nightsBefore ) {
                echo '<p><strong>';
                echo __('Nights Before:' ,'wm-child-verdenatura').' </strong>';
                echo $nightsBefore.'</p>';
            }
            if ( $insurance_name ) { 
                echo '<p><strong>';
                echo __('Cancellation insurance:' ,'wm-child-verdenatura').' </strong>';
                echo $insurance_name.' ('.$insurance_price.'%)</p>';
            }
            if ( $club_name ) {
                echo '<p><strong>';
                echo __('Club:' ,'wm-child-verdenatura').' </strong>';
                echo $club_name.'</p>';
            }
                echo '</div>';
            ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php
            foreach ($rooms as $val2 => $room){
                ?>
                <thead> <!--  table head  -->
                    <tr> <!--  table row head  -->
                        <th><?php $room_number = $val2 + 1; echo sprintf(__('%s number %s' ,'wm-child-verdenatura'),$place, $room_number);?></th>
                        <th><?php echo __('Personal info' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Rent bike' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike Warranty' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Share' ,'wm-child-verdenatura');?></th>
                    </tr>
                </thead> <!-- END table head  -->
                <tbody>
                <?php
                    foreach ($room as $val3 => $pax){
                        $firsName = $pax['firstName'];
                        $lastName = $pax['lastName'];
                        $birth_date = $pax['date'];
                        $price = $pax['price'];
                        $rentBike = '';
                        $babyseat = '';
                        $tagalong = '';
                        $trail = '';
                        $trailgator = '';
                        $bikeWarranty = '';
                        $helmet = '';
                        $roadbook = '';
						$halfboard = '';
						$cookingClass = '';
                        $transferBefore = '';
						$transferAfter = '';
						$doubleBed = '';
						$boardingtax = '';
						$shareRoom = '';
                        ?>
                        <tr>
                        <td></td>
                        <td>
							<?php echo $firsName.' '.$lastName; ?>
							<?php if ( $birth_date ) { echo '<br>'.date("Y-m-d", strtotime($birth_date)); } ?>
						</td>
                        
                        <?php
                        foreach ($pax as $val4 => $extra){
                            if ($val4 == 'rentBike'){
                                foreach ($extra as $val5 => $bikename){
                                    if ($val5 == 'name'){
                                        $rentBike = $bikename;
                                    }
                                }
                            }
                            if ($val4 == 'babySeat'){
                                $babyseat = true;
                            }
                            if ($val4 == 'tagAlong'){
                                $tagalong = true;
                            }
                            if ($val4 == 'trailer'){
                                $trail = true;
                            }
                            if ($val4 == 'trailgator'){
                                $trailgator = true;
                            }
                            if ($val4 == 'bikeWarranty'){
                                $bikeWarranty = true;
                            }
                            if ($val4 == 'helmet'){
                                $helmet = true;
                            }
                            if ($val4 == 'roadbook'){
                                $roadbook = true;
                            }
                            if ($val4 == 'halfboard'){
                                $halfboard = true;
							}
							if ($val4 == 'cookingClass'){
                                $cookingClass = true;
                            }
                            if ($val4 == 'transferBefore'){
                                $transferBefore = true;
                            }
                            if ($val4 == 'transferAfter'){
                                $transferAfter = true;
							}
							if ($val4 == 'doubleBed'){
                                $doubleBed = true;
                            }
                            if ($val4 == 'boardingtax'){
                                $boardingtax = true;
							}
							if ($val4 == 'shareRoom'){
                                $shareRoom = true;
                            }
                        }
                        ?>
                        <td><?php if($rentBike): switch ($rentBike) {
                            case 'bike':
                                echo __('Supplement for bike rental' ,'wm-child-verdenatura');
                                break;
                            case 'eBike':
                                echo __('Supplement for eBike rental' ,'wm-child-verdenatura');
                                break;
                            case 'kidBike':
                                echo __('Supplement for kidBike' ,'wm-child-verdenatura');
								break;
							case 'tandem':
                                echo __('Supplement for tandem rental' ,'wm-child-verdenatura');
								break;
							case 'roadbike':
                                echo __('Supplement for road bike rental' ,'wm-child-verdenatura');
                                break;
                                
                        } endif;?></td>
                        <td>
                            <?php if($babyseat): echo __('Baby seat' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($tagalong): echo __('Tag-along' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trail): echo __('Trailer' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trailgator): echo __('Trailgator' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php if($bikeWarranty):?><i class="icon-ok"></i><?php endif;?></td>
                        <td>
                            <?php if($helmet): echo __('Helmet' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($roadbook): echo __('Roadbook' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($halfboard): echo __('Halfboard' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
							<?php if($cookingClass): echo __('Cooking Class' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferBefore): echo __('Transfer before the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferAfter): echo __('Transfer after the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
							<?php if($doubleBed): echo __('Double Bed' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($boardingtax): echo __('Boarding tax' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($shareRoom): echo __('Shared room' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php echo $price.'€'; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody> 
                <?php
            }
            ?></table><?php
        }
    }
    ?>
    </div><!-- END rooms composition  --> 
    <?php
}

//  Email to customer with rooms details --------------------------------------------------------------------------------

add_action( 'woocommerce_email_before_order_table', 'ts_email_before_order_table', 10, 4 );
function ts_email_before_order_table( $order, $sent_to_admin, $plain_text, $email ) {
	
	$coupon_id = WC()->cart->get_coupons();
    foreach ($coupon_id as $val ){
        $json =  $val;
    }   
    $json_output = json_decode($json, JSON_PRETTY_PRINT); 
    $description = $json_output['description'];
	$desc = json_decode($description, JSON_PRETTY_PRINT);
	
	$departure_date = '';
    $nightsBefore = '';
    $insurance_name = '';
	$club_name = '';
	$place = '';
    $place_s = '';

	foreach ($desc as $val => $key){
		if ($val == 'boat_trip') { //check if the route is in boat or not
			$place = __('cabin','wm-child-verdenatura'); 
			$place_s = __('cabins','wm-child-verdenatura'); 
		} else {
			$place = __('room','wm-child-verdenatura');
			$place_s = __('rooms','wm-child-verdenatura');
		}
		if ($val == 'departureDate') {
            $date = $key;
            $departure_date = date("Y-m-d", strtotime($date));
        }
        if ($val == 'nightsBefore') {
            $nightsBefore = $key;
        }
        if ($val == 'insurance') {
            $insurance_name = $key['name'];
        }
        if ($val == 'club') {
            $club_name = $key['name'];
        }
	}
	?>
	<div class="rooms-composition"> <!------- rooms composition -- ---->
	<h2><?php echo sprintf(__('%s and Travelers\' details: ' ,'wm-child-verdenatura'), $place_s);?></h2>
    <?php
    
    foreach ($desc as $val => $key){
        if ($val == 'rooms') {
            $rooms = $key;?>
            <?php 
                echo '<div class="tour-general-info"><p><strong>';
                echo __('Departure date:' ,'wm-child-verdenatura').' </strong>';
                echo $departure_date.'</p>';
            if ( $nightsBefore ) {
                echo '<p><strong>';
                echo __('Nights Before:' ,'wm-child-verdenatura').' </strong>';
                echo $nightsBefore.'</p>';
            }
            if ( $insurance_name ) { 
                echo '<p><strong>';
                echo __('Cancellation insurance:' ,'wm-child-verdenatura').' </strong>';
                echo $insurance_name.'</p>';
            }
            if ( $club_name ) {
                echo '<p><strong>';
                echo __('Club:' ,'wm-child-verdenatura').' </strong>';
                echo $club_name.'</p>';
            }
                echo '</div>';
            ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <?php
            foreach ($rooms as $val2 => $room){
                ?>
                <thead> <!--  table head  -->
					<tr><th colspan="2" style="padding:0;"><?php $room_number = $val2 + 1; echo sprintf(__('%s number %s' ,'wm-child-verdenatura'),$place, $room_number);?></th></tr>
                    <tr> <!--  table row head  -->
                        <th><?php echo __('Name' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Rent bike' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Bike Warranty' ,'wm-child-verdenatura');?></th>
                        <th colspan="2"><?php echo __('Extras' ,'wm-child-verdenatura');?></th>
                        <th><?php echo __('Share' ,'wm-child-verdenatura');?></th>
                    </tr>
                </thead> <!-- END table head  -->
                <tbody>
                <?php
                    foreach ($room as $val3 => $pax){
                        $firsName = $pax['firstName'];
                        $lastName = $pax['lastName'];
                        $price = $pax['price'];
                        $rentBike = '';
                        $babyseat = '';
                        $tagalong = '';
                        $trail = '';
                        $trailgator = '';
                        $bikeWarranty = '';
                        $helmet = '';
                        $roadbook = '';
						$halfboard = '';
						$cookingClass = '';
                        $transferBefore = '';
						$transferAfter = '';
						$doubleBed = '';
						$boardingtax = '';
						$shareRoom = '';
                        ?>
                        <tr>
                        <td><?php echo $firsName.' '.$lastName; ?></td>
                        
                        <?php
                        foreach ($pax as $val4 => $extra){
                            if ($val4 == 'rentBike'){
                                foreach ($extra as $val5 => $bikename){
                                    if ($val5 == 'name'){
                                        $rentBike = $bikename;
                                    }
                                }
                            }
                            if ($val4 == 'babySeat'){
                                $babyseat = true;
                            }
                            if ($val4 == 'tagAlong'){
                                $tagalong = true;
                            }
                            if ($val4 == 'trailer'){
                                $trail = true;
                            }
                            if ($val4 == 'trailgator'){
                                $trailgator = true;
                            }
                            if ($val4 == 'bikeWarranty'){
                                $bikeWarranty = true;
                            }
                            if ($val4 == 'helmet'){
                                $helmet = true;
                            }
                            if ($val4 == 'roadbook'){
                                $roadbook = true;
                            }
                            if ($val4 == 'halfboard'){
                                $halfboard = true;
							}
							if ($val4 == 'cookingClass'){
                                $cookingClass = true;
                            }
                            if ($val4 == 'transferBefore'){
                                $transferBefore = true;
                            }
                            if ($val4 == 'transferAfter'){
                                $transferAfter = true;
							}
							if ($val4 == 'doubleBed'){
                                $doubleBed = true;
                            }
                            if ($val4 == 'boardingtax'){
                                $boardingtax = true;
							}
							if ($val4 == 'shareRoom'){
                                $shareRoom = true;
                            }
                        }
                        ?>
                        <td><?php if($rentBike): switch ($rentBike) {
                            case 'bike':
								echo __('Supplement for bike rental' ,'wm-child-verdenatura');
								break;
							case 'eBike':
								echo __('Supplement for eBike rental' ,'wm-child-verdenatura');
								break;
							case 'kidBike':
								echo __('Supplement for kidBike' ,'wm-child-verdenatura');
								break;
							case 'tandem':
								echo __('Supplement for tandem rental' ,'wm-child-verdenatura');
								break;
							case 'roadbike':
                                echo __('Supplement for road bike rental' ,'wm-child-verdenatura');
                                break;
                                
                        } endif;?></td>
                        <td>
                            <?php if($babyseat): echo __('Baby seat' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($tagalong): echo __('Tag-along' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trail): echo __('Trailer' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($trailgator): echo __('Trailgator' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php if($bikeWarranty):?><?php echo __('Yes' ,'wm-child-verdenatura'); ?><?php endif;?></td>
                        <td colspan="2">
                            <?php if($helmet): echo __('Helmet' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($roadbook): echo __('Roadbook' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($halfboard): echo __('Halfboard' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
							<?php if($cookingClass): echo __('Cooking Class' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferBefore): echo __('Transfer before the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($transferAfter): echo __('Transfer after the trip' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
							<?php if($doubleBed): echo __('Double Bed' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($boardingtax): echo __('Boarding tax' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                            <?php if($shareRoom): echo __('Shared room' ,'wm-child-verdenatura').'<br>';?><?php endif;?>
                        </td>
                        <td><?php echo $price.'€'; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>  
                <?php
            }
            ?></table><?php
        }
    }
    ?>
    </div><!-- END rooms composition  --> 
	<?php if ($club_name) { ?>
	<div style="margin: 20px 0;font-weight: bold;background-color: #e8e8e8;padding: 10px;"><?php echo sprintf(__('Remember to send to <a href="mailto:info@verde-natura.it">info@verde-natura.it</a> the photocopy of the %s association card that gives you the right to the discount' ,'wm-child-verdenatura'),$club_name); ?></div>
    <?php
	}
}

// change cart item (products) name in frontend - carrello -
add_action( 'woocommerce_before_calculate_totals', 'custom_cart_items_prices', 10, 1 );
function custom_cart_items_prices( $cart ) {
	// $order = new WC_Order($post->ID);
	// $coupon = $order->get_used_coupons();
	// $coupon_name = $coupon['0'];
	
	// $post = get_posts( array( 
	// 	'name' => $coupon_name, 
	// 	'post_type' => 'shop_coupon'
	// ) );
	$coupon_id = WC()->cart->get_coupons();
    foreach ($coupon_id as $val ){
        $json =  $val;
    }   
    $json_output = json_decode($json, JSON_PRETTY_PRINT); 
    $description = $json_output['description'];
    $desc = json_decode($description, JSON_PRETTY_PRINT);

	foreach ( $post as $info) {
		$description = $info->post_excerpt;
	}

	$desc = json_decode($description, JSON_PRETTY_PRINT);
	$kid1_max_range = '';
	$kid1_min_range = '';
	$kid2_max_range = '';
	$kid3_max_range = '';
	$kid4_max_range = '';
	$from = '';
	$to = '';
    foreach ($desc as $val => $key){
		if ($val == 'boat_trip') { //check if the route is in boat or not
			$place = __('cabin','wm-child-verdenatura'); 
			$place_s = __('cabins','wm-child-verdenatura'); 
		} else {
			$place = __('room','wm-child-verdenatura');
			$place_s = __('rooms','wm-child-verdenatura');
		}
		if ($val == 'from'){
            $from = $key;
        }
        if ($val == 'to'){
            $to = $key;
        }
		if ($val == 'hotel') {
			$kid1_max_range = $key['kidTiers'][1]['maxAge'];
			if ($key['kidTiers'][1]['minAge']) {
				$kid1_min_range = $key['kidTiers'][1]['minAge'];
			} else {
				$kid1_min_range = 0;
			}
			$kid2_max_range = $key['kidTiers'][2]['maxAge'];
			$kid3_max_range = $key['kidTiers'][3]['maxAge'];
			$kid4_max_range = $key['kid4']['maxAge'];
		}
	}
	
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
        return;

	// Loop through cart items
    foreach ( $cart->get_cart() as $cart_item ) {

        // Get an instance of the WC_Product object
        $product = $cart_item['data'];

        // Get the product name (Added Woocommerce 3+ compatibility)
        $original_name = method_exists( $product, 'get_name' ) ? $product->get_name() : $product->post->post_title;
		$original_desc = method_exists( $product, 'get_short_description' ) ? $product->get_description() : $product->post->post_title;
		$original = explode(' - ', $original_name);
		$original_last = end($original);
		if ( $original_last == 'adult'){
			$new_name = sprintf(__('Basic price in double %s' ,'wm-child-verdenatura'), $place);
		}
		elseif ( $original_last == 'adult-single'){
			$new_name = sprintf(__('Basic price in single %s' ,'wm-child-verdenatura'),$place);
		}
		elseif ( $original_last == 'single-traveller'){
			$new_name = sprintf(__('Supplement for single traveller' ,'wm-child-verdenatura'),$place);
		}
		elseif ( $original_last == 'adult-extra'){
			$new_name = __('Basic price in 3rd bed adult' ,'wm-child-verdenatura');
		}
		elseif ( preg_match("/kid1_/",$original_last)){
			$new_name = sprintf(__('3rd/4th bed child price %s/%s yo' ,'wm-child-verdenatura'),$kid1_min_range,$kid1_max_range);
		}
		elseif ( preg_match("/kid2_/",$original_last)){
			$new_name = sprintf(__('3rd/4th bed child price %d/%s yo' ,'wm-child-verdenatura'), $kid1_max_range+1, $kid2_max_range);
		}
		elseif ( preg_match("/kid3_/",$original_last)){
			$new_name = sprintf(__('3rd/4th bed child price %d/%s yo' ,'wm-child-verdenatura'), $kid2_max_range+1, $kid3_max_range);
		}
		elseif ( preg_match("/kid4_/",$original_last)){
			$new_name = sprintf(__('Child price 0/%d yo, in twin %s with adult' ,'wm-child-verdenatura'), $kid4_max_range, $place);
		}
		elseif ( $original_last == 'halfboard_adult'){
			$new_name = __('Supplement for half board' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'halfboard_kid1'){
			$new_name = sprintf(__('Supplement for half board child %s/%s yo' ,'wm-child-verdenatura'),$kid1_min_range,$kid1_max_range);
		}
		elseif ( $original_last == 'halfboard_kid2'){
			$new_name = sprintf(__('Supplement for half board child %d/%s yo' ,'wm-child-verdenatura'),$kid1_max_range+1, $kid2_max_range);
		}
		elseif ( $original_last == 'halfboard_kid3'){
			$new_name = sprintf(__('Supplement for half board child %d/%s yo' ,'wm-child-verdenatura'),$kid2_max_range+1, $kid3_max_range);
		}
		elseif ( $original_last == 'nightsBefore_adult'){
			$new_name = sprintf(__('Extra night in %s (Double %s)' ,'wm-child-verdenatura'),$from, $place);
		}
		elseif ( $original_last == 'nightsBefore_adult-single'){
			$new_name = sprintf(__('Supplement for extra night in %s (Single %s)' ,'wm-child-verdenatura'),$from, $place);
		}
		elseif ( $original_last == 'nightsBefore_adult-extra'){
			$new_name = sprintf(__('Extra night in %s (extra bed)' ,'wm-child-verdenatura'),$from);
		}
		elseif ( $original_last == 'nightsBefore_kid1'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$from,$kid1_min_range,$kid1_max_range);
		}
		elseif ( $original_last == 'nightsBefore_kid2'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$from,$kid1_max_range+1,$kid2_max_range);
		}
		elseif ( $original_last == 'nightsBefore_kid3'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$from,$kid2_max_range+1,$kid3_max_range);
		}
		elseif ( $original_last == 'nightsBefore_kid4'){
			$new_name = sprintf(__('Extra night in %s (Child in extra bed)' ,'wm-child-verdenatura'),$from);
		}
		elseif ( $original_last == 'nightsAfter_adult'){
			$new_name = sprintf(__('Extra night in %s (Double %s)' ,'wm-child-verdenatura'),$to, $place);
		}
		elseif ( $original_last == 'nightsAfter_adult-single'){
			$new_name = sprintf(__('Supplement for extra night in %s (Single %s)' ,'wm-child-verdenatura'),$to, $place);
		}
		elseif ( $original_last == 'nightsAfter_adult-extra'){
			$new_name = sprintf(__('Extra night in %s (extra bed)' ,'wm-child-verdenatura'),$to);
		}
		elseif ( $original_last == 'nightsAfter_kid1'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$to,$kid1_min_range,$kid1_max_range);
		}
		elseif ( $original_last == 'nightsAfter_kid2'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$to,$kid1_max_range+1,$kid2_max_range);
		}
		elseif ( $original_last == 'nightsAfter_kid3'){
			$new_name = sprintf(__('Extra night in %s (child %s/%s yo)' ,'wm-child-verdenatura'),$to,$kid2_max_range+1,$kid3_max_range);
		}
		elseif ( $original_last == 'nightsAfter_kid4'){
			$new_name = sprintf(__('Extra night in %s (Child in extra bed)' ,'wm-child-verdenatura'),$to);
		}
		elseif ( $original_last == 'boardingtax'){
			$new_name = __('Port charges (to be paid in advance)' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bike'){
			$new_name = __('Supplement for bike rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'ebike'){
			$new_name = __('Supplement for e-bike rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'kidbike'){
			$new_name = __('Supplement for children bike' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bike_tandem'){
			$new_name = __('Supplement for tandem rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bike_road'){
			$new_name = __('Supplement for road bike rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'babyseat'){
			$new_name = __('Supplement for child back seat rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'trailer'){
			$new_name = __('Supplement for children trailer rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'trailgator'){
			$new_name = __('Supplement for children trailgator' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'tagalong'){
			$new_name = __('Supplement for follow-me rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bikewarranty'){
			$new_name = __('Bike Coverage' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bike_tandemwarranty'){
			$new_name = __('Tandem bike Coverage' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'bike_roadwarranty'){
			$new_name = __('Road bike Coverage' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'ebikewarranty'){
			$new_name = __('E-bike Coverage' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'kidhelmet'){
			$new_name = __('Supplement for kid helmet rental' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'roadbook'){
			$new_name = __('Printed road book maps' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'cookingclass'){
			$new_name = __('Supplement for cooking class' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'transferBefore'){
			$new_name = __('Supplement for transfer before the trip' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'transferAfter'){
			$new_name = __('Supplement for transfer after the trip' ,'wm-child-verdenatura');
		}
		elseif ( $original_last == 'extra_differenthourarrival'){
			$new_name = $original_desc;
		}
		elseif ( $original_last == 'extra_differentdepartureday'){
			$new_name = $original_desc;
		}
		elseif ( $original_last == 'helmet'){
			$new_name = __('Supplement for adult helmet rental' ,'wm-child-verdenatura');
		} else {
			$new_name = $original_name;
		}

        // Set the new name (WooCommerce versions 2.5.x to 3+)
        if( method_exists( $product, 'set_name' ) )
            $product->set_name( $new_name );
        else
            $product->post->post_title = $new_name;
    }
}

// Sets the product type to Variable product on product page woocommerce
add_action( 'admin_footer', 'product_type_selector_filter_callback' );
function product_type_selector_filter_callback() {
    global $pagenow, $post_type;

    if( $post_type === 'product' ) :
    ?>
    <script>
    jQuery(function($){
        $('select#product-type').val('variable');
    });
    </script>
    <?php
    endif;
}

// add return to form preventivi (calcolatore) button on cart page
add_action('woocommerce_proceed_to_checkout','add_back_to_form_quotes');
function add_back_to_form_quotes(){
	if (isset($_GET['lang'])){
		$page_langauge = $_GET['lang'];
	} else {
		$page_langauge = 'it';
	}
	$coupon_id = WC()->cart->get_coupons();
	$coupon_ids_applied = WC()->cart->get_applied_coupons();
	$coupon_id_applied = wc_get_coupon_id_by_code($coupon_ids_applied[0]);
	
	$route_id = '';
    foreach ($coupon_id as $val ){
		$json =  $val;
	}  
    $json_output = json_decode($json, JSON_PRETTY_PRINT); 
    $description = $json_output['description'];
    $desc = json_decode($description, JSON_PRETTY_PRINT);
    foreach ($desc as $val => $key){
        if ($val == 'routeId') { //check if the route is in boat or not
			$route_id = $key;
		} 
	}
	?>
	<div class="wc-proceed-to-checkout">
		
		<a id="modifica-ordine" href="http://vnquote.webmapp.it/#/<?php echo $route_id;?>/<?php echo $coupon_id_applied;?>?lang=<?php echo $page_langauge; ?>" class="checkout-button button alt wc-forward">
			<?php echo __('Modify your quote', 'wm-child-verdenatura') ?></a>
	</div>
	<?php
}

// add ID to proceed to checkout in cart page 
function woocommerce_button_proceed_to_checkout() {
	$checkout_url = WC()->cart->get_checkout_url(); ?>
	<a id="concludi-ordine" href="<?php echo esc_url( wc_get_checkout_url() );?>" class="checkout-button button alt wc-forward">
	<?php esc_html_e( 'Proceed to checkout', 'woocommerce' ); ?>
	</a>
	<?php
}



// DEFINIZIONE DEL DATAMODEL x ROUTE ------------------------------------------------------------------------------------------------
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'wm_route_quote',
	'title' => 'Date e preventivo',
	'fields' => array(
		array(
			'key' => 'wm_route_quote_tab_model',
			'label' => 'Modello',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_not_salable',
			'label' => 'Route non vendibile',
			'name' => 'not_salable',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Non vendibile',
			'default_value' => 1,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
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
			'min' => 0,
			'max' => 10,
			'return_format' => 'id',
		),
		array(
			'key' => 'wm_route_quote_tab_model_season',
			'label' => 'Modello (stagioni)',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'wm_route_quote_season_repeater',
			'label' => 'Periodi di prezzo (stagionalità)',
			'name' => 'model_season',
			'type' => 'repeater',
			'layout' => 'row',
			'sub_fields' => array(
				array(
					'key' => 'wm_route_quote_model_season_name',
					'label' => 'Stagionalità',
					'name' => 'season_name',
					'type' => 'text',
					'instructions' => 'Inserire ad esempio: Alta Stagione, Bassa Stagione',
				),
				array(
					'key' => 'wm_route_quote_model_season_dates_periods_repeater',
					'label' => 'Periodi di partenza',
					'name' => 'periods',
					'type' => 'repeater',
					'layout' => 'table',
					'sub_fields' => array(
						array(
							'key' => 'wm_route_quote_model_season_dates_periods_start',
							'label' => 'Inizio',
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
							'key' => 'wm_route_quote_model_season_dates_periods_stop',
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
					),
				),

				array(
					'key' => 'wm_route_quote_model_season_product',
					'label' => 'Modello product',
					'name' => 'product',
					'type' => 'relationship',
					'instructions' => 'Inserisci i modelli di prodotto creati per questa Stagionalità',
					'post_type' => array(
						0 => 'product',
					),
					'min' => 0,
					'max' => 10,
					'return_format' => 'id',
				),
			),
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
					'name' => 'period_name',
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
			'min' => 0,
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

// DEFINIZIONE DEL DATAMODEL x BARCHE ------------------------------------------------------------------------------------------------
if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array(
		'key' => 'wm_barche',
		'title' => 'Barche info',
		'fields' => array(
			array(
				'key' => 'wm_barche_riassunto',
				'label' => 'Riassunto',
				'name' => 'riassunto',
				'type' => 'textarea',
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
				'maxlength' => '',
				'rows' => '',
				'new_lines' => '',
			),
			array(
				'key' => 'wm_barche_gallery',
				'label' => 'Gallery',
				'name' => 'gallery',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'barche',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	));
	
	endif;

	// DEFINIZIONE DEL DATAMODEL x la data di partenza nel Backend degli Ordini ---------------------------------------------------------------------------------------------------
	if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array(
			'key' => 'group_5d63fd404135a',
			'title' => 'Order departure date',
			'fields' => array(
				array(
					'key' => 'field_5d63fd58692ca',
					'label' => 'Order departure date',
					'name' => 'order_departure_date',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => 'order-departure-date',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'shop_order',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'seamless',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => true,
			'description' => '',
		));
		
		endif;