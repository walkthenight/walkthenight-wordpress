<?php
/*
  Plugin Name: Mijireh Checkout for Tickera
  Plugin URI: http://tickera.com/
  Description: Accept payments with Mijireh Checkout. Pick from over 90 payment gateways to use on Mijireh secure PCI compliant servers.
  Author: Tickera.com
  Author URI: http://tickera.com/
  Version: 1.5.0.3
  TextDomain: tc-mijireh
  Domain Path: /languages/
  Copyright 2015 Tickera (http://tickera.com/)
 */

if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

add_action( 'tc_load_gateway_plugins', 'register_mijireh_gateway' );

function register_mijireh_gateway() {

	class TC_Gateway_Mijireh extends TC_Gateway_API {

		var $plugin_name			 = 'mijireh';
		var $admin_name			 = 'Mijireh';
		var $public_name			 = '';
		var $method_img_url		 = '';
		var $admin_img_url		 = '';
		var $currencies			 = array();
		var $skip_payment_screen	 = true;
		var $dir_name			 = 'mijireh-checkout';
		var $location			 = 'plugins';
		var $plugin_dir			 = '';
		var $plugin_url			 = '';

		//Support for older payment gateway API
		function on_creation() {
			$this->init_vars();
			$this->init();
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
				wp_die( sprintf( __( 'There was an issue determining where %s is installed. Please reinstall it.', 'tc-mijireh' ), $this->title ) );
			}
		}

		function init() {
			global $tc;

			//localize the plugin
			add_action( 'init', array( &$this, 'localization' ), 10 );

			$settings = get_option( 'tc_settings' );

			$this->admin_name	 = __( 'Mijireh Checkout', 'tc' );
			$this->public_name	 = __( 'Credit Card', 'tc' );

			$this->method_img_url	 = apply_filters( 'tc_gateway_method_img_url', plugin_dir_url( __FILE__ ) . 'assets/images/small-mijireh.png', $this->plugin_name );
			$this->admin_img_url	 = apply_filters( 'tc_gateway_admin_img_url', plugin_dir_url( __FILE__ ) . 'assets/images/mijireh.png', $this->admin_name );

			$this->access_key = $this->get_option( 'access_key' );

			$currencies = array(
				'EUR'	 => __( 'EUR - Euro', 'tc' ),
				'AUD'	 => __( 'AUD - Australian Dollar', 'tc' ),
				'BRL'	 => __( 'BRL - Brazilian Real', 'tc' ),
				'BGN'	 => __( 'BGN - Bulgarian Lev', 'tc' ),
				'CAD'	 => __( 'CAD - Canadian Dollar', 'tc' ),
				'CNY'	 => __( 'CNY - Chinese Yuan', 'tc' ),
				'CZK'	 => __( 'CZK - Czech Koruna', 'tc' ),
				'DKK'	 => __( 'DKK - Danish Krone', 'tc' ),
				'CHF'	 => __( 'CHF - Swiss Franc', 'tc' ),
				'GBP'	 => __( 'GBP - Pound Sterling', 'tc' ),
				'ILS'	 => __( 'ILS - Israeli Shekel', 'tc' ),
				'ISK'	 => __( 'ISK - Icelandic Króna', 'tc' ),
				'INR'	 => __( 'INR - Indian Rupee', 'tc' ),
				'KPW'	 => __( 'KPW - North Korean Won', 'tc' ),
				'KRW'	 => __( 'KRW - South Korean Won', 'tc' ),
				'LVL'	 => __( 'LVL - Latvian Lats', 'tc' ),
				'LTL'	 => __( 'LTL - Lithuanian Litas', 'tc' ),
				'RON'	 => __( 'RON - Romanian Leu', 'tc' ),
				'ZAR'	 => __( 'ZAR - South African Rand', 'tc' ),
				'HKD'	 => __( 'HKD - Hong Kong Dollar', 'tc' ),
				'HUF'	 => __( 'HUF - Hungarian Forint', 'tc' ),
				'JPY'	 => __( 'JPY - Japanese Yen', 'tc' ),
				'MYR'	 => __( 'MYR - Malaysian Ringgits', 'tc' ),
				'MXN'	 => __( 'MXN - Mexican Peso', 'tc' ),
				'NOK'	 => __( 'NOK - Norwegian Krone', 'tc' ),
				'NZD'	 => __( 'NZD - New Zealand Dollar', 'tc' ),
				'PHP'	 => __( 'PHP - Philippine Pesos', 'tc' ),
				'PLN'	 => __( 'PLN - Polish Zloty', 'tc' ),
				'SEK'	 => __( 'SEK - Swedish Krona', 'tc' ),
				'SGD'	 => __( 'SGD - Singapore Dollar', 'tc' ),
				'TWD'	 => __( 'TWD - Taiwan New Dollars', 'tc' ),
				'THB'	 => __( 'THB - Thai Baht', 'tc' ),
				'TRY'	 => __( 'TRY - Turkish lira', 'tc' ),
				'USD'	 => __( 'USD - U.S. Dollar', 'tc' )
			);

			$this->currencies = $currencies;
		}

		//Plugin localization function
		function localization() {

// Load up the localization file if we're using WordPress in a different language
// Place it in this plugin's "languages" folder and name it "tc-[value in wp-config].mo"
			if ( $this->location == 'mu-plugins' ) {
				load_muplugin_textdomain( 'tc-mijireh', 'languages/' );
			} else if ( $this->location == 'subfolder-plugins' ) {
				//load_plugin_textdomain( 'tc-mijireh', false, $this->plugin_dir . '/languages/' );
				load_plugin_textdomain( 'tc-mijireh', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			} else if ( $this->location == 'plugins' ) {
				load_plugin_textdomain( 'tc-mijireh', false, 'languages/' );
			} else {
				
			}

			$temp_locales	 = explode( '_', get_locale() );
			$this->language	 = ($temp_locales[ 0 ]) ? $temp_locales[ 0 ] : 'en';
		}

		public function init_mijireh() {
			if ( !class_exists( 'Mijireh' ) ) {

				require_once 'mijireh/Mijireh.php';

				$settings = get_option( 'tc_settings' );

				Mijireh::$access_key = $this->get_option( 'access_key' );
			}
		}

		function payment_form( $cart ) {
			global $tc;
			if ( isset( $_GET[ 'cancel' ] ) ) {
				$_SESSION[ 'tc_gateway_error' ] = __( 'Your Mijireh transaction has been canceled.', 'tc' );
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

			$this->init_mijireh();

			$mj_order = new Mijireh_Order();

			$counter = 1;

			$mj_order->add_item( $this->cart_items(), $this->total(), 1, $order_id );

			$mj_order->total = $this->total();
			$mj_order->tax	 = 0.00;

			set_transient( 'tc_order_' . $order_id . '_cart', $cart, 60 * 60 * 12 );
			set_transient( 'tc_order_' . $order_id . '_userid', get_current_user_ID(), 60 * 60 * 12 );

			$billing			 = new Mijireh_Address();
			$billing->first_name = $this->buyer_info( 'first_name' );
			$billing->last_name	 = $this->buyer_info( 'last_name' );

			$mj_order->first_name	 = $this->buyer_info( 'first_name' );
			$mj_order->last_name	 = $this->buyer_info( 'last_name' );
			$mj_order->email		 = $this->buyer_info( 'email' );

			$mj_order->add_meta_data( 'tc_order_id', $order_id );

			$mj_order->return_url = $tc->get_confirmation_slug( true, $order_id ); //$this->ipn_url;

			$mj_order->partner_id = apply_filters( 'tc_mijireh_partner_id', 'tickera' );

			$payment_info = $this->save_payment_info();

			try {
				$mj_order->create();
				$tc->create_order( $order_id, $this->cart_contents(), $this->cart_info(), $payment_info, false );
				wp_redirect( $mj_order->checkout_url );
				tc_js_redirect( $mj_order->checkout_url );
				exit();
			} catch ( Mijireh_Exception $e ) {
				$_SESSION[ 'tc_gateway_error' ] = __( 'Mijireh Error : ', 'tc' ) . $e->getMessage();
				wp_redirect( $tc->get_payment_slug( true ) );
				tc_js_redirect( $tc->get_payment_slug( true ) );
				exit;
			}
		}

		function order_confirmation( $order, $payment_info = '', $cart_info = '' ) {
			global $tc;
			$order = tc_get_order_id_by_name( $order );

			if ( isset( $_GET[ 'order_number' ] ) ) {

				$this->init_mijireh();

				try {
					$mj_order = new Mijireh_Order( esc_attr( $_GET[ 'order_number' ] ) );

					$payment_status = $mj_order->status;
					if ( $payment_status == 'paid' ) {
						$paid = true;
						$tc->update_order_payment_status( $order->ID, $paid );
					} else {
						//do nothing, waiting for paid status
					}
				} catch ( Mijireh_Exception $e ) {
					$_SESSION[ 'tc_gateway_error' ] = __( 'Mijireh Error : ', 'tc' ) . $e->getMessage();
					wp_redirect( $tc->get_payment_slug( true ) );
					tc_js_redirect( $tc->get_payment_slug( true ) );
					exit;
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
						<?php _e( 'Mijireh Checkout provides a fully PCI Compliant, secure way to collect and transmit credit card data to your payment gateway while keeping you in control of the design of your site.', 'tc' ); ?>
					</span>

					<?php
					$fields	 = array(
						'access_key' => array(
							'title'	 => __( 'Mijireh Access Key', 'tc' ),
							'type'	 => 'text',
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

	}

	tc_register_gateway_plugin( 'TC_Gateway_Mijireh', 'mijireh', __( 'Mijireh', 'tc' ) );
}

//Addon updater 

global $tc;
$tc_general_settings = get_option( 'tc_general_setting', false );

$addon_slug = 'mijireh-checkout';

if ( !defined( 'TC_NU' ) ) {//updates are allowed
	$license_key = (defined( 'TC_LCK' ) && TC_LCK !== '') ? TC_LCK : (isset( $tc_general_settings[ 'license_key' ] ) && $tc_general_settings[ 'license_key' ] !== '' ? $tc_general_settings[ 'license_key' ] : '');

	if ( $license_key !== '' ) {
		$updater_file = $tc->plugin_dir . 'includes/plugin-update-checker/plugin-update-checker.php';
		if ( file_exists( $updater_file ) ) {
			require_once($updater_file);
			$tc_plugin_update_checker = PucFactory::buildUpdateChecker( 'https://tickera.com/update/?action=get_metadata&slug=' . $addon_slug, __FILE__, $addon_slug, 1 );
		}
	}
}
?>