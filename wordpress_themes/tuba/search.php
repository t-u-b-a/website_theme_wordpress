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
                <div id="content" class="search">
                	<h3><?php the_search_query(); ?></h3>

                	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                		<div class="post-single">
                			<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                			<?php if ( has_post_thumbnail() ) { /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
                			<p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by ');  the_author_posts_link() ?></p>
	
                			<div class="post-excerpt">
                				<?php the_excerpt(); /* the excerpt is loaded to help avoid duplicate content issues */ ?>
                			</div><!--.post-excerpt-->
                		</div><!--.post-single-->
                	<?php endwhile; else: ?>
                		<div class="no-results">
                			<h2><?php _e('No Results'); ?></h2>
                			<p><?php _e('Please feel free try again!'); ?></p>
                			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
                		</div><!--no-results-->
                	<?php endif; ?>

                	<div class="oldernewer">
                		<p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
                		<p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
                	</div><!--.oldernewer-->
	
                </div><!-- #content -->
                <?php get_sidebar(); ?>
        	</div><!--.container-->
        <?php get_footer(); ?>

        </div><!--#main-->
        <?php wp_footer(); /* this is used by many Wordpress features and plugins to work proporly */ ?>
    </body>
</html>