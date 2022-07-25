<?php
/**
 * Search Form
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

?>
<form method="get" class="searchform" role="search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input name="s" type="text" placeholder="<?php esc_attr_e( 'Search', 'overline' ); ?>" class="search-field">
	<button type="submit" class="search-submit" value="<?php echo esc_attr_e( 'Search', 'overline' ); ?>"><?php get_template_part( 'assets/img/svg/search.svg' ); ?></button>
</form>
