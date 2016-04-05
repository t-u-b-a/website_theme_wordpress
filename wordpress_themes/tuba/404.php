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
                	<div id="error404" class="post">
                		<h3><?php _e('Error 404 Not Found'); ?></h3>
                		<div class="post-content">
                			<p><?php _e('Oops. Fail. The page cannot be found.'); ?></p>
                			<p><?php _e('Please check your URL or use the search form below.'); ?></p>
                			<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
                		</div><!--.post-content-->
                	</div><!--#error404 .post-->
                </div><!--#content-->
                <?php get_sidebar(); ?>
        	</div><!--.container-->
        <?php get_footer(); ?>
        </div><!--#main-->
        <?php wp_footer(); /* this is used by many Wordpress features and plugins to work proporly */ ?>
    </body>
</html>