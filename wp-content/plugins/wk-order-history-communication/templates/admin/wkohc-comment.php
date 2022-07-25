<?php
/**
 * Order notes HTML for meta box.
 *
 * @package WooCommerce/Admin
 */

defined( 'ABSPATH' ) || exit;

  $comment_data = $this->db_obj->wkohc_get_comment_data($order->ID);
?>
<div class="wkohc-sut-edit-quote">
    <table class="form-table wc_status_table widefat">
        <tbody>
        <?php
        if (!empty($comment_data)) {
            foreach ($comment_data as $comment) {
                if ('admin' == $comment->comment_author) {
                    $pos_class = 'wkohc-message-self';
                    $pos_arrow_class = 'wkohc-message-arrow-self';
                } else {
                    $pos_class = 'wkohc-message-other';
                    $pos_arrow_class = 'wkohc-message-arrow-other';
                }
                ?>
                <tr valign="top">
                    <td colspan="2" class="forminp" >
                        <p class="wk-sup-comment-body <?php echo esc_attr($pos_arrow_class); ?>">
                            <span class="wk-sup-bold"><?php esc_html_e('Message : ', 'wk-ohc'); ?></span>
                            <span><?php echo esc_html(sanitize_text_field( wp_unslash($comment->comment_content))); ?></span></br>
                            <span class="wk-ohc-comment-image-container" id="wk-ohc-comment-image-container">
                                <?php
                                $images = get_comment_meta($comment->comment_ID, '_wkohc_attach_file', false);

                                if (isset($images) && $images) {
                                    foreach ($images as $image) {
                                        $file = WKOHC_PLUGIN_FILE . 'uploads/' . esc_attr($comment->comment_post_ID) . '/' . esc_attr($image);
                                        if (file_exists($file)) {
                                          $ofile = WKOHC_PLUGIN_URL. 'uploads/' . esc_attr($comment->comment_post_ID) . '/' . esc_attr($image);
                                          ?>
                                          <a href="<?php echo esc_attr($ofile); ?>" data-toggle="tooltip" title="<?php esc_html_e('View Attachment','wk-ohc'); ?>" class="text-info" download><i class="dashicons dashicons-download"></i> </a>
                                          <?php
                                        }
                                    }
                                }
                                ?>
                            </span>
                        </p>
                        <p class="meta wk-sup-comment-head <?php echo esc_attr($pos_class); ?>">
														<abbr class="exact-date">
															<?php
															$date = new \DateTime($comment->comment_date);
															echo esc_html($date->format(get_option('date_format').' '. get_option('time_format')));
															esc_html_e(' by ', 'wk-ohc');
															if ($comment->comment_author == 'admin') {
																	esc_html_e('You', 'wk-ohc');
															} else {
																	esc_html_e($comment->comment_author, 'wk-ohc');
															}
															?>
														</abbr>
                        </p>
                    </td>
                </tr>
            <?php
            }
        } else {
            ?>
            <tr valign="top">
                    <td class="forminp" colspan="2">
                        <?php esc_html_e('No Comment Yet.', 'wk-ohc'); ?>
                    </td>
                </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>
<div class="wkohc_add_note" style="border-top:1px solid #ddd;">
  <p>
    <label for="wkohc_comment"><?php esc_html_e( 'Add Comment', 'wk-ohc' ); ?> </label>
    <textarea style="width:100%;height: 50px;" type="text" name="wkohc_comment" id="wkohc_comment" class="input-text" cols="20" rows="5"></textarea>
    <input type="hidden" name="wkohc_order_id" id="wkohc_order_id" value="<?php echo esc_attr($order->ID); ?>"/>
  </p>
  <p>
    <label for="wkohc_comment"><?php esc_html_e( 'Add Attachment', 'wk-ohc' ); ?>
      <button type="button" class="button" id="wkohc-add-attachment" style="margin-left:123px;">+</button>
    </label>
    <table class="wkohc-table">
      <tbody id="wkohc-tbody">
      </tbody>
    </table>
  </p>
  <p>
    <button type="button" class="wkohc_add_comment button" id="wkohc_add_comment"><?php esc_html_e( 'Add', 'wk-ohc' ); ?></button>
  </p>
</div>