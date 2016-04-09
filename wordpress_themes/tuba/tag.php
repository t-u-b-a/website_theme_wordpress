<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <h1><?php printf( __( 'Tag Archives: %s' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>
                <?php echo tag_description(); ?>

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="post-single">
                        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <?php if ( has_post_thumbnail() ) { echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="post-meta">
                            <p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link() ?></p>
                            <p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
                            <p><?php _e('Categories: '); the_category(', ') ?></p>
                            <p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
                        </div><!--.postMeta-->
                    </div><!--.1`post-single-->
                <?php endwhile; else: ?>
                    <div class="no-results">
                        <p><strong><?php _e('There has been an error.'); ?></strong></p>
                    </div><!--noResults-->
                <?php endif; ?>
                <div class="oldernewer">
                    <p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
                    <p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
                </div><!--.oldernewer-->
                {{>sidebar}}
            </div>
            {{>footer}}
        </div>
        <?php wp_footer(); ?>
    </body>
</html>