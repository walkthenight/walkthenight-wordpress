<?php
/*
  Plugin Name: Mollie for Tickera
  Plugin URI: http://tickera.com/
  Description: Accept iDeal, Credit Card, Bancontact / Mister Cash, SOFORT Banking, Overbooking, Bitcoin, PayPal, paysafecard and AcceptEmail payment via Mollie.
  Author: Tickera.com
  Author URI: http://tickera.com/
  Version: 1.2.0.1
  TextDomain: tc-mollie
  Domain Path: /languages/
  Copyright 2015 Tickera (http://tickera.com/)
 */

if ( !defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

add_action( 'tc_load_gateway_plugins', 'register_mollie_gateway' );

function register_mollie_gateway() {

	class TC_Gateway_Mollie extends TC_Gateway_API {

		var $plugin_name				 = 'mollie';
		var $admin_name				 = 'Mollie';
		var $public_name				 = '';
		var $method_img_url			 = '';
		var $method_button_img_url	 = '';
		var $ipn_url;
		var $currencies				 = array();
		var $skip_payment_screen		 = true;
		var $dir_name				 = 'mollie-payment-gateway';
		var $location				 = 'plugins';
		var $plugin_dir				 = '';
		var $plugin_url				 = '';

		//Support for older payment gateway API
		function on_creation() {
			$this->init();
		}

		function init() {
			global $tc;

			$this->init_vars();
			//localize the plugin
			add_action( 'init', array( &$this, 'localization' ), 10 );

			$this->admin_name	 = __( 'Mollie', 'tc-mollie' );
			$this->public_name	 = __( 'Mollie', 'tc-mollie' );

			$this->method_img_url	 = apply_filters( 'tc_gateway_method_img_url', plugin_dir_url( __FILE__ ) . 'assets/images/mollie.png', $this->plugin_name );
			$this->admin_img_url	 = apply_filters( 'tc_gateway_admin_img_url', plugin_dir_url( __FILE__ ) . 'assets/images/small-mollie.png', $this->plugin_name );

			$this->api_key		 = $this->get_option( 'api_key' );
			$this->public_name	 = $this->get_option( 'public_name', $this->public_name );

			$this->currency = 'EUR';
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
				wp_die( sprintf( __( 'There was an issue determining where %s is installed. Please reinstall it.', 'tc-mollie' ), $this->title ) );
			}
		}

		//Plugin localization function
		function localization() {

// Load up the localization file if we're using WordPress in a different language
// Place it in this plugin's "languages" folder and name it "tc-[value in wp-config].mo"
			if ( $this->location == 'mu-plugins' ) {
				load_muplugin_textdomain( 'tc-mollie', 'languages/' );
			} else if ( $this->location == 'subfolder-plugins' ) {
				//load_plugin_textdomain( 'tc-mollie', false, $this->plugin_dir . '/languages/' );
				load_plugin_textdomain( 'tc-mollie', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
			} else if ( $this->location == 'plugins' ) {
				load_plugin_textdomain( 'tc-mollie', false, 'languages/' );
			} else {
				
			}

			$temp_locales	 = explode( '_', get_locale() );
			$this->language	 = ($temp_locales[ 0 ]) ? $temp_locales[ 0 ] : 'en';
		}

		function init_mollie() {

			require_once 'Mollie/API/Autoloader.php';

			$this->mollie = new Mollie_API_Client;
			$this->mollie->setApiKey( $this->api_key );
		}

		function process_payment( $cart ) {
			global $tc;

			$this->maybe_start_session();
			$this->save_cart_info();

			$this->init_mollie();

			$order_id = $tc->generate_order_id();

			try {

				$payment = $this->mollie->payments->create( array(
					"amount"		 => $this->total(),
					"description"	 => __( 'Order: #', 'tc-mollie' ) . $order_id,
					"redirectUrl"	 => $tc->get_confirmation_slug( true, $order_id ),
					"metadata"		 => array(
						"order_id" => $order_id,
					),
				) );

				$payment_info						 = array();
				$payment_info[ 'transaction_id' ]	 = $payment->id;
				$payment_info						 = $this->save_payment_info( $payment_info );

				$tc->create_order( $order_id, $this->cart_contents(), $this->cart_info(), $payment_info, false );

				wp_redirect( $payment->getPaymentUrl() );
				tc_js_redirect( $payment->getPaymentUrl() );
				exit;
			} catch ( Mollie_API_Exception $e ) {
				$_SESSION[ 'tc_gateway_error' ] = __( 'API call failed: ', 'tc-mollie' ) . htmlspecialchars( $e->getMessage() );
				wp_redirect( $tc->get_payment_slug( true ) );
				tc_js_redirect( $tc->get_payment_slug( true ) );
				exit;
			}
		}

		function order_confirmation( $order, $payment_info = '', $cart_info = '' ) {
			global $tc;

			$received_order = $order;

			$order			 = tc_get_order_id_by_name( $order );
			$order_object	 = new TC_Order( $order->ID );

			$transaction_id = $order_object->details->tc_payment_info[ 'transaction_id' ];

			if ( isset( $transaction_id ) ) {

				$this->init_mollie();

				$payment	 = $this->mollie->payments->get( $transaction_id );
				$order_id	 = $payment->metadata->order_id;

				if ( $payment->isPaid() == TRUE ) {
					$paid = true;
					$tc->update_order_payment_status( $order->ID, $paid );
				} elseif ( $payment->isOpen() == FALSE ) {
					//do nothing, it's not paid yet
				}
			}
		}

		function gateway_admin_settings( $settings, $visible ) {
			global $tc;
			?>
			<div id="<?php echo $this->plugin_name; ?>" class="postbox" <?php echo (!$visible ? 'style="display:none;"' : ''); ?>>
				<h3 class='handle'><span><?php printf( __( '%s Settings', 'tc-mollie' ), $this->admin_name ); ?></span></h3>
				<div class="inside">
					<span class="description">
						<?php _e( 'Mollie provides a fully PCI Compliant and secure way to collect payments via iDeal, Credit Card, Bancontact / Mister Cash, SOFORT Banking, Overbooking, Bitcoin, PayPal, paysafecard and AcceptEmail.', 'tc-mollie' ) ?>
					</span>

					<?php
					$fields	 = array(
						'api_key'		 => array(
							'title'	 => __( 'Mollie API Key', 'tc-mollie' ),
							'type'	 => 'text',
						),
						'public_name'	 => array(
							'title'	 => __( 'Payment Method Name (shown on front)', 'tc-mollie' ),
							'type'	 => 'text',
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

		function process_gateway_settings( $settings ) {
			return $settings;
		}

		function ipn() {
			global $tc;
			$settings = get_option( 'tc_settings' );
		}

	}

	tc_register_gateway_plugin( 'TC_Gateway_Mollie', 'mollie', __( 'Mollie', 'tc-mollie' ) );
}
