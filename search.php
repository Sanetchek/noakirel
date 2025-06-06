<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php
				/* translators: %s: search term */
				printf( esc_attr__( 'Search Results for: %s', 'noakirel' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header><!-- .page-header -->

	<?php
	get_template_part( 'loop' );

else :

	get_template_part( 'content', 'none' );

endif;
?>

<?php
do_action( 'storefront_sidebar' );
get_footer();
