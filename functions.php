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
    wp_enqueue_style('route-single-post-style', get_stylesheet_directory_uri() . '/single-route-style.css');
    //wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
}

/**
 * Material Icons
 */

add_action( 'wp_head' , 'aggiungi_material_icons' );
function aggiungi_material_icons(){
    echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
    //load jquery ui theme css
    echo '<link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet">';
    echo '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>';
}


/**
 * Search bar e map search
 */

// add_action ('et_header_top', 'vn_search_bar');
function vn_search_bar() {

    echo '<div id="vn-search-bar-header"><input id="cerca-home" type="text" placeholder="Cerca" name="search">
      <button id="vn-search-lente" type="submit"  onclick="location.href=\'http://vn.be.webmapp.it/route/?fwp_title\'"><i class="fa fa-search"></i></button></div>';

}

add_action( 'et_header_top', 'vn_search_map' );
function vn_search_map() {
    echo '<div id="vn-search-map"><i class="material-icons">language</i></div>';
}


function my_search_form( $form ) {
    $form = '<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( 'http://vn.be.webmapp.it/route/?fwp_title' ) . '" >
    <div><label class="screen-reader-text" for="s">' . __( 'Cerca:' ) . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. esc_attr__( 'Cerca' ) .'" />
    </div>
    </form>';

    return $form;
}

add_filter( 'get_search_form', 'my_search_form' );


/**
 * VN E-book Forme
 */

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
                <input data-cons-subject="first_name" type="text" name="campo1" value="" size="40" placeholder="<?php echo __('First name' ,'wm-child-verdenatura'); ?>">
                <input data-cons-subject="last_name" type="text" name="campo2" value="" size="40" placeholder="<?php echo __('Last name' ,'wm-child-verdenatura'); ?>">
                <input data-cons-subject="email" type="email" name="email" value="" size="40" required="required" placeholder="Email"><br>
                    <div class="block center clear mrg-b-m">
                    <input data-cons-preference="general" type="checkbox" name="privacy" id="privacy1" required="required"><label for="privacy1" class="block center" style="line-height:1.2; text-align:left; color:#fff!important"><?php
                            echo __('*I accept to receive promotionals e-mails as written in our' ,'wm-child-verdenatura'); ?> <a target="_blank" href="https://www.verde-natura.it/privacy/" class="txt-dark-green">Privacy</a>.</label>
                    </div>
             </fieldset>
                <input data-iub-consent-form="" name="Submit" type="submit" value="<?php
                echo __('Subscribe' ,'wm-child-verdenatura'); ?>" class="btn btn-flat center-align">
           </form>
           </div> <!--chiudo .vn-form-prefooter-->
    <?php
    $html= ob_get_clean();

    if ( ! is_home() && ! is_front_page() )
    {

        echo $html;
    }
}

/**
 * Load Footer Image
 */


add_action( 'et_after_main_content', 'vn_add_footer_image' );
function vn_add_footer_image() {

    echo '<div id="vn-footer-img"></div>';
}

/**
 * Load tab for Single Route post type
 */


function vn_add_route_tabs () {

ob_start();
get_template_part('schede_single_route');
$scheda = ob_get_clean();


echo do_shortcode( $scheda );

}

/**
 * Icons for Single Route post type
 */

function the_calcola_url( $num )
{

    $numero_arrotondato = floor( $num );
    echo "/wp-content/themes/wm-child-verdenatura/images/diff-" . $numero_arrotondato . ".png";
}


function the_term_image_with_name( $post_id , $taxonomy )
{
    $terms = get_the_terms( $post_id , $taxonomy );
    if ( is_array( $terms ) )
    {
        foreach ( $terms as $term )
        {
            if ( $taxonomy == 'where' )
            {
                echo "<span class='vn_taxonomy_image_single_route vn_{$taxonomy}_image_single_route'>";
                echo "<img src='/wp-content/themes/wm-child-verdenatura/images/dest.png'>";
                echo $term->name;
                echo "</span>";
            }
            else
            {
                $image = get_field('wm_taxonomy_featured_icon' , $term );
                if ( isset($image['url']) )
                {
                    echo "<span class='vn_taxonomy_image_single_route vn_{$taxonomy}_image_single_route'>";
                    echo "<img src='".$image['url']."'>";
                    echo $term->name;
                    echo "</span>";

                }
            }

        }
    }
}





/**
 * Comments in single route
 */

add_filter( 'comment_text' , 'filtra_commento' , 10 , 3 );

function filtra_commento( $comment_text, $comment , $args )
{
    $date_html = '';
    $date = get_field('wm_comment_journey_date', $comment);
    if ( $date )
    {
        $date_html = "<div class='journey-comment'>" . __('Journey from' , 'wm_comment_journey_date' ) . " $date</div>";
    }

    $gallery = '';

    $vn_gallery = get_field ('wm_comment_gallery' , $comment );
    if ( is_array( $vn_gallery) && ! empty( $vn_gallery ) )
    {
        $vn_gallery_ids =  array_map(
            function ($i) {
                return $i ['ID'];
            },
            $vn_gallery );

        $gallery = "<div class='wm-comment-images'>";
        foreach ( $vn_gallery_ids  as $id)
        {
            $gallery .= '<span class="wm-comment-image">';
            $gallery .= wp_get_attachment_image( $id, 'thumbnail');
            $gallery .= '</span>';
        }
        $gallery = "</div>";

    }


    return "$date_html<div class='my_comment_text'>$comment_text</div>$gallery";
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


add_filter( "megamenu_nav_menu_args", 'vn_fix_megamenu_mobile_menu' , 10 ,3 ) ;
function vn_fix_megamenu_mobile_menu( $defaults, $menu_id, $current_theme_location )
{
    if ( isset( $defaults['items_wrap'] ) && strpos( $defaults['items_wrap'], 'data-mobile-force-width="10%"') !== false )
        $defaults['items_wrap'] = str_replace( 'data-mobile-force-width="10%"' , '' , $defaults['items_wrap'] );

    return $defaults;
}

function fwp_add_facet_labels() {
    ?>
    <script>
        (function($) {
            $(document).on('facetwp-loaded', function() {
                $('.facetwp-facet').each(function() {
                    var $facet = $(this);
                    var facet_name = $facet.attr('data-name');
                    var facet_label = FWP.settings.labels[facet_name];

                    if ($facet.closest('.facet-wrap').length < 1) {
                        $facet.wrap('<div class="facet-wrap"></div>');
                        $facet.before('<h3 class="facet-label">' + facet_label + '</h3>');
                    }
                });
            });
        })(jQuery);
    </script>
    <?php
}
add_action( 'wp_head', 'fwp_add_facet_labels', 100 );

