<?php
/*
  PayPal Standard - Payment Gateway
 * ENABLE AUTO-RETURN https://www.paypal.com/rs/cgi-bin/webscr?cmd=p/mer/express_return_summary-outside
 */

class TC_Gateway_PayPal_Standard extends TC_Gateway_API {

	var $plugin_name				 = 'paypal_standard';
	var $admin_name				 = '';
	var $public_name				 = '';
	var $method_img_url			 = '';
	var $admin_img_url			 = '';
	var $force_ssl				 = false;
	var $ipn_url;
	var $business, $SandboxFlag, $returnURL, $cancelURL, $API_Endpoint, $version, $currency, $locale;
	var $currencies				 = array();
	var $automatically_activated	 = false;
	var $skip_payment_screen		 = true;

	//Support for older payment gateway API
	function on_creation() {
		$this->init();
	}

	function init() {
		global $tc;

		$this->admin_name	 = __( 'PayPal Standard', 'tc' );
		$this->public_name	 = __( 'PayPal', 'tc' );

		$this->method_img_url	 = apply_filters( 'tc_gateway_method_img_url', $tc->plugin_url . 'images/gateways/paypal-standard.png', $this->plugin_name );
		$this->admin_img_url	 = apply_filters( 'tc_gateway_admin_img_url', $tc->plugin_url . 'images/gateways/small-paypal-standard.png', $this->plugin_name );

		$this->currency		 = $this->get_option( 'currency', 'USD' );
		$this->SandboxFlag	 = $this->get_option( 'mode', 'sandbox' );
		$this->business		 = $this->get_option( 'email' );
		$this->locale		 = $this->get_option( 'locale', 'US' );

		$currencies = array(
			"AUD"	 => __( 'AUD - Australian Dollar', 'tc' ),
			"BRL"	 => __( 'BRL - Brazilian Real', 'tc' ),
			"CAD"	 => __( 'CAD - Canadian Dollar', 'tc' ),
			"CZK"	 => __( 'CZK - Czech Koruna', 'tc' ),
			"DKK"	 => __( 'DKK - Danish Krone', 'tc' ),
			"EUR"	 => __( 'EUR - Euro', 'tc' ),
			"HKD"	 => __( 'HKD - Hong Kong Dollar', 'tc' ),
			"HUF"	 => __( 'HUF - Hungarian Forint', 'tc' ),
			"ILS"	 => __( 'ILS - Israeli New Shekel', 'tc' ),
			"JPY"	 => __( 'JPY - Japanese Yen', 'tc' ),
			"MYR"	 => __( 'MYR - Malaysian Ringgit', 'tc' ),
			"MXN"	 => __( 'MXN - Mexican Peso', 'tc' ),
			"NOK"	 => __( 'NOK - Norwegian Krone', 'tc' ),
			"NZD"	 => __( 'NZD - New Zealand Dollar', 'tc' ),
			"PHP"	 => __( 'PHP - Philippine Peso', 'tc' ),
			"PLN"	 => __( 'PLN - Polish Zloty', 'tc' ),
			"GBP"	 => __( 'GBP - Pound Sterling', 'tc' ),
			"RUB"	 => __( 'RUB - Russian Ruble', 'tc' ),
			"SGD"	 => __( 'SGD - Singapore Dollar', 'tc' ),
			"SEK"	 => __( 'SEK - Swedish Krona', 'tc' ),
			"CHF"	 => __( 'CHF - Swiss Franc', 'tc' ),
			"TWD"	 => __( 'TWD - Taiwan New Dollar', 'tc' ),
			"TRY"	 => __( 'TRY - Turkish Lira', 'tc' ),
			"USD"	 => __( 'USD - U.S. Dollar', 'tc' ),
			"THB"	 => __( 'THB - Thai Baht', 'tc' ),
		);

		$this->currencies = apply_filters( 'tc_paypal_standard_currencies', $currencies );

		$locales = array(
			'AU' => __( 'Australia', 'tc' ),
			'AT' => __( 'Austria', 'tc' ),
			'BE' => __( 'Belgium', 'tc' ),
			'CA' => __( 'Canada', 'tc' ),
			'CN' => __( 'China', 'tc' ),
			'FR' => __( 'France', 'tc' ),
			'DE' => __( 'Germany', 'tc' ),
			'HK' => __( 'Hong Kong', 'tc' ),
			'IT' => __( 'Italy', 'tc' ),
			'MX' => __( 'Mexico', 'tc' ),
			'NL' => __( 'Netherlands', 'tc' ),
			'NZ' => __( 'New Zealand', 'tc' ),
			'PL' => __( 'Poland', 'tc' ),
			'SG' => __( 'Singapore', 'tc' ),
			'ES' => __( 'Spain', 'tc' ),
			'SE' => __( 'Sweden', 'tc' ),
			'CH' => __( 'Switzerland', 'tc' ),
			'GB' => __( 'United Kingdom', 'tc' ),
			'US' => __( 'United States', 'tc' ),
			'MY' => __( 'Malaysia', 'tc' )
		);

		$this->locales = apply_filters( 'tc_paypal_standard_locales', $locales );
	}

