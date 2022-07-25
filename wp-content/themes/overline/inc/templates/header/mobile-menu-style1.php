<?php
/**
 * Mobile Menu Template
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

$class[] = 'style1';
$class[] = 'side-panel';
?>
<!-- Start Mobile Menu -->
<nav id="mobile-menu" class="<?php echo esc_attr( implode( ' ', $class ) ); ?>" data-behaviour="thb-default">
	<header class="side-panel-header">
		<a href="#" class="thb-close" title="<?php esc_attr_e( 'Close', 'overline' ); ?>"><?php esc_html_e( 'Close', 'overline' ); ?></a>
	</header>
	<div class="side-panel-inner">
		<div class="mobile-menu-top">
			<?php
			if ( has_nav_menu( 'nav-menu' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'nav-menu',
						'depth'          => 4,
						'container'      => false,
						'menu_class'     => 'thb-mobile-menu',
						'walker'         => new Thb_MobileDropdown(),
					)
				);
			}
			do_action( 'thb_secondary_menu' );
			?>
			<?php dynamic_sidebar( 'mobile-menu' ); ?>
		</div>
		<div class="mobile-menu-bottom">
			<?php
			$mobile_menu_footer = thb_customizer( 'mobile_menu_footer' );
			if ( $mobile_menu_footer ) {
				?>
				<div class="menu-footer">
					<?php echo do_shortcode( $mobile_menu_footer ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
</nav>
<!-- End Mobile Menu -->
