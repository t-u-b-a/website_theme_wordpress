<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="post-single">
                    <h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-thumbnail"><?php the_post_thumbnail(); ?></div>
                    <?php endif; ?>
                    <div class="post-content">
                        <?php the_content(__('Read more'));?>
                    </div>
                    <div class="post-meta">
                        <p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link(); ?></p>
                        <p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
                        <p><?php _e('Categories: '); the_category(', ') ?></p>
                        <p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
                    </div>
                </div>
                <?php endwhile; else: ?>
                <div class="no-results">
                    <p><strong><?php _e('There has been an error.'); ?></strong></p>
                </div>
                <?php endif; ?>
                <div class="oldernewer">
                    <p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
                    <p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
                </div>
                {{>sidebar}}
            </div>
            {{>footer}}
        </div>
        <?php wp_footer(); ?>
    </body>
</html>