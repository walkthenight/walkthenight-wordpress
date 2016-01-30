<?php
/**
 * Single Product title
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="cb-module-header cb-category-header">
                   <h1 class="cb-module-title">
                        <?php  if ( is_shop() ) {
                            woocommerce_page_title();
                        } elseif ( ( is_product_category() ) || ( is_product_tag() ) ) {

                            global $wp_query;
                            $cb_current_object = $wp_query->get_queried_object();
                            echo $cb_current_object->name;

                        } else {
                            the_title();
                        } ?>
                    </h1>
                </div>