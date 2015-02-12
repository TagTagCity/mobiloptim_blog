<?php
/**
 * Our theme header
 *
 * @package Makron
 * @since Makron 1.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

    <?php wp_head(); ?>

	<style>


		a.menu-element:hover{
			font-family:"Helvetica Neue";
			color:#FFF;
			text-decoration:none;
			background-color:#2abb9c;
    			border-radius: 10px;
			
			}
		a.menu-element{
			padding:15px 25px;
			color:#2abb9c;
			}
		.site-title{
			text-align:center;
			}

		.mak-inner{
			text-align:center;
			color:dark grey;
			}

		.banner{
			height:150px;
			width:100%;
			background-color:#2e3030;
			}
		.deco{
			height:11px;
			width:100%;
			background-color:#2abb9c;
			}
		
		
	</style>		
	
</head>
<body <?php body_class(); ?>>
<div class="mak-wrapper">
    <header class="mak-header mak-cf" role="banner">
	

	<div class="Basic_46" style="height:45px;">
		
	<?php do_action ('wp_menubar', 'Top Nav'); ?>
	</div>
		<div class="banner">
        <div class="mak-inner" style="height:120px;">
        <?php if( display_header_text() ) : ?>
            
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?><img src="http://ttcmobstoprdeuw.blob.core.windows.net/blog/2015/02/blog1.png"/></a></h1>
</div>
</div>
<div class="deco"></div>
 </header>

                <p class="site-tagline"><?php bloginfo( 'description' ); ?></p>
            </div>
        <?php endif; ?>
            <nav id="mak-main-nav" role="navigation">

                <?php
                    if( has_nav_menu( 'primary_navigation' ) ) :
                        wp_nav_menu( array(
                            'theme_location' => 'primary_navigation',
                            'menu_class'     => 'nav mak-nav',
                            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                            'depth'          => 3,
                            'walker'         => new Makron_Nav_Walker()
                        ) );
                    endif;
                ?>

            </nav>
        </div>

  

    <main class="mak-main mak-cf" role="main">