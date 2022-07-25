<?php
/**
 * Post Tags
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */


if ( ! thb_customizer( 'article_tags' ) ) {
	return;
}
$posttags = get_the_tags();
?>
<?php if ( ! empty( $posttags ) ) { ?>
	<div class="thb-article-tags">
		<?php
		if ( $posttags ) {
			$return = '';
			foreach ( $posttags as $thb_tag ) {
				?>
				<a href="<?php echo esc_url( get_tag_link( $thb_tag->term_id ) ); ?>" title="<?php echo esc_attr( get_tag_link( $thb_tag->name ) ); ?>"><?php echo esc_html( $thb_tag->name ); ?></a>
				<?php
			}
		}
		?>
	</div>
	<?php
}
