<?php
/**
 * Header Template
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

$header_class[] = 'header';
$header_class[] = 'thb-main-header';
$header_class[] = thb_customizer( 'fixed_header_shadow' );
$header_class[] = 'header-full-width';
?>
<div class="header-wrapper">
	<header class="<?php echo esc_attr( implode( ' ', $header_class ) ); ?>">
		<div class="header-logo-row">
			<div class="row align-middle">
				<div class="small-8 large-2 columns">
					<?php do_action( 'thb_mobile_toggle' ); ?>
					<?php do_action( 'thb_logo' ); ?>
				</div>
				<div class="small-6 large-8 columns show-for-large">
					<div class="thb-navbar">
						<?php get_template_part( 'inc/templates/header/full-menu' ); ?>
					</div>
				</div>
				<div class="small-4 large-2 columns">
					<?php do_action( 'thb_secondary_area' ); ?>
				</div>
			</div>
		</div>
	</header>
</div>
