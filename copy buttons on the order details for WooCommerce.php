<?php
/**
 * Plugin Name: Copy buttons on the order details for WooCommerce
 * Plugin URI: https://github.com/
 * Description: A WordPress Woocommerce plugin that adds a button to copy name, address, email, and phone number on the order details screen.
 * Version: 1.0
 * Author:
 * Author URI:
 * License: GPL3
 */


/**
 * Include the require files
 *
 * @since 1.0
 */
require_once 'includes/cbod-config.php';

if (!class_exists('copy_buttons_order_details')) {

    class Copy_buttons_Order_Details
    {
        /**
         * Default Constructor
         *
         * @since 1.0
         */
        public function __construct()
        {
            add_action('init', [&$this, 'cbod_update_po_file']);
            add_action('admin_enqueue_scripts', [$this, 'copy_button_script']);
            add_action('woocommerce_admin_order_data_after_billing_address', [$this, 'copy_display_order_data_in_billing']);
            add_action('woocommerce_admin_order_data_after_shipping_address', [$this, 'copy_display_order_data_in_shipping']);
            add_action('woocommerce_admin_order_data_after_shipping_address', [$this, 'copy_display_order_data_in_shipping_all_data']);
        }


        public function cbod_update_po_file()
        {
            $domain = 'copy-buttons-order-details';
            $locale = apply_filters('plugin_locale', get_locale(), $domain);
            $loaded = load_textdomain($domain, trailingslashit(WP_LANG_DIR) . $domain . '-' . $locale . '.mo');
            if ($loaded) {
                return $loaded;
            } else {
                load_plugin_textdomain($domain, false, basename(dirname(__FILE__)) . '/languages/');
            }
        }


        public function copy_button_script()
        {
            wp_register_script('copy-cbod', plugins_url('/js/copy-cbod.js', __FILE__), '', $wpefield_version, true);
            wp_enqueue_script('copy-cbod');
        }

        public function copy_display_order_data_in_billing($order)
        {

            global $copy_name ,$copy_address, $copy_email, $copy_phone_number, $copy_all;

            $order_data = $order->get_data();
            $name = trim($order_data['billing']['first_name'] . $order_data['billing']['last_name']);
            $address_1 = str_replace('"', '', $order_data['billing']['address_1']);
            $address_2 = str_replace('"', '', $order_data['billing']['address_2']);
            $address = trim(str_replace('"', '', $address_1 . ' ' . $address_2));
            $email = trim($order_data['billing']['email']);
            $phone = trim($order_data['billing']['phone']);

            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="name" data-clipboardtext="' . $name . '">' . $copy_name . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="phone" data-clipboardtext="' . $phone . '">' . $copy_phone_number . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="addr" data-clipboardtext="' . $address . '">' . $copy_address . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy billing-all" data-attr="all" data-clipboardtext="' . $name."\t".$phone."\t".$address . '">' . $copy_all . '</button>';
        }
        public function copy_display_order_data_in_shipping($order)
        {

            global $copy_name ,$copy_address, $copy_email, $copy_phone_number, $copy_all;

            $order_data = $order->get_data();
            $name = trim($order_data['shipping']['first_name'] . $order_data['shipping']['last_name']);
            $address_1 = str_replace('"', '', $order_data['shipping']['address_1']);
            $address_2 = str_replace('"', '', $order_data['shipping']['address_2']);
            $address = trim(str_replace('"', '', $address_1 . ' ' . $address_2));
            $email = trim($order_data['shipping']['email']);
            $phone = trim($order_data['shipping']['phone']);

            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="name" data-clipboardtext="' . $name . '">' . $copy_name . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="phone" data-clipboardtext="' . $phone . '">' . $copy_phone_number . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy" data-attr="addr" data-clipboardtext="' . $address . '">' . $copy_address . '</button>';
            echo '<button type="button" class="button button-primary mr-2 data-copy shipping-all" data-attr="mail" data-clipboardtext="' .  $name."\t".$phone."\t".$address . '">' . $copy_all . '</button>';
        }




        public function copy_display_order_data_in_shipping_all_data($order)
        {
            global $copy_all2;
            echo '<button type="button" class="button button-secondary mr-2 mt-4 data-copy-all" >' . $copy_all2 . '</button>';
        }



    }
}

function copy_buttons_order_details_init()
{
    $copy_buttons_order_details = new Copy_buttons_Order_Details();
}

add_action('plugins_loaded', 'copy_buttons_order_details_init');


?>
