<?php
/**
 * Comments list template
 *
 * @package    Receptar
 * @copyright  2015 WebMan - Oliver Juhas
 *
 * @since    1.0
 * @version  1.3
 */



/**
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}



/**
 * Display comments container only if comments open
 * and there are some comments to display
 */
if (
		( is_single( get_the_ID() ) || is_page( get_the_ID() ) )
		&& ( comments_open() || have_comments() )
		&& post_type_supports( get_post_type(), 'comments' )
	) :

	wmhook_comments_before();

	?>

	<div id="comments" class="comments-area">

		<h2 id="comments-title" class="comments-title"><?php

			printf(
					esc_html( _nx( '1 comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'Comments list title.', 'receptar' ) ),
					number_format_i18n( get_comments_number() ),
					'<span>' . get_the_title() . '</span>'
				);

			echo '<a href="#respond" class="add-comment-link">' . esc_html_x( 'Add yours &rarr;', 'Add new comment link text.', 'receptar' ) . '</a>';

		?></h2>

		<?php

		/**
		 * Comments list
		 */
		if ( have_comments() ) :

			if ( ! comments_open() ) {

				?>

				<h3 class="comments-closed"><?php esc_html_e( 'Comments are closed. You can not add new comments.', 'receptar' ); ?></h3>

				<?php

			} // /! comments_open()

			//Actual comments list
				?>

				<ol class="comment-list">

					<?php wp_list_comments( array( 'avatar_size' => 240, 'style' => 'ol', 'short_ping' => true ) ); ?>

				</ol>

				<?php

			//Paginated comments
				if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {

					?>

					<nav id="comment-nav-below" class="comment-navigation" role="navigation">

						<h3 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'receptar' ); ?></h3>

						<div class="nav-previous">
							<?php previous_comments_link( esc_html__( '&larr; Older comments', 'receptar' ) ); ?>
						</div>

						<div class="nav-next">
							<?php next_comments_link( esc_html__( 'Newer comments &rarr;', 'receptar' ) ); ?>
						</div>

					</nav>

					<?php

				} // /get_comment_pages_count() > 1 && get_option( 'page_comments' )

		endif; // /have_comments()



		/**
		 * Comments form only if comments open
		 */
		if ( comments_open() ) {

			comment_form();

		}

	?>

	</div><!-- #comments -->

	<?php

	wmhook_comments_after();

endif;
