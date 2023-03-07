<?php if (!empty($related_posts)) { ?>
    <div class="col-sm-12 related-posts">
        <ul class="list-unstyled mb-0">
            <?php
            foreach ($related_posts as $post) {
                setup_postdata($post);
            ?>
                <li>
                    <a class="title" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if (has_post_thumbnail()) { ?>
                        <?php } ?>
                        <?php the_title(); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
    </div>
<?php
}
