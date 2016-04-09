<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
            <div class="body Cf">
                <h3><?php _e('Error 404 Not Found'); ?></h3>
                <div class="post-content">
                    <p><?php _e('Oops. Fail. The page cannot be found.'); ?></p>
                    <p><?php _e('Please check your URL or use the search form below.'); ?></p>
                </div>
            </div>
            {{>footer}}
        </div>
        <?php wp_footer(); ?>
    </body>
</html>