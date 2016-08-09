<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
<?php /* ?>
                <h2 class="listing-hd"><?php printf( __( '%s' ), single_cat_title( '', false )); ?></h2>
<?php */ ?>
                <div class="post listing">
                    <ul class="ul">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <li class="post-li">
                            <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="featured-thumbnail">
                                    <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail(); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        </li>
                    <?php endwhile; else: ?>
                        <li class="no-results">
                            <p><strong><?php _e('No content'); ?></strong></p>
                        </li>
                    <?php endif; ?>
                    </ul>
                    <div class="oldernewer">
                        <p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
                        <p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
                    </div>
                </div>
            </div>
            {{>footer}}
        </div>
        <?php wp_footer(); ?>
    </body>
</html>