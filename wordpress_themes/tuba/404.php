<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <h2><?php _e('[ Error 404 ]'); ?></h2>
                <div class="post-content">
                    <img class="missing" src="<?php bloginfo('template_url'); ?>/images/404.png" />
                    <p><?php _e('Oops. Fail. The page cannot be found.'); ?></p>
                </div>
            </div>
            {{>footer}}
        </div>
        <?php wp_footer(); ?>
    </body>
</html>