<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <?php if (is_front_page()) : ?>
            <div class="hero">
                <div class="img"></div>
                <div class="title-wrap">
                    <h2 class="title">大標題</h2>
                    <h3 class="subtitle">小標題</h3>
                </div>
            </div>
            <?php endif; ?>
            <div class="body Cf">
                <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                <div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
                    <?php edit_post_link('<small>Edit this entry</small>','',''); ?>
                    <?php if ( has_post_thumbnail() ) : ?>
                        <div class="featured-thumbnail"><?php the_post_thumbnail(); ?></div>
                    <?php endif; ?>
                    <div class="post-content page-content">
                        <?php the_content(); ?>
                        <?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
                    </div>
                </div>
                <?php endwhile; ?>
                <?php if (is_front_page()) : ?>
                    {{>sidebar}}
                <?php endif; ?>
            </div>
            {{>footer}}
        </div>
        <?php wp_footer();?>
    </body>
</html>