<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    {{>head}}
    <body <?php body_class(); ?>>
        <div class="wrap">
            {{>header}}
        	<div class="body Cf">
            	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>

        				<h3><?php the_title(); ?></h3>
        				<?php edit_post_link('<small>Edit this entry</small>','',''); ?>
        				<?php if ( has_post_thumbnail() ) { /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>

        				<div class="post-content page-content">
        					<?php the_content(); ?>
        					<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
        				</div><!--.post-content .page-content -->

            			<div id="page-meta">
            				<h3><?php _e('Written by '); the_author_posts_link() ?></h3>
            				<p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); } ?></p>
            				<p><?php _e('Posted on '); the_time('F j, Y'); _e(' at '); the_time() ?></p>
            			</div><!--#pageMeta-->
            		</div><!--#post-# .post-->

            		<?php comments_template( '', true ); ?>

            	<?php endwhile; ?>
                {{>sidebar}}
        	</div>
            {{>footer}}
        </div>
        <?php wp_footer();?>
    </body>
</html>