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
                        <h4><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h4>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-thumbnail"><?php the_post_thumbnail(); ?></div>
                        <?php endif; ?>
                        <div class="post-excerpt">
                            <?php the_excerpt(); ?>
                        </div>
                    </div>
                <?php endwhile; else: ?>
                    <div class="no-results">
                        <p><strong><?php _e('No content'); ?></strong></p>
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