	function payment_form( $cart ) {
		global $tc;
		if ( isset( $_GET[ $this->cancel_slug ] ) ) {
			$_SESSION[ 'tc_gateway_error' ] = __( 'Your transaction has been canceled.', 'tc' );
			wp_redirect( $tc->get_payment_slug( true ) );
			tc_js_redirect( $tc->get_payment_slug( true ) );
			exit;
		}
	}

	function process_payment( $cart ) {
		global $tc;

		$this->maybe_start_session();
		$this->save_cart_info();

		$order_id = $tc->generate_order_id();

		$params						 = array();
		$params[ 'no_shipping' ]	 = '1'; //do not prompt for an address
		$params[ 'cmd' ]			 = '_xclick';
		$params[ 'business' ]		 = $this->business;
		$params[ 'currency_code' ]	 = $this->currency;
		$params[ 'item_name' ]		 = $this->cart_items();
		$params[ 'amount' ]			 = $this->total();
		$params[ 'custom' ]			 = $order_id;
		$params[ 'return' ]			 = $tc->get_confirmation_slug( true, $order_id );
		$params[ 'cancel_return' ]	 = apply_filters( 'tc_paypal_standard_cancel_url', $this->cancel_url );
		$params[ 'notify_url' ]		 = $this->ipn_url;
		$params[ 'charset' ]		 = apply_filters( 'tc_paypal_standard_charset', 'UTF-8' );
		$params[ 'rm' ]				 = '2'; //the buyer's browser is redirected to the return URL by using the POST method, and all payment variables are included
		$params[ 'lc' ]				 = $this->locale;
		$params[ 'email' ]			 = $this->buyer_info( 'email' );
		$params[ 'first_name' ]		 = $this->buyer_info( 'first_name' );
		$params[ 'last_name' ]		 = $this->buyer_info( 'last_name' );

		if ( $this->SandboxFlag == 'live' ) {
			$url = 'https://www.paypal.com/cgi-bin/webscr';
		} else {
			$params[ 'demo' ]	 = 'Y';
			$url				 = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
		}

		$param_list = array();

		foreach ( $params as $k => $v ) {
			$param_list[] = "{$k}=" . rawurlencode( $v );
		}

		$param_str = implode( '&', $param_list );

		$paid = false;

		$payment_info = $this->save_payment_info();

		$tc->create_order( $order_id, $this->cart_contents(), $this->cart_info(), $payment_info, $paid );

		wp_redirect( "{$url}?{$param_str}" );
		tc_js_redirect( "{$url}?{$param_str}" );

		exit( 0 );
	}

