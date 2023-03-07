<?php

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since Twenty Seventeen 1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	$comments_arg = [
		'title_reply' 			=> 'Deja tu comentario',
		'title_reply_before' 	=> '<h6 id="reply-title" class="comment-reply-title mt-4">',
		'title_reply_after' 	=> '</h6>',
		'class_submit' 			=> 'btn btn-my-color-5',
		'comment_notes_before' 	=> '<p class="m-0">Tu correo electrónico no se publicará.</p>',
		'fields' 				=> apply_filters('comment_form_default_fields', [
			'author' => '<div class="row">
														<div class="col-md-6 col-sm-12"><div class="form-group">' .
				'<label class="control-label m-0" for="author">' . __('Nombre') . '</label>' . ($req ? '<span>*</span>' : '') .
				'<input id="author" class="form-control" name="author" type="text" placeholder="nombre" value="' .
				esc_attr($commenter['comment_author']) . '" ' . $aria_req . '/>
														</div>
													</div>',
			'email' => '<div class="col-md-6 col-sm-12">
														<div class="form-group">' .
				'<label class="control-label m-0" for ="email">' . __('E-mail') . '</label>' . ($req ? '<span>*</span>' : '') .
				'<input class="form-control" id="email" name="email" type="text" placeholder="e-mail" value="' .
				esc_attr($commenter['comment_author_email']) . '" ' . $aria_req . '/>
														</div>
													</div></div>',
		]),
		'comment_field' => '<p>' .
			'<textarea id="comment" class="form-control" placeholder="Deja tu mensaje..." name="comment" rows="3"
											   aria-required="true"></textarea>' . '</p>',
		'comment_notes_after' => '',
		'cancel_reply_link' => '<u><span class="twentyseventeen-font-size-theme-16">' . __('Cancelar respuesta') . '</span></u>',
	];
	comment_form($comments_arg);

	// You can start editing here -- including this comment!
	if (have_comments()) :
	?>
		<h4 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ('1' === $comments_number) {
				/* translators: %s: Post title. */
				printf(_x('Una respuesta a &ldquo;%s&rdquo;', 'comments title', 'twentyseventeen'), get_the_title());
			} else {
				printf(
					/* translators: 1: Number of comments, 2: Post title. */
					_nx(
						'%1$s Responder a &ldquo;%2$s&rdquo;',
						'%1$s Respuestas a &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'twentyseventeen'
					),
					number_format_i18n($comments_number),
					get_the_title()
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'avatar_size' => 32,
					'style'       => 'ol',
					'type'		  		=>	'comment',
					'short_ping' 		=>	true,
					'reverse_top_level' =>	true, //Newest first
					'max_depth' 		=>	3, //Maximum comments depth				
					'callback' => 'better_comments'
					//'reply_text'  => twentyseventeen_get_svg( array( 'icon' => 'mail-reply' ) ) . __( 'Reply', 'twentyseventeen' ),
				)
			);
			?>
		</ol>

	<?php
		the_comments_pagination(
			array(
				'prev_text' => twentyseventeen_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous', 'twentyseventeen') . '</span>',
				'next_text' => '<span class="screen-reader-text">' . __('Next', 'twentyseventeen') . '</span>' . twentyseventeen_get_svg(array('icon' => 'arrow-right')),
			)
		);

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
	?>
		<p class="no-comments"><?php _e('Comments are closed.', 'twentyseventeen'); ?></p>
	<?php
	endif;
	?>

</div><!-- #comments -->