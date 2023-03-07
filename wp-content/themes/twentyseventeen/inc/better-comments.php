<?php
// My custom comments output html
function better_comments($comment, $args, $depth)
{
    // Get correct tag used for the comments
    if ('div' === $args['style']) {
        $tag       = 'div';
        $add_below = 'comment';
    } else {
        $tag       = 'li';
        $add_below = 'div-comment';
    } ?>

    <<?php echo $tag; ?> <?php comment_class(empty($args['has_children']) ? '' : 'parent'); ?> id="comment-<?php comment_ID() ?>">

        <?php
        // Switch between different comment types
        switch ($comment->comment_type):
            case 'pingback':
            case 'trackback': ?>
                <div class="pingback-entry"><span class="pingback-heading"><?php esc_html_e('Pingback:', 'textdomain'); ?></span> <?php comment_author_link(); ?></div>
            <?php
                break;
            default:
                /*********************** */

            ?>
                <div class="container mt-1">
                    <div class="row  d-flex justify-content-center">
                        <div class="col-md-12">
                            <?php if ('div' != $args['style']) { ?>
                                <div class="card p-3 mt-2" id="div-comment-<?php comment_ID() ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="user d-flex flex-row align-items-center">
                                            <?php
                                            if ($args['avatar_size'] != 0) {
                                                $avatar_size = !empty($args['avatar_size']) ? $args['avatar_size'] : 70; // set default avatar size
                                                echo get_avatar($comment, $avatar_size);
                                            }
                                            ?>
                                            <?php printf(__('<span><small class="font-weight-bold text-primary twentyseventeen-font-size-theme-16">&nbsp; %s</small><small class="twentyseventeen-font-size-theme-16 font-weight-bold">&nbsp; dice: </small></span>', 'textdomain'), get_comment_author_link()); ?>
                                        </div>
                                        <small class="twentyseventeen-font-size-theme-16"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php
                                                                                                                                                                            /* translators: 1: date, 2: time */
                                                                                                                                                                            printf(
                                                                                                                                                                                __('%1$s - %2$s', 'textdomain'),
                                                                                                                                                                                get_comment_date(),
                                                                                                                                                                                get_comment_time()
                                                                                                                                                                            ); ?>
                                            </a></small>
                                    </div>
                                    <div class="comment-text pl-4 m-0"><?php comment_text(); ?></div><!-- .comment-text -->
                                    <?php if ($comment->comment_approved == '0') { ?>
                                        <div class="comment-text pl-4 m-0"><em class="comment-awaiting-moderation"><?php _e('Tu comentario está pendiente de moderación.', 'textdomain'); ?></em></div><br/><?php
                                                                                                                                                            } ?>
                                    <div class="action d-flex justify-content-between mt-2 align-items-center">
                                        <div class="reply px-4">
                                            <?php $response = comment_reply_link(array_merge($args, ['add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']])); ?>
                                            <?php if ($response != '') { ?>
                                                <small class="twentyseventeen-font-size-theme-16"><?php
                                                                                                    // Display comment reply link
                                                                                                    comment_reply_link(array_merge($args, array(
                                                                                                        'add_below' => $add_below,
                                                                                                        'depth'     => $depth,
                                                                                                        'max_depth' => $args['max_depth']
                                                                                                    ))); ?></small>
                                                <span class="dots"></span>
                                            <?php } ?>
                                            <small class="twentyseventeen-font-size-theme-16"><?php edit_comment_link(__('Editar', 'textdomain'), '  ', ''); ?></small>
                                        </div>
                                        <div class="icons align-items-center">
                                            <i class="fa fa-check-circle-o check-icon text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                if ('div' != $args['style']) { ?>

    <?php }
                /************************* */
                break;
        endswitch; // End comment_type check.
    }
