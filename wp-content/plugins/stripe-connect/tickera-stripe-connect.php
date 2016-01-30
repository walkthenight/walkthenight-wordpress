<?php
/*
  Plugin Name: Stripe Connect for Tickera
  Plugin URI: http://tickera.com/
  Description: Collect fees from every sale on your multisite network
  Author: Tickera.com
  Author URI: http://tickera.com/
  Version: 1.2.2.1
  TextDomain: tc
  Domain Path: /languages/
  Network: true
  Copyright 2012-2015 Tickera (http://tickera.com/)
 */

if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

add_action( 'init', 'tc_stripe_connect_gateway_init' );
add_filter( 'tc_gateway_plugins', 'tc_stripe_connect_deregister_tc_gateway_plugins', 10, 2 );

function tc_stripe_connect_deregister_tc_gateway_plugins( $gateways, $gateways_originals ) {
	$gateway_index = 0;
	foreach ( $gateways as $gateway ) {
		if ( preg_match( '/stripe/', $gateway ) ) {
			unset( $gateways[ $gateway_index ] );
		}
		$gateway_index++;
	}
	return $gateways;
}

function tc_stripe_connect_gateway_init() {
	load_plugin_textdomain( 'tc', false, basename( dirname( __FILE__ ) ) . '/languages' );
}

add_action( 'tc_load_gateway_plugins', 'register_stripe_connect_gateway' );

