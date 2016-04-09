<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <h2>
                    <?php if ( is_day() ) : /* if the daily archive is loaded */ ?>
                        <?php printf( __( 'Daily Archives: <span>%s</span>' ), get_the_date() ); ?>
                    <?php elseif ( is_month() ) : /* if the montly archive is loaded */ ?>
                        <?php printf( __( 'Monthly Archives: <span>%s</span>' ), get_the_date('F Y') ); ?>
                    <?php elseif ( is_year() ) : /* if the yearly archive is loaded */ ?>
                        <?php printf( __( 'Yearly Archives: <span>%s</span>' ), get_the_date('Y') ); ?>
                    <?php else : /* if anything else is loaded, ex. if the tags or categories template is missing this page will load */ ?>
                        Archives
                    <?php endif; ?>
                </h2>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <div class="post-single">
                        <h3><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="featured-thumbnail"><?php the_post_thumbnail(); ?></div>
                        <?php endif; ?>
                        <p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link() ?></p>
                        <div class="post-excerpt">
                            <?php the_excerpt(); /* the excerpt is loaded to help avoid duplicate content issues */ ?>
                        </div>
                        <?php /* ?>
                        <div class="post-meta">
                            <p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
                            <p><?php _e('Categories: '); the_category(', ') ?></p>
                            <p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
                        </div><!--.postMeta-->
                        <?php */ ?>
                    </div>
                <?php endwhile; else: ?>
                    <div class="no-results">
                        <p><strong><?php _e('No result.'); ?></strong></p>
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