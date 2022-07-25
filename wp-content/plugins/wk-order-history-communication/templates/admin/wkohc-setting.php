
<?php defined( 'ABSPATH' ) || exit; ?>

<div class="wrap woocommerce">
  <h1 class="wp-heading-inline"><?php esc_html_e('Order History Communication', 'wk-ohc'); ?></h1>
  <hr>
  <h2><?php esc_html_e('General Settings', 'wk-ohc'); ?></h2>
  <?php settings_errors(); ?>
  <form method="post" action="options.php" class="general-form">
  	<table class="form-table">
  		<tbody>
  			<?php settings_fields( 'wkohc-settings-group' ); ?>
  			<tr scope="row">
  			  <th>
			      <label for="wkohc_module_status"><?php esc_html_e( 'Module Status', 'wk-ohc' ); ?><?php echo wc_help_tip( esc_html__( 'If this option Enable then module functionality will worked', 'wk-ohc' ) ) ?></label>
  			  </th>
          <td>
				    <select name="wkohc_module_status" id="wkohc_module_status">
				      <?php if(get_option('wkohc_module_status', 'enable') === 'enable') { ?>
				        <option value="enable" selected="selected"><?php esc_html_e( 'Enable', 'wk-ohc' ); ?></option>
				        <option value="disable"><?php esc_html_e( 'Disable', 'wk-ohc' ); ?></option>
				      <?php } else { ?>
				        <option value="enable"><?php esc_html_e( 'Enable', 'wk-ohc' ); ?></option>
				        <option value="disable" selected="selected"><?php esc_html_e( 'Disable', 'wk-ohc' ); ?></option>
				      <?php } ?>
				    </select>
				  </td>
        </tr>

        <tr scope="row">
          <th>
			      <label for="wkohc_allow_order_status"><?php esc_html_e( 'Allow Order Status', 'wk-ohc' ); ?><?php echo wc_help_tip( esc_html__( 'Allow in which order status customer can add comment', 'wk-ohc' ) ) ?></label>
  			  </th>
          <td>
            <select name="wkohc_allow_order_status[]" multiple="true" id="wkohc_allow_order_status" data-placeholder="<?php esc_html_e( 'Select Order Status', 'wk-ohc' ); ?>" class="wkohc-select2 regular-text">

          		<?php foreach ( wc_get_order_statuses() as $key => $value ) : ?>
          			<?php if ( get_option( 'wkohc_allow_order_status' ) ) : ?>
          				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( in_array( $key, get_option( 'wkohc_allow_order_status' ), true ) ); ?>><?php echo esc_html( $value ); ?></option>
          			<?php else : ?>
          				<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
          			<?php endif; ?>
          		<?php endforeach; ?>
          	</select>
          </td>
        </tr>

        <tr>
  				<th scope="row">
  					<label for="wkohc_send_mail_admin"><?php esc_html_e( 'Send Mail to Admin', 'wk-ohc' ); ?></label>
  				</th>
  				<td class="forminp forminp-text">
  					<?php echo wc_help_tip( esc_html__( 'If checked, Then mail will send to admin after comment', 'wk-ohc' ), true ); // WPCS: XSS ok. ?>
  					<input type="checkbox" name="wkohc_send_mail_admin" id="wkohc_send_mail_admin" value="1" <?php checked( get_option( 'wkohc_send_mail_admin' ), 1 ); ?> />
  				</td>
  			</tr>

        <tr>
  				<th scope="row">
  					<label for="wkohc_send_mail_customer"><?php esc_html_e( 'Send Mail to Customer', 'wk-ohc' ); ?></label>
  				</th>
  				<td class="forminp forminp-text">
  					<?php echo wc_help_tip( esc_html__( 'If checked, Then mail will send to customer after comment', 'wk-ohc' ), true ); // WPCS: XSS ok. ?>
  					<input type="checkbox" name="wkohc_send_mail_customer" id="wkohc_send_mail_customer" value="1" <?php checked( get_option( 'wkohc_send_mail_customer' ), 1 ); ?> />
  				</td>
  			</tr>

      </tbody>
    </table>
    <?php submit_button(); ?>
  </form>
</div>
