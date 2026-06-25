<?php
/**
 * The sidebar template
 *
 * @package DREAMASAHOMES
 */

if ( ! is_active_sidebar( 'primary-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="primary-sidebar" role="complementary">
	<?php dynamic_sidebar( 'primary-sidebar' ); ?>
</aside>
