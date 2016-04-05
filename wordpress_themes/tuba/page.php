<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <?php get_header(); ?>
    <body <?php body_class(); ?>>
        <div id="main">
        	<div id="header">
        		<div class="container">
        			<div id="title">

    					<h1 id="logo"><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
    					<h2 id="tagline"><?php bloginfo('description'); ?></h2>
        			</div><!--#title-->

        			<div id="nav-primary" class="nav">
        				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>
                    </div><!--#nav-primary-->
        		</div><!--.container-->
            </div><!--#header-->
        	<div class="container">
                <div id="content">
                	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                		<div id="post-<?php the_ID(); ?>" <?php post_class('page'); ?>>
                			<article>
                				<h3><?php the_title(); ?></h3>
                				<?php edit_post_link('<small>Edit this entry</small>','',''); ?>
                				<?php if ( has_post_thumbnail() ) { /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
	
                				<div class="post-content page-content">
                					<?php the_content(); ?>
                					<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
                				</div><!--.post-content .page-content -->
                			</article>

                			<div id="page-meta">
                				<h3><?php _e('Written by '); the_author_posts_link() ?></h3>
                				<p class="gravatar"><?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '80' ); } ?></p>
                				<p><?php _e('Posted on '); the_time('F j, Y'); _e(' at '); the_time() ?></p>
                			</div><!--#pageMeta-->
                		</div><!--#post-# .post-->

                		<?php comments_template( '', true ); ?>

                	<?php endwhile; ?>
                </div><!--#content-->
                <?php get_sidebar(); ?>
        	</div><!--.container-->
            <?php get_footer(); ?>
        </div><!--#main-->
        <?php wp_footer(); /* this is used by many Wordpress features and plugins to work proporly */ ?>
    </body>
</html>