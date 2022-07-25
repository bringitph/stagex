<?php
/**
 * Header related functions
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

/* Thb Mobile Toggle */
function thb_mobile_toggle() {
	?>
	<div class="mobile-toggle-holder thb-secondary-item">
		<div class="mobile-toggle">
			<span></span><span></span><span></span>
		</div>
	</div>
	<?php
}
add_action( 'thb_mobile_toggle', 'thb_mobile_toggle', 3 );

// Mobile Menu.
function thb_mobile_menu() {
	get_template_part( 'inc/templates/header/mobile-menu-style1' );
}
add_action( 'wp_footer', 'thb_mobile_menu' );

// Logo.
function thb_logo( $section = false ) {
	$classes[] = 'logo-holder';
	?>
	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo           = $custom_logo_id ? wp_get_attachment_image_src( $custom_logo_id, 'full' ) : false;
		if ( has_custom_logo() && $logo ) {
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logolink" title="<?php echo esc_attr( bloginfo( 'name' ) ); ?>">
				<img src="<?php echo esc_url( $logo[0] ); ?>" alt="<?php echo esc_attr( bloginfo( 'name' ) ); ?>" class="logoimg" />
			</a>
			<?php } else { ?>
			<div class="logo-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logolink" title="<?php echo esc_attr( bloginfo( 'name' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></div>
			<?php
			}
			?>
	</div>
	<?php
}
add_action( 'thb_logo', 'thb_logo', 2, 1 );

// Searchform.
function thb_product_searchform( $index = false ) {
	?>
	<div class="thb-header-inline-search">
		<?php
		if ( ! thb_wc_supported() ) {
			get_search_form();
		} else {
			wc_get_template(
				'product-searchform.php',
				array(
					'index' => $index,
				)
			);
		}

		?>
		<div class="thb-autocomplete-wrapper"></div>
	</div>
	<?php
}
add_action( 'thb_product_searchform', 'thb_product_searchform', 2, 1 );

// Secondary Area.
function thb_secondary_area( $mobile = false ) {
	?>
	<div class="thb-secondary-area">
		<?php
			do_action( 'thb_quick_search' );
			do_action( 'thb_quick_profile' );
			do_action( 'thb_quick_cart' );
		?>
	</div>
	<?php
}
add_action( 'thb_secondary_area', 'thb_secondary_area', 10, 1 );

// Secondary Search.
function thb_quick_search() {
	if ( ! thb_customizer( 'header_search' ) ) {
		return;
	}
	?>
	<div class="thb-secondary-item thb-quick-search">
		<div class="thb-item-icon-wrapper">
			<?php get_template_part( 'assets/img/svg/search.svg' ); ?>
		</div>
		<div class="thb-search-toggle">
			<div class="thb-header-inline-search">
				<?php
				if ( ! thb_wc_supported() ) {
					get_search_form();
				} else {
					wc_get_template( 'product-searchform.php' );
				}
				?>
				<div class="thb-autocomplete-wrapper"></div>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'thb_quick_search', 'thb_quick_search', 10, 1 );

// Header Profile.
function thb_quick_profile() {
	if ( ! thb_wc_supported() ) {
		return;
	}
	?>
	<a class="thb-secondary-item thb-quick-profile" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'overline' ); ?>">
		<?php get_template_part( 'assets/img/svg/myaccount.svg' ); ?>
	</a>
	<?php
}
add_action( 'thb_quick_profile', 'thb_quick_profile' );

// Header Cart.
function thb_quick_cart() {
	if ( ! thb_wc_supported() ) {
		return;
	}
	?>
	<div class="thb-secondary-item thb-quick-cart">
		<div class="thb-item-icon-wrapper">
			<span class="thb-item-icon">
				<?php get_template_part( 'assets/img/svg/cart.svg' ); ?>
				<?php if ( is_object( WC()->cart ) ) { ?>
					<span class="count thb-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
				<?php } ?>
			</span>
		</div>
	</div>
	<?php
}
add_action( 'thb_quick_cart', 'thb_quick_cart', 3 );

// Secondary Menu.
function thb_secondary_menu( $mobile = false ) {
	if ( has_nav_menu( 'acc-menu-in' ) && is_user_logged_in() ) {
		wp_nav_menu(
			array(
				'theme_location' => 'acc-menu-in',
				'depth'          => 2,
				'container'      => false,
				'menu_class'     => 'thb-secondary-menu thb-full-menu',
			)
		);
	} elseif ( has_nav_menu( 'acc-menu-out' ) && ! is_user_logged_in() ) {
		wp_nav_menu(
			array(
				'theme_location' => 'acc-menu-out',
				'depth'          => 2,
				'container'      => false,
				'menu_class'     => 'thb-secondary-menu thb-full-menu',
			)
		);
	}
}
add_action( 'thb_secondary_menu', 'thb_secondary_menu', 10, 1 );
