<?php
/**
 * Load products.
 *
 * @author     Webkul.
 * @implements Assets_Interface
 */

namespace wooMarketplaceRFQ\Templates\Admin\Menu\Quote;

use DateTime;
use WP_List_table;
use wooMarketplaceRFQ\Helper;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Womprfq_Seller_Quotation_List')) {
    /**
     * Connected product list.
     */
    class Womprfq_Seller_Quotation_List extends WP_List_Table
    {
        protected $quote_id;
        protected $main_quotation_data;
        protected $auth;
        /**
         * Class constructor.
         */
        public function __construct($id, $main_data)
        {
            $this->quote_id = $id;
            $this->main_quotation_data = $main_data;
            parent::__construct(
                array(
                'singular' => esc_html__('Quotation', 'wk-mp-rfq'),
                'plural' => esc_html__('Quotations', 'wk-mp-rfq'),
                'ajax' => false,
                )
            );
        }

        /**
         * Function prepare items.
         */
        public function prepare_items()
        {
            global $wpdb;
            
            $columns = $this->get_columns();

            $this->process_bulk_action();

            $data = $this->table_data();

            $totalitems = count($data);

            $user = get_current_user_id();

            $screen = get_current_screen();

            $option = $screen->get_option('per_page', 'option');
            
            if (empty($option) ) {
                $option = 20;
            }
            
            $sortable = $this->get_sortable_column();

            $this->_column_headers = array($columns, array(), $sortable);
            
            usort($data, array($this, 'usort_reorder'));
            
            $perpage = get_user_meta($user, $option, true);
            
            if (empty($perpage) || $perpage < 1) {

                $perpage = $screen->get_option('per_page', 'default');
            }
            
            $totalpages = ceil($totalitems / $perpage);

            $current_page = $this->get_pagenum();

            $data = array_slice($data, (($current_page - 1) * $perpage), $perpage);

            $this->set_pagination_args(
                array(
                'total_items' => $totalitems,
                'total_pages' => $totalpages,
                'per_page' => $perpage,
                )
            );

            $this->items = $data;
        }
        
        /**
         * For sorting data.
         *
         * @param string $a sort var
         * @param string $b sort var
         */
        public function usort_reorder($a, $b)
        {
            $request = $_REQUEST;

            $orderby = (!empty($request['orderby'])) ? $request['orderby'] : 'id'; // If no sort, default to title.

            $order = (!empty($request['order'])) ? $request['order'] : 'asc'; // If no order, default to asc.

            $result = strnatcmp($a[$orderby], $b[$orderby]); // Determine sort order.

            return ('asc' === $order) ? $result : -$result; // Send final sort direction to usort.
        }
        
        /**
         * Returns sortable columns
         */
        public function get_sortable_column()
        {
            $sortable = array(
                'id' => array('id', true)
            );
            return $sortable;
        }

        /**
         * Define the columns that are going to be used in the table.
         *
         * @return array $columns, the array of columns to use with the table
         */
        public function get_columns()
        {
            $columns = array(
                'cb' => '<input type="checkbox" />',
                'id' => esc_html__('Quotation Id', 'wk-mp-rfq'),
                'product' => esc_html__('Product Name', 'wk-mp-rfq'),
                'quote_amount' => esc_html__('Total Quote Quantity', 'wk-mp-rfq'),
                'seller' => esc_html__('Seller', 'wk-mp-rfq'),
                'date_created' => esc_html__('Date Added', 'wk-mp-rfq'),
                'action' => esc_html__('Action', 'wk-mp-rfq')
            );

            return $columns;
        }

        /**
         * Set default columns.
         *
         * @param array  $item        data array
         * @param string $column_name column_name
         */
        public function column_default($item, $column_name)
        {
            switch ($column_name) {
            case 'cb':
            case 'id':
            case 'product':
            case 'quote_amount':
            case 'seller':
            case 'date_created':
            case 'action':
                return $item[$column_name];
            default:
                return print_r($item, true);
            }
        }

        /**
         * Column checkbox.
         *
         * @param array $item item array
         */
        public function column_cb($item)
        {
            return sprintf(
                '<input type="checkbox" id="pid_%s" name="pid[]" value="%s" />', 
                $item['id'], 
                $item['id']
            );
        }
        
        /**
         * Column id.
         *
         * @param array $item item array
         *
         * @return string 
         */
        public function column_id($item)
        {
            $ac_class = '';
            if ($this->auth == intval($item['seller'])) {
                $ac_class = esc_attr('wk_accepted_quote');
            }
            
            $actions = array(
                'delete' =>  sprintf('<a href="%s">%s</a>', admin_url('admin.php?page=wk-mp-rfq&perform=seller-quote&qid='.intval($this->quote_id).'&action=delete&'.'pid='.intval($item['id'])), esc_html__('Delete', 'wk-mp-rfq')),
            );

            return sprintf(' <span class="%s"></span> # %d %s', $ac_class, $item['id'], $this->row_actions($actions));
        }

        /**
         * Column action.
         *
         * @param array $item item array
         */
        public function column_action($item)
        {
            return sprintf(
                '<a class=" button button-primary edit-slots" href="%s">%s</a>', 
                admin_url('admin.php?page=wk-mp-rfq&perform=edit-seller-quote&sqid='.intval($item['id'])), 
                esc_html__('View', 'wk-mp-rfq')
            );
        }
        /**
         * Column checkbox.
         *
         * @param array $item item array
         */
        public function column_product_image($item)
        {   
            if ($item['product']->get_image_id()) {
                $url = wp_get_attachment_url($item['product']->get_image_id());
            } else {
                $url = wc_placeholder_img_src();
            }
            return sprintf('<img src="%s" width="50px">', $url);
        }
        
        /**
         * Column checkbox.
         *
         * @param array $item item array
         */
        public function column_product($item)
        {
            return sprintf(
                '<span>%s</span>', 
                $item['product']
            );
        }
        
        /**
         * Column quote amount.
         *
         * @param array $item item array
         */
        public function column_quote_amount($item)
        {
            return sprintf(
                '<span>%s</span>', 
                $item['quote_amount']
            );
        }
        
        /**
         * Column quote amount.
         *
         * @param array $item item array
         */
        public function column_seller($item)
        {
            $user = get_user_by('id', $item['seller']);
            if ($user) {
                $email = $user->user_email;
                $name = $user->display_name;
            } else {
                $name  = esc_html('-');
                $email = esc_html__('N\A', 'wk-mp-rfq');
            }
            
            return sprintf(
                '<span>%s</span><br><span>%s</span>', 
                $name,
                $email
            );
        }
        
        /**
         * Column checkbox.
         *
         * @param array $item item array
         */
        public function column_status($item)
        {
            $status = '';
            if ($item['status'] == 1) {
                $status = esc_html__('Enable', 'wk-mp-rfq');
            } elseif ($item['status'] == 2) {
                $status = esc_html__('Disable', 'wk-mp-rfq');
            }
            return sprintf('<span>%s</span>', $status);
        }
        
        /**
         * Column checkbox.
         *
         * @param array $item item array
         */
        public function column_date_created($item)
        {
            $fdate = '';
            if ($item['date_created']) {
                $date = new DateTime($item['date_created']);
                $fdate = $date->format(get_option('date_format') . ' ' . get_option('time_format'));
            }
            return $fdate;
        }

        /**
         * Process table data.
         */
        private function table_data()
        {
            $post_data = $_GET;
            $list_data = $fnl_data = array();
            $search = '';
            
            if (isset($post_data['s']) && !empty($post_data['s'])) {
                $search = $post_data['s'];
            }

            $list_obj = new Helper\Womprfq_Quote_Handler();
            
            $meta = $list_obj->womprfq_get_quote_meta_info($this->quote_id);
            
            if (isset($meta['quote_product_id']) && !empty($meta['quote_product_id'])) {
                $this->auth = intval(get_post_field('post_author', intval($meta['quote_product_id'])));
            } else {
                $this->auth = 0;
            }
            
            $list_data = $list_obj->womprfq_get_all_seller_quotation_list($this->quote_id, $search);
            $product = array();
            if ($this->main_quotation_data->variation_id!= 0) {
                $product = get_the_title($this->main_quotation_data->variation_id);
            } elseif ($this->main_quotation_data->product_id!= 0) {
                $product = get_the_title($this->main_quotation_data->product_id);
            } else {
                $quote_d = $list_obj->womprfq_get_quote_meta_info($this->main_quotation_data->id);
                if (isset($quote_d['pro_name'])) {
                    $product = $quote_d['pro_name'];
                }
            }
            if ($list_data) {
                foreach ($list_data as $data) {
                    if (isset($data->seller_id)&&!empty($data->seller_id)) {
                        $user = get_user_by('ID', intval($data->seller_id));
                        if (!empty($user)) {
                            if ($search==''|| is_int(stripos($user->display_name, $search)) || is_int(stripos($user->user_login, $search)) || is_int(stripos($user->user_email, $search))) {
                                $fnl_data[] = array(
                                    'id' => intval($data->id),
                                    'product' => $product,
                                    'quote_amount' => $data->quantity,
                                    'seller' => $data->seller_id,
                                    'date_created' => $data->date,
                                );
                            }
                        }
                    }
                }
            }
    
            return $fnl_data;
        }

        /**
         * Bulk action options  .
         */
        public function get_bulk_actions()
        {
            $actions = array(
                'delete' => esc_html__('Delete', 'wk-mp-rfq'),
            );

            return $actions;
        }

        /**
         * Process bu;lk action.
         *
         * @return void
         */
        public function process_bulk_action()
        {
            if ($this->current_action() == 'delete') {
                if (isset($_GET['pid']) && !empty($_GET['pid'])) {
                    $pid = $_GET['pid'];
                    $obj = new Helper\Womprfq_Quote_Handler();
                    $obj->womprfq_delete_seller_quote_by_id($pid);
                    ?>
                    <div class="updated notice">
                        <p>
                            <?php esc_html_e('Deleted Successfully.', 'wk-mp-rfq'); ?>
                        </p>
                    </div>
                    <?php
                }
            }
        }
    }
}