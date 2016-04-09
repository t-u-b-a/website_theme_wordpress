<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <h2><?php printf( __( '%s' ), single_cat_title( '', false )); ?></h2>
                <h3><?php echo category_description(); ?></h3>

                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="post-single">
                        <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <?php if ( has_post_thumbnail() ) { /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
                        <?php /* ?>
                        <p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link() ?></p>
                        <?php */ ?>
                        <div class="post-excerpt">
                            <?php the_excerpt(); /* the excerpt is loaded to help avoid duplicate content issues */ ?>
                        </div>
                        <?php /* ?>
                        <div class="post-meta">
                            <p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
                            <p><?php _e('Categories:'); ?> <?php the_category(', ') ?></p>
                            <p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
                        </div>
                        <?php */ ?>
                    </div>
                <?php endwhile; else: ?>
                    <div class="no-results">
                        <p><strong><?php _e('No content'); ?></strong></p>
                    </div>
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