	function order_confirmation( $order, $payment_info = '', $cart_info = '' ) {
		global $tc;

		if ( isset( $_POST[ 'payment_status' ] ) || isset( $_POST[ 'txn_type' ] ) ) {
			echo '';

			$total		 = $_REQUEST[ 'mc_gross' ];
			$order_var	 = $_REQUEST[ 'custom' ];
			$order		 = tc_get_order_id_by_name( $order_var );

			$raw_post_data	 = file_get_contents( 'php://input' );
			$raw_post_array	 = explode( '&', $raw_post_data );
			$myPost			 = array();

			foreach ( $raw_post_array as $keyval ) {
				$keyval					 = explode( '=', $keyval );
				if ( count( $keyval ) == 2 )
					$myPost[ $keyval[ 0 ] ]	 = urldecode( $keyval[ 1 ] );
			}

			$req = 'cmd=_notify-validate';

			if ( function_exists( 'get_magic_quotes_gpc' ) ) {
				$get_magic_quotes_exists = true;
			}

			foreach ( $myPost as $key => $value ) {
				if ( $get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1 ) {
					$value = urlencode( stripslashes( $value ) );
				} else {
					$value = urlencode( $value );
				}
				$req .= "&$key=$value";
			}

			if ( $this->get_option( 'mode', 'sandbox' ) == 'sandbox' ) {
				$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			} else {
				$url = 'https://www.paypal.com/cgi-bin/webscr';
			}

			$args[ 'user-agent' ]	 = $tc->title;
			$args[ 'body' ]			 = $req;
			$args[ 'sslverify' ]	 = false;
			$args[ 'timeout' ]		 = 60;

			$response = wp_remote_post( $url, $args );

			if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) != 200 ) { //|| $response[ 'body' ] != 'VERIFIED' 
				//do nothing, wait for IPN message
			} else {//request is verified
				switch ( $_POST[ 'payment_status' ] ) {
					case 'Completed':
						$tc->update_order_payment_status( $order->ID, true );
						break;

					case 'Processed':
						//$tc->update_order_payment_status( $order->ID, true );
						break;

					case 'Canceled-Reversal':
						//$tc->update_order_payment_status( $order->ID, true );
						break;

					default:
					//do nothing, wait for IPN message
				}
				$tc->remove_order_session_data();
			}
		}
	}

	function gateway_admin_settings( $settings, $visible ) {
		global $tc;
		?>
		<div id="<?php echo $this->plugin_name; ?>" class="postbox" <?php echo (!$visible ? 'style="display:none;"' : ''); ?>>
			<h3 class='handle'><span><?php printf( __( '%s Settings', 'tc' ), $this->admin_name ); ?></span></h3>
			<div class="inside">
				<span class="description">
					<?php _e( "Sell tickets via PayPal standard payment gateway", 'tc' ); ?>
				</span>

				<?php
				$fields	 = array(
					'mode'		 => array(
						'title'		 => __( 'Mode', 'tc' ),
						'type'		 => 'select',
						'options'	 => array(
							'sandbox'	 => __( 'Sandbox / Test', 'tc' ),
							'live'		 => __( 'Live', 'tc' )
						),
						'default'	 => '0',
					),
					'email'		 => array(
						'title'	 => __( 'PayPal E-Mail', 'tc' ),
						'type'	 => 'text',
					),
					'locale'	 => array(
						'title'		 => __( 'Locale', 'tc' ),
						'type'		 => 'select',
						'options'	 => $this->locales,
						'default'	 => 'US',
					),
					'currency'	 => array(
						'title'		 => __( 'Currency', 'tc' ),
						'type'		 => 'select',
						'options'	 => $this->currencies,
						'default'	 => 'USD',
					),
				);
				$form	 = new TC_Form_Fields_API( $fields, 'tc', 'gateways', $this->plugin_name );
				?>
				<table class="form-table">
					<?php $form->admin_options(); ?>
				</table>
			</div>
		</div>
		<?php
	}

	function ipn() {
		global $tc;
		if ( isset( $_REQUEST[ 'custom' ] ) ) {
			$this->order_confirmation( $_REQUEST[ 'custom' ] );
		}
	}

}

tc_register_gateway_plugin( 'TC_Gateway_PayPal_Standard', 'paypal_standard', __( 'PayPal Standard', 'tc' ) );
?>