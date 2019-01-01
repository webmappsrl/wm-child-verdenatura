<?php

require ('import_data.php');
require ('shortcodes/vn_home_tabs.php');
require ('shortcodes/vn_route_tabs.php');
require ('shortcodes/wm_gallery.php');

add_action('after_setup_theme', 'vn_theme_setup');

/**
 * Load translations for wm-child-verdenatura
 */
function vn_theme_setup(){
    load_theme_textdomain('wm-child-verdenatura', get_stylesheet_directory() . '/languages');
}




add_action( 'wp_enqueue_scripts', 'Divi_parent_theme_enqueue_styles' );


function Divi_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'divi-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'slick-style', get_stylesheet_directory_uri() . '/third-parts/slick-1.8.1/slick/slick.css' );
    wp_enqueue_script( 'slick-script', get_stylesheet_directory_uri() . '/third-parts/slick-1.8.1/slick/slick.min.js', array ('jquery') );
    wp_enqueue_style( 'slick-theme-style', get_stylesheet_directory_uri() . '/third-parts/slick-1.8.1/slick/slick-theme.css' );

    wp_enqueue_style( 'webmapp-theme-style', get_stylesheet_directory_uri() . '/style.css', [ 'divi-style' ], '.1' );
	//enqueue script for jquery ui tabs
}


add_action( 'wp_head' , 'aggiungi_material_icons' );
function aggiungi_material_icons(){
    echo "<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">";
    //load jquery ui theme css
    echo '<link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet">';
    echo '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';
}

add_action( 'wp_head' , 'aggiungi_bootstrap' );
function aggiungi_bootstrap(){
    echo "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\" integrity=\"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO\">";
}

//add_action ('et_header_top', 'vn_search_bar');
function vn_search_bar() {


    echo '<div id="vn-search-bar-header"><input id="cerca-home" type="text" placeholder="Cerca" name="search">
      <button id="vn-search-lente" type="submit"><i class="fa fa-search"></i></button></div>';

}

add_action( 'et_header_top', 'vn_search_map' );
function vn_search_map() {
    echo '<div id="vn-search-map"><i class="material-icons">language</i></div>';
}

function the_calcola_url( $num )
{

    $numero_arrotondato = floor( $num );
    echo "/wp-content/themes/wm-child-verdenatura/images/diff-" . $numero_arrotondato . ".png";
}




// VN E-BOOK FORM
add_action( 'et_after_main_content', 'vn_add_ebook_form' );
function vn_add_ebook_form()
{
    ob_start (); ?>
            <div class="vn-form-prefooter" style="background-color: #63BCF8;">
            <form action="https://fexe.mailupclient.com/Frontend/subscribe.aspx">
            <input name="list" type="hidden" value="108" autocomplete="off">
            <input name="group" type="hidden" value="1348" autocomplete="off">
                <header style="background-image:url(/wp-content/themes/wm-child-verdenatura/images/tree_spring.png); background-repeat: no-repeat;
                background-position: right top; position: relative; background-size: 50%; display:block; height: 9.375rem;">
                <h3 class="title-vn-form-ebook center"  style="text-align: center; color: #FFF; padding: 70px 0px 0px 0px; font-size: 38px; 
                font-family: PT Sans, sans-serif; font-weight: bold;">
                <?php
                echo __('Subscribe to our newsletter' ,'wm-child-verdenatura');
                ?>
                </h3></header>
                <p class="txt-white p-vn-form-ebook pad-lr-ml container pad-tb-s center" style="color: #FFF; font-size: 16px; font-family: Lato, sans-serif; text-align: center; font-weight: bold; line-height: 1.4;
   ">
                    <?php
                    echo __('Subscribe to our newsletter to stay updated on new tours and all promotional offers. Verde Natura monthly newsletter also includes latest news from our blog, comments and tips.' ,'wm-child-verdenatura');
                    ?>
                </p>
            <fieldset class="pad-lr-ml container pad-tb-s">
                <input data-cons-subject="first_name" type="text" name="campo1" value="" size="40" placeholder=<?php
                echo __('First name' ,'wm-child-verdenatura'); ?>>
                <input data-cons-subject="last_name" type="text" name="campo2" value="" size="40" placeholder=<?php
                echo __('Last ame' ,'wm-child-verdenatura'); ?>>
                <input data-cons-subject="email" type="email" name="email" value="" size="40" required="required" placeholder="Email"><br>
                    <div class="block center clear mrg-b-m">
                    <input data-cons-preference="general" type="checkbox" name="privacy" id="privacy1" required="required"><label for="privacy1" class="block center" style="line-height:1.2; text-align:left; color:#fff!important"><?php
                            echo __('*I accept to receive promotionals e-mails as written in our' ,'wm-child-verdenatura'); ?> <a target="_blank" href="https://www.verde-natura.it/privacy/" class="txt-dark-green">Privacy</a>.</label>
                    </div>
             </fieldset>
                <input data-iub-consent-form="" name="Submit" type="submit" value=<?php
                echo __('Subscribe' ,'wm-child-verdenatura'); ?> class="btn btn-flat center-align">
           </form>
           </div> <!--chiudo .vn-form-prefooter-->
    <?php
    $html= ob_get_clean();

    if ( ! is_home() && ! is_front_page() )
    {

        echo $html;
    }
}



add_action( 'et_after_main_content', 'vn_add_footer_image' );
function vn_add_footer_image() {

    echo '<div id="vn-footer-img"></div>';
}



function vn_add_route_tabs () {

ob_start();
get_template_part('schede_single_route');
$scheda = ob_get_clean();


echo do_shortcode( $scheda );

}


function the_term_image_with_name( $post_id , $taxonomy )
{
    $terms = get_the_terms( $post_id , $taxonomy );
    if ( is_array( $terms ) )
    {
        foreach ( $terms as $term )
        {

            switch ( $taxonomy )
            {

                case 'who':
                    $image = "/wp-content/themes/wm-child-verdenatura/images/logo-guida.png";
                    break;
                case 'where':
                    $image = "/wp-content/themes/wm-child-verdenatura/images/dest.png";
                    break;

                default:
                    $image = false;
                    break;
            }

            if ( $image )
            {
                echo "<span class='vn_taxonomy_image_single_route vn_{$taxonomy}_image_single_route'>";
                echo "<img src='$image'>";
                echo $term->name;
                echo "</span>";

            }
        }
    }
}






/**
 * Adds meta for social sharing
 */
//add_action( 'wp_head' , 'vn_add_meta_for_social_sharing' );
function vn_add_meta_for_social_sharing()
{
    if ( ! is_singular('route') )
        return;

    ob_start();
    ?>

    <meta property="og:title" content="<?php the_title(); ?>">
    <meta property="og:description" content="<?php the_excerpt()?>">
    <meta property="og:image" content="<?php the_post_thumbnail_url(); ?>">
    <meta property="og:url" content="<?php the_permalink();?>">

    <meta name="twitter:title" content="<?php the_title(); ?>">
    <meta name="twitter:description" content="<?php the_excerpt()?>">
    <meta name="twitter:image" content="<?php the_post_thumbnail_url(); ?>">
    <meta name="twitter:card" content="<?php the_permalink();?>">



    <?php
    echo ob_get_clean();


}

