<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<?php get_header(); ?>
<body <?php body_class(); ?>>
<div id="main">
	<div id="header">
		<div class="container">
			<div id="title">
				<?php if( is_front_page() || is_home() || is_404() ) { ?>
					<h1 id="logo"><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h1>
					<h2 id="tagline"><?php bloginfo('description'); ?></h2>
				<?php } else { ?>
					<h2 id="logo"><a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('name'); ?></a></h2>
					<h3 id="tagline"><?php bloginfo('description'); ?></h3>
				<?php } ?>
			</div><!--#title-->

			<div id="nav-primary" class="nav">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu', 'menu_id' => 'primary-menu' ) ); ?>
            </div><!--#nav-primary-->
		</div><!--.container-->
    </div><!--#header-->
	<div class="container">
        <div id="content">
        	<h1><?php printf( __( 'Category Archives: %s' ), '<span>' . single_cat_title( '', false ) . '</span>' ); ?></h1>
        	<?php echo category_description(); /* displays the category's description from the Wordpress admin */ ?>

        	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        		<div class="post-single">
        			<h2><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
        			<?php if ( has_post_thumbnail() ) { /* loades the post's featured thumbnail, requires Wordpress 3.0+ */ echo '<div class="featured-thumbnail">'; the_post_thumbnail(); echo '</div>'; } ?>
	
        			<p><?php _e('Written on '); the_time('F j, Y'); _e(' at '); the_time(); _e(', by '); the_author_posts_link() ?></p>
        			<div class="post-excerpt">
        				<?php the_excerpt(); /* the excerpt is loaded to help avoid duplicate content issues */ ?>
        			</div>
	
        			<div class="post-meta">
        				<p><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></p>
        				<p><?php _e('Categories:'); ?> <?php the_category(', ') ?></p>
        				<p><?php if (the_tags('Tags: ', ', ', ' ')); ?></p>
        			</div><!--.postMeta-->
        		</div><!--.post-single-->
        	<?php endwhile; else: ?>
        		<div class="no-results">
        			<p><strong><?php _e('There has been an error.'); ?></strong></p>
        			<p><?php _e('We apologize for any inconvenience, please hit back on your browser or use the search form below.'); ?></p>
        			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
        		</div><!--noResults-->
        	<?php endif; ?>
		
        	<div class="oldernewer">
        		<p class="older"><?php next_posts_link('&laquo; Older Entries') ?></p>
        		<p class="newer"><?php previous_posts_link('Newer Entries &raquo;') ?></p>
        	</div><!--.oldernewer-->
	
        </div><!--#content-->
        <?php get_sidebar(); ?>
	</div><!--.container-->
<?php get_footer(); ?>

</div><!--#main-->
<?php wp_footer(); /* this is used by many Wordpress features and plugins to work proporly */ ?>
</body>
</html>