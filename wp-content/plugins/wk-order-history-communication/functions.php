<?php
/**
 * Plugin Name:  WooCommerce Order History Communication
 * Plugin URI:   https://webkul.com/
 * Description:  Using this module Admin and Customer can communicate on order edit page with the attachment.
 * Version:      1.0.0
 * Author:       webkul
 * Author URI:   https://webkul.com/
 * Text Domain:  wk-ohc
 * Domain Path:  /languages
 * License:      GNU/GPL for more info see license.txt included with plugin
 * License URI:  https://store.webkul.com/license.html.
 * @package WK Order History Communication
*/

defined( 'ABSPATH' ) || exit();

use WKOHC\Includes;

// Define Constants.
defined( 'WKOHC_PLUGIN_FILE' ) || define( 'WKOHC_PLUGIN_FILE', plugin_dir_path( __FILE__ ) );
defined( 'WKOHC_PLUGIN_URL' ) || define( 'WKOHC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
defined( 'WKOHC_SCRIPT_VERSION' ) || define( 'WKOHC_SCRIPT_VERSION', '1.0.0' );

if ( ! function_exists('wkohc_includes') ) {

  /**
   * Includes function
   * @return void
  */
  function wkohc_includes() {

    ob_start();
    load_plugin_textdomain( 'wk-ohc', false, basename( dirname( __FILE__ ) ) . '/languages' );

    if (! function_exists('WC') ) {
        // Add WooCommerce dependency Message
        add_action('admin_notices', function () {
          ?>
          <div class="error">
            <p><?php echo sprintf( esc_html__( 'WooCommerce Order History Communication depends on the last version of %s or later to work!', 'wk-ohc' ), '<a href="http://www.woothemes.com/woocommerce/" target="_blank">' . esc_html__( 'WooCommerce', 'wk-ohc' ) . '</a>' ) ?></p>
          </div>
          <?php }
        );
    } else {
      // Load Text domain
      require_once WKOHC_PLUGIN_FILE . 'inc/autoload.php';

      new Includes\WKOHC_File_Handler();

      add_action( 'admin_footer', function() {
          if ( 'disable' === get_option( 'wkohc_module_status', 'enable' ) ) {
            ?>
              <div class="error">
                <p><?php echo sprintf( esc_html__( 'WooCommerce Order History Communication won\'t work. Kindly enable  the use of  %s', 'wk-ohc' ), '<a href="' . esc_url( admin_url( 'admin.php?page=wkohc-settings' ) ) . '" target="_blank">' . esc_html__( 'Order History Communication', 'wk-ohc' ) . '</a>' ) ?></p>
              </div>
            <?php
          }
      });
    }
  }
  add_action('plugins_loaded', 'wkohc_includes');
}
