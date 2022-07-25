<?php
/**
 * Front Functions
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Emails;

defined( 'ABSPATH' ) || exit;

if (!class_exists('WKOHC_Admin_Mail')) {

    /**
     * Ask to admin Email.
    */
    class WKOHC_Admin_Mail extends \WC_Email {

        /**
         * Constructor of the class.
        */
        public function __construct() {

            $this->id             = 'new_admin_mail';
            $this->title          = esc_html__('WKOHC Admin Mail', 'wk-ohc');
            $this->description    = esc_html__('Query emails are sent to chosen recipient(s) ', 'wk-ohc');
            $this->heading        = esc_html__('Added new comment', 'wk-ohc');
            $this->subject        = '[' . get_option('blogname') . ']' . esc_html__(' New Comment', 'wk-ohc');
            $this->template_html  = 'emails/wkohc-admin-mail.php';
            $this->template_plain = 'emails/plain/wkohc-admin-mail.php';
            $this->footer         = esc_html__('Thanks for choosing Order History Communication', 'wk-ohc');
            $this->template_base  = WKOHC_PLUGIN_FILE.'woocommerce/templates/';

            add_action('wkohc_admin_mail_notification', array($this, 'trigger'), 10, 1);

            // Call parent constructor.
            parent::__construct();

            // Other settings.
            $this->recipient = get_option('admin_email');
        }

        /**
         * Trigger.
         * @param int $order_id order id
        */
        public function trigger($comment_info) {

            if (!empty($comment_info)) {

                $admin_email = get_option('admin_email');
                
                $link = ' #<a href="'. get_edit_post_link($comment_info['comment_post_ID']) . '">' . $comment_info['comment_post_ID'] . '</a>';

                if($comment_info['comment_author'] == 'admin') {
                  $subject = sprintf(esc_html__('New comment added by admin in order #%d', 'wk-ohc'), $comment_info['comment_post_ID']);
                  $reference_message = $subject = esc_html__('New comment added by admin in order', 'wk-ohc') . $link;
                } else {
                  $subject = sprintf(esc_html__('New comment added by %s in order #%s', 'wk-ohc'), $comment_info['comment_author'], $comment_info['comment_post_ID']);
                  $reference_message = sprintf(esc_html__('New comment added by %s in order', 'wk-ohc'), $comment_info['comment_author']) . $link;
                }

                $email = filter_var($admin_email, FILTER_SANITIZE_EMAIL);
                $subject = filter_var($subject, FILTER_SANITIZE_STRING);
                $message = filter_var($comment_info['comment_content'], FILTER_SANITIZE_STRING);
                $this->data = array(
                  'email'   => $email,
                  'subject' => $subject,
                  'message' => $message,
                  'reference_message' => $reference_message,
                );

                $this->subject = $subject;

                $headers = 'MIME-Version: 1.0'."\n";
                $headers .= 'From: '.$email."\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n";
                $headers .= "X-Priority: 1 (Highest)\n";
                $headers .= "X-MSMail-Priority: High\n";
                $headers .= "Importance: High\n";
                $this->headers = $headers;
            }

            if ($this->is_enabled() && $this->get_recipient()) {
                $this->send($this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments());
            }
        }

        /**
         * Get content html.
         * @return string
        */
        public function get_content_html() {

            return wc_get_template_html($this->template_html, array(
                'email_heading' => $this->get_heading(),
                'admin_email'   => $this->get_recipient(),
                'data'          => $this->data,
                'email_heading' => $this->get_heading(),
                'blogname'      => $this->get_blogname(),
                'sent_to_admin' => false,
                'plain_text'    => false,
                'email'         => $this,
                'additional_content' => $this->get_additional_content(),
            ), '', $this->template_base);
        }

        /**
         * Get content plain.
         * @return string
        */
        public function get_content_plain() {
            return wc_get_template_html($this->template_plain, array(
                'email_heading' => $this->get_heading(),
                'admin_email'   => $this->get_recipient(),
                'data'          => $this->data,
                'email_heading' => $this->get_heading(),
                'blogname'      => $this->get_blogname(),
                'sent_to_admin' => false,
                'plain_text'    => true,
                'email'         => $this,
                'additional_content' => $this->get_additional_content(),
            ), '', $this->template_base);
        }
    }
}
