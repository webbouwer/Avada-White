<?php

// >> https://theme-fusion.com/documentation/avada/install-update/avada-child-theme/


// https://herowp.com/auto-install-install-plugins-wordpress-themes/
// https://www.sitepoint.com/create-a-wordpress-theme-settings-page-with-the-settings-api/
// https://wpreset.com/programmatically-automatically-download-install-activate-wordpress-plugins/



// more info! // : https://developer.wordpress.org/themes/advanced-topics/child-themes/
require_once( get_stylesheet_directory(). '/includes/menu/menu.php' ); // menu image plugin functions <?php
//require_once( get_stylesheet_directory(). '/customizer.php' ); // customizer functions

/* Future jquery
 * including migration lib
 * replacing old jquery has issues with non compatable code
 */
/*
function replace_core_jquery_version() {
    wp_deregister_script( 'jquery-core' );
    wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.1.1.min.js", array(), '3.1.1' );
    wp_deregister_script( 'jquery-migrate' );
    wp_register_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.0.0.min.js", array(), '3.0.0' );
}
add_action( 'wp_enqueue_scripts', 'replace_core_jquery_version' );
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// https://digwp.com/2016/01/include-styles-child-theme/
if ( !function_exists( 'aw_rtl_css' ) ):
    function aw_rtl_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'aw_rtl_css' );

if ( !function_exists( 'aw_parent_css' ) ):
    function aw_parent_css() {
        wp_enqueue_style( 'aw_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'aw_parent_css', 10 );


// Start customize
function aw_basic_add_theme_menu_info()
{
	add_menu_page('Avada White Child Theme Panel', 'Avada White', 'manage_options', 'aw-theme-panel', 'aw_basic_theme_info', null, 99999);
    // https://shibashake.com/wordpress-theme/add_menu_page-add_submenu_page#add-menu
    // https://codex.wordpress.org/Creating_Options_Pages

}
add_action('admin_menu', 'aw_basic_add_theme_menu_info');

function aw_basic_theme_info()
{
     global $title;
    ?>
	    <div class='wrap'>
	    <h1>Avada White - <?php echo $title;?></h1>
            <p>
            <img width="400" height="auto" src="<?php echo get_stylesheet_directory_uri('stylesheet_directory')."/images/screenshot_avada_white.png"; ?>" />
            </p>
            <h3>Avada White and AvadaPack</h3>

            <p>Menu_Image original source <a target="blank" href="https://github.com/zviryatko/menu-image/blob/master/menu-image.php">github.com/zviryatko</a></p>
		</div>
	<?php
}

