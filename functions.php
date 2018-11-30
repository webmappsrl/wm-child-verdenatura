<?php

require ('import_data.php');



add_action( 'wp_enqueue_scripts', 'Divi_parent_theme_enqueue_styles' );


function Divi_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'divi-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'webmapp-theme-style', get_stylesheet_directory_uri() . '/style.css', [ 'divi-style' ], '.1' );
}

add_action( 'wp_head' , 'aggiungi_material_icons' );
function aggiungi_material_icons(){
    echo "<link href=\"https://fonts.googleapis.com/icon?family=Material+Icons\" rel=\"stylesheet\">";
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

add_action( 'et_after_main_content', 'vn_add_footer_image' );
function vn_add_footer_image() {

    echo '<div id="vn-footer-img"></div>';
}