function register_stripe_connect_gateway() {

	class TC_Gateway_Stripe_Connect extends TC_Gateway_API {

		var $plugin_name				 = 'stripe-connect';
		var $admin_name				 = '';
		var $public_name				 = '';
		var $method_img_url			 = '';
		var $admin_img_url			 = '';
		var $force_ssl;
		var $ipn_url;
		var $publishable_key, $private_key, $currency;
		var $currencies				 = array();
		var $automatically_activated	 = false;
		var $skip_payment_screen		 = false;
		var $version					 = '1.2.2';
		var $title					 = 'Stripe Connect';
		var $name					 = 'tc_stripe_connect';
		var $dir_name				 = 'stripe-connect';
		var $location				 = 'plugins';
		var $plugin_dir				 = '';
		var $plugin_url				 = '';
		var $token_url				 = 'https://connect.stripe.com/oauth/token';
		var $authorize_url			 = 'https://connect.stripe.com/oauth/authorize';

		//Support for older payment gateway API
		function on_creation() {
			$this->init();
		}

		function init() {
			global $tc;

			add_action( 'template_redirect', array( &$this, 'stripe_authorization' ) );

			$this->init_vars();

			$settings			 = get_option( 'tc_settings' );
			$network_settings	 = get_site_option( 'tc_network_settings', array() );

			$this->admin_name	 = __( 'Stripe', 'tc' );
			$this->public_name	 = __( 'Stripe', 'tc' );

			$this->method_img_url = apply_filters( 'tc_gateway_method_img_url', $tc->plugin_url . 'images/gateways/stripe.png', $this->plugin_name );

			if ( is_multisite() && is_network_admin() ) {
				$this->admin_img_url = apply_filters( 'tc_gateway_network_admin_img_url', $this->plugin_url . 'images/small-stripe-connect.png', $this->plugin_name );
			} else {
				$this->admin_img_url = apply_filters( 'tc_gateway_admin_img_url', $tc->plugin_url . 'images/gateways/small-stripe.png', $this->plugin_name );
			}

			$this->publishable_key	 = $this->get_option( 'publishable_key' );
			$this->private_key		 = $this->get_option( 'private_key' );

			$this->force_ssl = (bool) $this->get_option( 'is_ssl', false );
			$this->currency	 = $this->get_option( 'currency', 'USD' );

			$this->client_id	 = $network_settings[ 'gateways' ][ $this->plugin_name ][ 'client_id' ];
			$this->secret_key	 = $network_settings[ 'gateways' ][ $this->plugin_name ][ 'private_key' ];

			add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

			$currencies = array(
				"AED"	 => __( 'AED - United Arab Emirates Dirham', 'tc' ),
				"AFN"	 => __( 'AFN - Afghan Afghani', 'tc' ),
				"ALL"	 => __( 'ALL - Albanian Lek', 'tc' ),
				"AMD"	 => __( 'AMD - Armenian Dram', 'tc' ),
				"ANG"	 => __( 'ANG - Netherlands Antillean Gulden', 'tc' ),
				"AOA"	 => __( 'AOA - Angolan Kwanza', 'tc' ),
				"ARS"	 => __( 'ARS - Argentine Peso', 'tc' ),
				"AUD"	 => __( 'AUD - Australian Dollar', 'tc' ),
				"AWG"	 => __( 'AWG - Aruban Florin', 'tc' ),
				"AZN"	 => __( 'AZN - Azerbaijani Manat', 'tc' ),
				"BAM"	 => __( 'BAM - Bosnia & Herzegovina Convertible Mark', 'tc' ),
				"BBD"	 => __( 'BBD - Barbadian Dollar', 'tc' ),
				"BDT"	 => __( 'BDT - Bangladeshi Taka', 'tc' ),
				"BGN"	 => __( 'BGN - Bulgarian Lev', 'tc' ),
				"BIF"	 => __( 'BIF - Burundian Franc', 'tc' ),
				"BMD"	 => __( 'BMD - Bermudian Dollar', 'tc' ),
				"BND"	 => __( 'BND - Brunei Dollar', 'tc' ),
				"BOB"	 => __( 'BOB - Bolivian Boliviano', 'tc' ),
				"BRL"	 => __( 'BRL - Brazilian Real', 'tc' ),
				"BSD"	 => __( 'BSD - Bahamian Dollar', 'tc' ),
				"BWP"	 => __( 'BWP - Botswana Pula', 'tc' ),
				"BZD"	 => __( 'BZD - Belize Dollar', 'tc' ),
				"CAD"	 => __( 'CAD - Canadian Dollar', 'tc' ),
				"CDF"	 => __( 'CDF - Congolese Franc', 'tc' ),
				"CHF"	 => __( 'CHF - Swiss Franc', 'tc' ),
				"CLP"	 => __( 'CLP - Chilean Peso', 'tc' ),
				"CNY"	 => __( 'CNY - Chinese Renminbi Yuan', 'tc' ),
				"COP"	 => __( 'COP - Colombian Peso', 'tc' ),
				"CRC"	 => __( 'CRC - Costa Rican Colon', 'tc' ),
				"CVE"	 => __( 'CVE - Cape Verdean Escudo', 'tc' ),
				"CZK"	 => __( 'CZK - Czech Koruna', 'tc' ),
				"DJF"	 => __( 'DJF - Djiboutian Franc', 'tc' ),
				"DKK"	 => __( 'DKK - Danish Krone', 'tc' ),
				"DOP"	 => __( 'DOP - Dominican Peso', 'tc' ),
				"DZD"	 => __( 'DZD - Algerian Dinar', 'tc' ),
				"EEK"	 => __( 'EEK - Estonian Kroon', 'tc' ),
				"EGP"	 => __( 'EGP - Egyptian Pound', 'tc' ),
				"ETB"	 => __( 'ETB - Ethiopian Birr', 'tc' ),
				"EUR"	 => __( 'EUR - Euro', 'tc' ),
				"FJD"	 => __( 'FJD - Fijian Dollar', 'tc' ),
				"FKP"	 => __( 'FKP - Falkland Islands Pound', 'tc' ),
				"GBP"	 => __( 'GBP - British Pound', 'tc' ),
				"GEL"	 => __( 'GEL - Georgian Lari', 'tc' ),
				"GIP"	 => __( 'GIP - Gibraltar Pound', 'tc' ),
				"GMD"	 => __( 'GMD - Gambian Dalasi', 'tc' ),
				"GNF"	 => __( 'GNF - Guinean Franc', 'tc' ),
				"GTQ"	 => __( 'GTQ - Guatemalan Quetzal', 'tc' ),
				"GYD"	 => __( 'GYD - Guyanese Dollar', 'tc' ),
				"HKD"	 => __( 'HKD - Hong Kong Dollar', 'tc' ),
				"HNL"	 => __( 'HNL - Honduran Lempira', 'tc' ),
				"HRK"	 => __( 'HRK - Croatian Kuna', 'tc' ),
				"HTG"	 => __( 'HTG - Haitian Gourde', 'tc' ),
				"HUF"	 => __( 'HUF - Hungarian Forint', 'tc' ),
				"IDR"	 => __( 'IDR - Indonesian Rupiah', 'tc' ),
				"ILS"	 => __( 'ILS - Israeli New Sheqel', 'tc' ),
				"INR"	 => __( 'INR - Indian Rupee', 'tc' ),
				"ISK"	 => __( 'ISK - Icelandic Krona', 'tc' ),
				"JMD"	 => __( 'JMD - Jamaican Dollar', 'tc' ),
				"JPY"	 => __( 'JPY - Japanese Yen', 'tc' ),
				"KES"	 => __( 'KES - Kenyan Shilling', 'tc' ),
				"KGS"	 => __( 'KGS - Kyrgyzstani Som', 'tc' ),
				"KHR"	 => __( 'KHR - Cambodian Riel', 'tc' ),
				"KMF"	 => __( 'KMF - Comorian Franc', 'tc' ),
				"KRW"	 => __( 'KRW - South Korean Won', 'tc' ),
				"KYD"	 => __( 'KYD - Cayman Islands Dollar', 'tc' ),
				"KZT"	 => __( 'KZT - Kazakhstani Tenge', 'tc' ),
				"LAK"	 => __( 'LAK - Lao Kip', 'tc' ),
				"LBP"	 => __( 'LBP - Lebanese Pound', 'tc' ),
				"LKR"	 => __( 'LKR - Sri Lankan Rupee', 'tc' ),
				"LRD"	 => __( 'LRD - Liberian Dollar', 'tc' ),
				"LSL"	 => __( 'LSL - Lesotho Loti', 'tc' ),
				"LTL"	 => __( 'LTL - Lithuanian Litas', 'tc' ),
				"LVL"	 => __( 'LVL - Latvian Lats', 'tc' ),
				"MAD"	 => __( 'MAD - Moroccan Dirham', 'tc' ),
				"MDL"	 => __( 'MDL - Moldovan Leu', 'tc' ),
				"MGA"	 => __( 'MGA - Malagasy Ariary', 'tc' ),
				"MKD"	 => __( 'MKD - Macedonian Denar', 'tc' ),
				"MNT"	 => __( 'MNT - Mongolian Tögrög', 'tc' ),
				"MOP"	 => __( 'MOP - Macanese Pataca', 'tc' ),
				"MRO"	 => __( 'MRO - Mauritanian Ouguiya', 'tc' ),
				"MUR"	 => __( 'MUR - Mauritian Rupee', 'tc' ),
				"MVR"	 => __( 'MVR - Maldivian Rufiyaa', 'tc' ),
				"MWK"	 => __( 'MWK - Malawian Kwacha', 'tc' ),
				"MXN"	 => __( 'MXN - Mexican Peso', 'tc' ),
				"MYR"	 => __( 'MYR - Malaysian Ringgit', 'tc' ),
				"MZN"	 => __( 'MZN - Mozambican Metical', 'tc' ),
				"NAD"	 => __( 'NAD - Namibian Dollar', 'tc' ),
				"NGN"	 => __( 'NGN - Nigerian Naira', 'tc' ),
				"NIO"	 => __( 'NIO - Nicaraguan Cordoba', 'tc' ),
				"NOK"	 => __( 'NOK - Norwegian Krone', 'tc' ),
				"NPR"	 => __( 'NPR - Nepalese Rupee', 'tc' ),
				"NZD"	 => __( 'NZD - New Zealand Dollar', 'tc' ),
				"PAB"	 => __( 'PAB - Panamanian Balboa', 'tc' ),
				"PEN"	 => __( 'PEN - Peruvian Nuevo Sol', 'tc' ),
				"PGK"	 => __( 'PGK - Papua New Guinean Kina', 'tc' ),
				"PHP"	 => __( 'PHP - Philippine Peso', 'tc' ),
				"PKR"	 => __( 'PKR - Pakistani Rupee', 'tc' ),
				"PLN"	 => __( 'PLN - Polish Zloty', 'tc' ),
				"PYG"	 => __( 'PYG - Paraguayan Guaraní', 'tc' ),
				"QAR"	 => __( 'QAR - Qatari Riyal', 'tc' ),
				"RON"	 => __( 'RON - Romanian Leu', 'tc' ),
				"RSD"	 => __( 'RSD - Serbian Dinar', 'tc' ),
				"RUB"	 => __( 'RUB - Russian Ruble', 'tc' ),
				"RWF"	 => __( 'RWF - Rwandan Franc', 'tc' ),
				"SAR"	 => __( 'SAR - Saudi Riyal', 'tc' ),
				"SBD"	 => __( 'SBD - Solomon Islands Dollar', 'tc' ),
				"SCR"	 => __( 'SCR - Seychellois Rupee', 'tc' ),
				"SEK"	 => __( 'SEK - Swedish Krona', 'tc' ),
				"SGD"	 => __( 'SGD - Singapore Dollar', 'tc' ),
				"SHP"	 => __( 'SHP - Saint Helenian Pound', 'tc' ),
				"SLL"	 => __( 'SLL - Sierra Leonean Leone', 'tc' ),
				"SOS"	 => __( 'SOS - Somali Shilling', 'tc' ),
				"SRD"	 => __( 'SRD - Surinamese Dollar', 'tc' ),
				"STD"	 => __( 'STD - São Tomé and Príncipe Dobra', 'tc' ),
				"SVC"	 => __( 'SVC - Salvadoran Colon', 'tc' ),
				"SZL"	 => __( 'SZL - Swazi Lilangeni', 'tc' ),
				"THB"	 => __( 'THB - Thai Baht', 'tc' ),
				"TJS"	 => __( 'TJS - Tajikistani Somoni', 'tc' ),
				"TOP"	 => __( 'TOP - Tonga Pa\'anga', 'tc' ),
				"TRY"	 => __( 'TRY - Turkish Lira', 'tc' ),
				"TTD"	 => __( 'TTD - Trinidad and Tobago Dollar', 'tc' ),
				"TWD"	 => __( 'TWD - New Taiwan Dollar', 'tc' ),
				"TZS"	 => __( 'TZS - Tanzanian Shilling', 'tc' ),
				"UAH"	 => __( 'UAH - Ukrainian Hryvnia', 'tc' ),
				"UGX"	 => __( 'UGX - Ugandan Shilling', 'tc' ),
				"USD"	 => __( 'USD - United States Dollar', 'tc' ),
				"UYI"	 => __( 'UYI - Uruguayan Peso', 'tc' ),
				"UZS"	 => __( 'UZS - Uzbekistani Som', 'tc' ),
				"VEF"	 => __( 'VEF - Venezuelan Bolivar', 'tc' ),
				"VND"	 => __( 'VND - Vietnamese Dong ', 'tc' ),
				"VUV"	 => __( 'VUV - Vanuatu Vatu', 'tc' ),
				"WST"	 => __( 'WST - Samoan Tala', 'tc' ),
				"XAF"	 => __( 'XAF - Central African Cfa Franc', 'tc' ),
				"XCD"	 => __( 'XCD - East Caribbean Dollar', 'tc' ),
				"XOF"	 => __( 'XOF - West African Cfa Franc', 'tc' ),
				"XPF"	 => __( 'XPF - Cfp Franc', 'tc' ),
				"YER"	 => __( 'YER - Yemeni Rial', 'tc' ),
				"ZAR"	 => __( 'ZAR - South African Rand', 'tc' ),
				"ZMW"	 => __( 'ZMW - Zambian Kwacha', 'tc' ),
			);

			$this->currencies = $currencies;
		}

		function stripe_authorization() {
			if ( isset( $_GET[ 'code' ] ) ) { // Redirect w/ code
				$settings	 = get_option( 'tc_settings' );
				$code		 = $_GET[ 'code' ];

				$token_request_body = array(
					'client_secret'	 => $this->secret_key,
					'grant_type'	 => 'authorization_code',
					'client_id'		 => $this->client_id,
					'code'			 => $code,
				);

				$req = curl_init( $this->token_url );
				curl_setopt( $req, CURLOPT_SSL_VERIFYPEER, FALSE );
				curl_setopt( $req, CURLOPT_CAINFO, "cacert.pem" );
				curl_setopt( $req, CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $req, CURLOPT_POST, true );
				curl_setopt( $req, CURLOPT_POSTFIELDS, http_build_query( $token_request_body ) );

				// TODO: Additional error handling
				$respCode	 = curl_getinfo( $req, CURLINFO_HTTP_CODE );
				$resp		 = json_decode( curl_exec( $req ), true );
				curl_close( $req );

				if ( isset( $resp[ 'access_token' ] ) && !empty( $resp[ 'access_token' ] ) ) {

					$new_settings[ 'gateways' ][ $this->plugin_name ][ 'private_key' ]		 = $resp[ 'access_token' ];
					$new_settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ]	 = $resp[ 'stripe_publishable_key' ];
					$new_settings[ 'gateways' ][ $this->plugin_name ][ 'stripe_user_id' ]	 = $resp[ 'stripe_user_id' ];
					$new_settings[ 'gateways' ][ 'active' ][]								 = $this->plugin_name;

					$settings = array_merge( $settings, $new_settings );
					update_option( 'tc_settings', $settings );

					if ( isset( $_GET[ 'state' ] ) ) {
						wp_redirect( $_GET[ 'state' ] . '#stripe-connect' );
						tc_js_redirect( $_GET[ 'state' ] . '#stripe-connect' );
						exit;
					}
				}
			} else if ( isset( $_GET[ 'error' ] ) ) { // Error
				echo $_GET[ 'error_description' ];
			}
		}

		function init_vars() {
			//setup proper directories
			if ( defined( 'WP_PLUGIN_URL' ) && defined( 'WP_PLUGIN_DIR' ) && file_exists( WP_PLUGIN_DIR . '/' . $this->dir_name . '/' . basename( __FILE__ ) ) ) {
				$this->location		 = 'subfolder-plugins';
				$this->plugin_dir	 = WP_PLUGIN_DIR . '/' . $this->dir_name . '/';
				$this->plugin_url	 = plugins_url( '/', __FILE__ );
			} else if ( defined( 'WP_PLUGIN_URL' ) && defined( 'WP_PLUGIN_DIR' ) && file_exists( WP_PLUGIN_DIR . '/' . basename( __FILE__ ) ) ) {
				$this->location		 = 'plugins';
				$this->plugin_dir	 = WP_PLUGIN_DIR . '/';
				$this->plugin_url	 = plugins_url( '/', __FILE__ );
			} else if ( is_multisite() && defined( 'WPMU_PLUGIN_URL' ) && defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/' . basename( __FILE__ ) ) ) {
				$this->location		 = 'mu-plugins';
				$this->plugin_dir	 = WPMU_PLUGIN_DIR;
				$this->plugin_url	 = WPMU_PLUGIN_URL;
			} else {
				wp_die( sprintf( __( 'There was an issue determining where %s is installed. Please reinstall it.', 'tc' ), $this->title ) );
			}
		}

		function enqueue_scripts() {
			global $tc, $wp;


			if ( $this->is_active() && $this->is_payment_page() ) {
				wp_enqueue_script( 'js-stripe-cn', 'https://js.stripe.com/v1/', array( 'jquery' ) );
				wp_enqueue_script( 'stripe-connect-token', $this->plugin_url . 'js/stripe-connect-token.js', array( 'js-stripe-cn', 'jquery' ) );
				wp_localize_script( 'stripe-connect-token', 'stripe', array( 'publisher_key'	 => $this->publishable_key,
					'name'			 => __( 'Please enter the full Cardholder Name.', 'tc' ),
					'number'		 => __( 'Please enter a valid Credit Card Number.', 'tc' ),
					'expiration'	 => __( 'Please choose a valid expiration date.', 'tc' ),
					'cvv2'			 => __( 'Please enter a valid card security code. This is the 3 digits on the signature panel, or 4 digits on the front of Amex cards.', 'tc' )
				) );
			}
		}

		function payment_form( $cart ) {
			global $tc;

			$content = '';

			$content .= '<div id="stripe_checkout_errors"></div>';

			$content .= '<table class="tc_cart_billing">
        <thead><tr>
          <th colspan="2">' . __( 'Enter Your Credit Card Information:', 'tc' ) . '</th>
        </tr></thead>
        <tbody>
          <tr>
          <td align="right">' . __( 'Cardholder Name:', 'tc' ) . '</td><td>
					<input id="cc_name" type="text" value="' . esc_attr( $this->buyer_info( 'full_name' ) ) . '" /> </td>
          </tr>';
			$content .= '<tr>';
			$content .= '<td align="right">';
			$content .= __( 'Card Number', 'tc' );
			$content .= '</td>';
			$content .= '<td>';
			$content .= '<input type="text" autocomplete="off" id="cc_number"/>';
			$content .= '</td>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td align="right">';
			$content .= __( 'Expiration:', 'tc' );
			$content .= '</td>';
			$content .= '<td>';
			$content .= '<select id="cc_month">';
			$content .= tc_months_dropdown();
			$content .= '</select>';
			$content .= '<span> / </span>';
			$content .= '<select id="cc_year">';
			$content .= tc_years_dropdown( '', true );
			$content .= '</select>';
			$content .= '</td>';
			$content .= '</tr>';
			$content .= '<tr>';
			$content .= '<td align="right">';
			$content .= __( 'CVC:', 'tc' );
			$content .= '</td>';
			$content .= '<td>';
			$content .= '<input type="text" size="4" autocomplete="off" id="cc_cvv2" />';
			$content .= '</td>';
			$content .= '</tr>';
			$content .= '</table>';
			$content .= '<span id="stripe_processing" style="display:none; float:right;"><img src="' . $tc->plugin_url . 'images/loading.gif" /> ' . __( 'Processing...', 'tc' ) . '</span>';
			return $content;
		}

		function order_confirmation_message( $order, $cart_info = '' ) {
			global $tc;

			$cart_info	 = isset( $_SESSION[ 'cart_info' ] ) ? $_SESSION[ 'cart_info' ] : $cart_info;
			$order		 = tc_get_order_id_by_name( $order );
			$order		 = new TC_Order( $order->ID );

			$content = '';

			if ( $order->details->post_status == 'order_received' ) {
				$content .= '<p>' . sprintf( __( 'Your payment via Stripe for this order totaling <strong>%s</strong> is not yet complete.', 'tc' ), $tc->get_cart_currency_and_format( $order->details->tc_payment_info[ 'total' ] ) ) . '</p>';
				$content .= '<p>' . __( 'Current order status:', 'tc' ) . ' <strong>' . __( 'Pending Payment' ) . '</strong></p>';
			} else if ( $order->details->post_status == 'order_fraud' ) {
				$content .= '<p>' . __( 'Your payment is under review. We will back to you soon.', 'tc' ) . '</p>';
			} else if ( $order->details->post_status == 'order_paid' ) {
				$content .= '<p>' . sprintf( __( 'Your payment via Stripe for this order totaling <strong>%s</strong> is complete.', 'tc' ), $tc->get_cart_currency_and_format( $order->details->tc_payment_info[ 'total' ] ) ) . '</p>';
			}

			$content = apply_filters( 'tc_order_confirmation_message_content_' . $this->plugin_name, $content );

			$content = apply_filters( 'tc_order_confirmation_message_content', $content, $order );

			$tc->remove_order_session_data();
			unset( $_SESSION[ 'stripeToken' ] );
			$tc->maybe_skip_confirmation_screen( $this, $order );
			return $content;
		}

		function gateway_network_admin_settings( $settings, $visible ) {
			global $tc;
			?>
			<div id="<?php echo $this->plugin_name; ?>" class="postbox" <?php echo (!$visible ? 'style="display:none;"' : ''); ?>>
				<h3 class='hndle'><span><?php _e( 'Stripe Connect', 'tc' ) ?></span></h3>
				<div class="inside">
					<p class="description"><?php _e( "Stripe Connect allows you to charge transaction fees / commision for each subsite in your network. Register your Stripe platform ", 'tc' ); ?> <a href="https://dashboard.stripe.com/account/applications/settings" target="_blank"><?php _e( 'Here &raquo;', 'tc' ) ?></a> <?php _e( 'and get application <strong>client id</strong>.', 'tc' ) ?></p>
					<table class="form-table">
						<tr>
							<th scope="row"><?php _e( 'Stripe Credentials', 'tc' ) ?><a id="<?php echo $this->plugin_name; ?>" name=""></a></th>
							<td>
								<span class="description"><?php _e( 'You must login to Stripe to <a target="_blank" href="https://manage.stripe.com/#account/apikeys">obtain your API <strong>secret key</strong></a>. You can enter your test credentials, then live ones when ready.', 'tc' ) ?></span>
								<p><label><?php _e( 'Secret key', 'tc' ) ?><br />
										<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'private_key' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'private_key' ] : ''  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name; ?>][private_key]" type="text" />
									</label></p>
								<p><label><?php _e( 'Application client id', 'tc' ) ?><br />
										<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'client_id' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'client_id' ] : ''  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name; ?>][client_id]" type="text" />
									</label></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php _e( 'Commision', 'tc' ) ?></th>
							<td>
								<span class="description"><?php _e( 'Set desired commition rate. You can set percentage or fixed amount or event both at once.', 'tc' ) ?></span>
								<p>
									<label><?php _e( 'Commision Rate (%)', 'tc' ) ?><br />
										<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] : '1'  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name; ?>][commision_rate]" type="text" />
									</label>
								</p>
								<p>
									<label><?php _e( 'Commision Rate (fixed)', 'tc' ) ?><br />
										<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] : '0'  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name; ?>][commision_rate_fixed]" type="text" />
									</label>
								</p>
							</td>
						</tr>

					</table>    
				</div>
			</div>      
			<?php
		}

		function gateway_admin_settings( $settings, $visible ) {
			global $tc;

			$network_settings	 = get_site_option( 'tc_network_settings', array() );
			$percent			 = isset( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] ) && is_numeric( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] ) ? $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] : 0;
			$fixed				 = isset( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] ) && is_numeric( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] ) ? $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] : 0;

			if ( $percent > 100 ) {
				$percent = 100;
			}
			?>
			<div id="<?php echo $this->plugin_name; ?>" class="postbox" <?php echo (!$visible ? 'style="display:none;"' : ''); ?>>
				<h3 class='hndle'><span><?php _e( 'Stripe', 'tc' ) ?></span></h3>
				<div class="inside">
					<p class="description"><?php _e( "Accept Visa, MasterCard, American Express, Discover, JCB, and Diners Club cards directly on your site.", 'tc' ); ?>
						<?php
						if ( $percent > 0 && $fixed == 0 ) {
							printf( __( 'Please note that you will be charged %s per each successful order / sale (on top of Stripe’s processing fees).', 'tc' ), '<strong>' . round( $percent, 2 ) . '%</strong>' );
						}
						if ( $percent == 0 && $fixed > 0 ) {
							printf( __( 'Please note that you will be charged %s (fixed fee) per each successful order / sale (on top of Stripe’s processing fees).', 'tc' ), '<strong>' . round( $fixed, 2 ) . '</strong>' );
						}
						if ( $percent > 0 && $fixed > 0 ) {
							printf( __( 'Please note that you will be charged %s and the fixed fee of %s per each successful order / sale (on top of Stripe’s processing fees).', 'tc' ), '<strong>' . round( $percent, 2 ) . '%</strong>', '<strong>' . round( $fixed, 2 ) . '</strong>' );
						}
						?>
					</p>
					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e( 'Stripe Mode', 'tc' ) ?></th>
							<td>
								<span class="description"><?php _e( 'When in live mode Stripe recommends you have an SSL certificate setup for the site where the checkout form will be displayed.', 'tc' ); ?> <a href="https://stripe.com/help/ssl" target="_blank"><?php _e( 'More Info &raquo;', 'tc' ) ?></a></span><br/>
								<select name="tc[gateways][<?php echo $this->plugin_name; ?>][is_ssl]">
									<option value="1"<?php selected( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'is_ssl' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'is_ssl' ] : 0, 1 ); ?>><?php _e( 'Force SSL (Live Site)', 'tc' ) ?></option>
									<option value="0"<?php selected( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'is_ssl' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'is_ssl' ] : 0, 0 ); ?>><?php _e( 'No SSL (Testing)', 'tc' ) ?></option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php _e( 'Stripe API Credentials', 'tc' ) ?></th>
							<td>
								<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ] : ''  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name ?>][publishable_key]" type="hidden" />
								<input value="<?php echo esc_attr( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'private_key' ] : ''  ); ?>" size="70" name="tc[gateways][<?php echo $this->plugin_name ?>][private_key]" type="hidden" />
								<?php
								$authorize_request_body = array(
									'response_type'	 => 'code',
									'scope'			 => 'read_write',
									'client_id'		 => $this->client_id,
									'state'			 => is_multisite() ? get_admin_url( null, 'admin.php?page=tc_settings&tab=gateways' ) : admin_url( 'admin.php?page=tc_settings&tab=gateways' )
								);

								$url = $this->authorize_url . '?' . http_build_query( $authorize_request_body );

								if ( isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ] ) && !empty( $settings[ 'gateways' ][ $this->plugin_name ][ 'publishable_key' ] ) ) {
									?>
									<p><?php
										_e( 'Connected', 'tc' );
										echo "<p><a href='$url'>" . __( 'Reconnect with Stripe', 'tc' ) . "</a></p>";
										?>
									</p>
									<?php
								} else {

									echo "<a href='$url'>" . __( 'Connect with Stripe', 'tc' ) . "</a>";
								}
								?>
								</label></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e( 'Currency', 'tc' ) ?></th>
							<td>
								<span class="description"><?php _e( 'Selecting a currency other than that used for your store may cause problems at checkout.', 'tc' ); ?></span><br />
								<select name="tc[gateways][<?php echo $this->plugin_name; ?>][currency]">
									<?php
									$sel_currency = isset( $settings[ 'gateways' ][ $this->plugin_name ][ 'currency' ] ) ? $settings[ 'gateways' ][ $this->plugin_name ][ 'currency' ] : $settings[ 'currency' ];

									$currencies = $this->currencies;

									foreach ( $currencies as $k => $v ) {
										echo '<option value="' . $k . '"' . ($k == $sel_currency ? ' selected' : '') . '>' . esc_html( $v, true ) . '</option>' . "\n";
									}
									?>
								</select>
							</td>
						</tr>
					</table>    
				</div>
			</div>      
			<?php
		}

		function process_payment( $cart ) {
			global $tc;

			$this->maybe_start_session();
			$this->save_cart_info();

			$network_settings	 = get_site_option( 'tc_network_settings', array() );
			$percent			 = isset( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] ) && is_numeric( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] ) ? $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate' ] : 0;
			$fixed				 = isset( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] ) && is_numeric( $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] ) ? $network_settings[ 'gateways' ][ $this->plugin_name ][ 'commision_rate_fixed' ] : 0;

			if ( $percent > 100 ) {
				$percent = 100;
			}

			$_SESSION[ 'stripeToken' ] = $_POST[ 'stripeToken' ];

			if ( !isset( $_SESSION[ 'stripeToken' ] ) ) {
				$tc->cart_checkout_error( __( 'The Stripe Token was not generated correctly. Please go back and try again.', 'tc' ) );
				return false;
			}

			if ( !class_exists( 'Stripe' ) ) {
				require_once($tc->plugin_dir . "/includes/gateways/stripe/lib/Stripe.php");
			}

			Stripe::setApiKey( $this->private_key );

			$order_id = $tc->generate_order_id();

			try {
				$charge = Stripe_Charge::create( array(
					"amount"			 => $this->total() * 100, //cents
					"currency"			 => strtolower( $this->currency ),
					"source"			 => $_SESSION[ 'stripeToken' ],
					"description"		 => sprintf( __( '%s Store Purchase - Order ID - %s, Email - %s', 'tc' ), get_bloginfo( 'name' ), $order_id, $this->buyer_info( 'email' ) ),
					"application_fee"	 => round( (($this->total() * $percent / 100) + $fixed) * 100 )
				)
				);

				if ( $charge->paid == 'true' ) {

					$payment_info						 = array();
					$payment_info[ 'method' ]			 = sprintf( __( '%1$s Card ending in %2$s - Expires %3$s', 'tc' ), $charge->card->type, $charge->card->last4, $charge->card->exp_month . '/' . $charge->card->exp_year );
					$payment_info[ 'transaction_id' ]	 = $charge->id;
					$payment_info						 = $this->save_payment_info( $payment_info );

					$paid	 = true;
					$order	 = $tc->create_order( $order_id, $this->cart_contents(), $this->cart_info(), $payment_info, $paid );

					wp_redirect( $tc->get_confirmation_slug( true, $order_id ) );
					tc_js_redirect( $tc->get_confirmation_slug( true, $order_id ) );
					exit;
				}
			} catch ( Exception $e ) {
				unset( $_SESSION[ 'stripeToken' ] );
				$_SESSION[ 'tc_gateway_error' ] = sprintf( __( 'There was an error processing your card - "%s".', 'tc' ), $e->getMessage() );
				wp_redirect( $tc->get_payment_slug( true ) );
				tc_js_redirect( $tc->get_payment_slug( true ) );
				exit;
			}
			return false;
		}

		function ipn() {
			global $tc;
		}

	}

	tc_register_gateway_plugin( 'TC_Gateway_Stripe_Connect', 'stripe-connect', __( 'Stripe', 'tc' ) );
}
?>
