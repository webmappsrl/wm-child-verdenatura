<?php
/**
 * Created by PhpStorm.
 * User: Silvia
 * Date: 27/11/18
 * Time: 09:29
 */

// Max Mega Menu Import //

function megamenu_add_theme_verde_natura_1543307241($themes) {
    $themes["verde_natura_1543307241"] = array(
        'title' => 'verde_natura_import',
        'container_background_from' => 'rgb(255, 255, 255)',
        'container_background_to' => 'rgb(255, 255, 255)',
        'container_padding_bottom' => '20px',
        'menu_item_align' => 'right',
        'menu_item_background_hover_from' => 'rgb(221, 221, 221)',
        'menu_item_background_hover_to' => 'rgb(217, 217, 217)',
        'menu_item_spacing' => '3 px',
        'menu_item_link_font' => 'Arial, Helvetica, sans-serif',
        'menu_item_link_font_size' => '17px',
        'menu_item_link_height' => '45px',
        'menu_item_link_color' => 'rgb(51, 51, 51)',
        'menu_item_link_weight' => 'bold',
        'menu_item_link_color_hover' => 'rgb(15, 122, 104)',
        'menu_item_link_weight_hover' => 'bold',
        'menu_item_link_padding_left' => '20.625px',
        'menu_item_link_padding_right' => '20.625px',
        'menu_item_border_color' => 'rgb(122, 180, 0)',
        'menu_item_border_right' => '2px',
        'menu_item_border_color_hover' => 'rgb(122, 180, 0)',
        'menu_item_divider_color' => 'rgb(122, 180, 0)',
        'panel_background_from' => 'rgb(255, 255, 255)',
        'panel_background_to' => 'rgb(255, 255, 255)',
        'panel_header_color' => 'rgb(255, 255, 255)',
        'panel_header_font' => 'Arial, Helvetica, sans-serif',
        'panel_header_border_color' => '#555',
        'panel_font_size' => '14px',
        'panel_font_color' => '#666',
        'panel_font_family' => 'Arial, Helvetica, sans-serif',
        'panel_second_level_font_color' => 'rgb(51, 51, 51)',
        'panel_second_level_font_color_hover' => 'rgb(15, 122, 104)',
        'panel_second_level_text_transform' => 'uppercase',
        'panel_second_level_font' => 'Arial, Helvetica, sans-serif',
        'panel_second_level_font_size' => '15 px',
        'panel_second_level_font_weight' => 'bold',
        'panel_second_level_font_weight_hover' => 'bold',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_second_level_border_color' => 'rgb(15, 122, 104)',
        'panel_second_level_border_bottom' => '2px',
        'panel_third_level_font_color' => 'rgb(51, 51, 51)',
        'panel_third_level_font_color_hover' => 'rgb(51, 51, 51)',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '14px',
        'panel_third_level_font_weight' => 'bold',
        'panel_third_level_font_weight_hover' => 'bold',
        'flyout_link_size' => '14px',
        'flyout_link_color' => '#666',
        'flyout_link_color_hover' => '#666',
        'flyout_link_family' => 'inherit',
        'line_height' => '3',
        'z_index' => '0',
        'shadow' => 'on',
        'resets' => 'on',
        'toggle_background_from' => '#222',
        'toggle_background_to' => '#222',
        'mobile_background_from' => '#222',
        'mobile_background_to' => '#222',
        'mobile_menu_item_link_font_size' => '14px',
        'mobile_menu_item_link_color' => '#ffffff',
        'mobile_menu_item_link_text_align' => 'left',
        'mobile_menu_item_link_color_hover' => '#ffffff',
        'mobile_menu_item_background_hover_from' => '#333',
        'mobile_menu_item_background_hover_to' => '#333',
        'custom_css' => '/** Push menu onto new line **/ 
#{$wrap} { 
    clear: both; 
}',
    );
    return $themes;
}
add_filter("megamenu_themes", "megamenu_add_theme_verde_natura_1543307241");


/**
 * REGISTER TMP ROUTE FIELDS
 * 27/11/2018
 * MB
 */



$custom_fields = array(
    "sih" => "vn_sih",
    "fdn" => "vn_fdn",
    "new" => "vn_new",
    "diff" => "vn_diff",
    "mezza_pensione" => "vn_mezza_pensione",
    "sopraponte" => "vn_sopraponte",
    "durata" => "vn_durata",
    "note_dur" => "vn_note_dur",
    "partenze" => "vn_partenze",
    "part_sum" => "vn_part_sum",
    "desc_min" => "vn_desc_min",
    "note" => "vn_note",
    "desc" => "vn_desc",
    "prog" => "vn_prog",
    "scheda_tecnica" => "vn_scheda_tecnica",
    "part_pr" => "vn_part_pr",
    "come_arrivare" => "vn_come_arrivare",
    "latitude" => "vn_latitude",
    "longitude" => "vn_longitude",
    "prezzo" => "vn_prezzo",
    "prezzo_sc" => "vn_prezzo_sc",
    "ordine" => "vn_ordine"
);

$std = array(
    'key' => '',
    'label' => '',
    'name' => '',
    'type' => 'text'
);

$fields = array();
foreach ( $custom_fields as $field )
{
    $std['key'] = $field;
    $std['name'] = $field;
    $std['label'] = $field;
    $fields[] = $std;
}
$stop = 'here';
$args = array(
    'key' => 'group_vn_58528c8aa5b2ffaskd',
    'title' => 'Importazione Verde Natura',
    'fields' => $fields,
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'route',
            ),
        ),
    ),
    'menu_order' => 0,
    'active' => 1
);
new WebMapp_RegisterFieldsGroup('route' ,$args );
