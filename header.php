<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/ie/html5.js" type="text/javascript"></script>
<![endif]-->
<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/img/favicon.png" type="image/png" />
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<div class="container header">
	<div class="row">
		<div class="site-header-inner col-sm-12">
			<header id="masthead" class="site-header" role="banner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php echo get_template_directory_uri(); ?>/img/logo.png"  alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
							</a>

						<div class="site-branding">
							<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h4 class="site-description"><?php bloginfo( 'description' ); ?></h4>
						</div>

		</header><!-- #masthead -->

<div class="social-links">
				<a href="http://instagram.com/" target="_blank"><span class="fa-stack">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-instagram fa-stack-1x"></i>
				</span></a>

				<a href="https://www.facebook.com/" target="_blank">
				<span class="fa-stack">
				  <i class="fa fa-circle-thin fa-stack-2x "></i>
				  <i class="fa fa-facebook fa-stack-1x"></i>
				</span>
				</a>

								<a href="https://twitter.com/" target="_blank"><span class="fa-stack">
				  <i class="fa fa-circle-thin fa-stack-2x"></i>
				  <i class="fa fa-twitter fa-stack-1x"></i>
				</span></a>
				</div>


		<nav class="site-navigation">
					<div class="site-navigation-inner">
						<div class="navbar navbar-default">
							<div class="navbar-header">
						    <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
						    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
						    	<span class="sr-only">Toggle navigation</span>
						      <span class="icon-bar"></span>
						      <span class="icon-bar"></span>
						      <span class="icon-bar"></span>
						    </button>
						  </div>

					    <!-- The WordPress Menu goes here -->
			        <?php wp_nav_menu(
		                array(
		                    'theme_location' => 'primary',
		                    'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
		                    'menu_class' => 'nav navbar-nav',
		                    'fallback_cb' => '',
		                    'menu_id' => 'main-menu',
		                    'walker' => new wp_bootstrap_navwalker()
		                )
		            ); ?>

						</div><!-- .navbar -->
					</div>
		</nav><!-- .site-navigation -->
		</div><!-- .site-header-inner -->
	</div><!-- .row -->
</div><!-- .container -->
	<div class="container">
		<div class="row">
			<div id="content" class="main-content-inner col-sm-12"><!-- for sidebar col-md-8">-->