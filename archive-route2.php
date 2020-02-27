<?php /* Template Name: archive-route2 */ ?>
<?php get_header(); 

$args = array(  
    'post_type' => 'route',
    'post_status' => 'publish',
    'posts_per_page' => -1, 
    'orderby' => 'order', 
    'order' => 'ASC'
);

$loop = new WP_Query( $args ); 

$page_title = __('Tours', 'wm-child-verdenatura');
if (isset($_GET['fwp_targets'])){
        $term_slug = $_GET['fwp_targets'];
        $get_term = get_term_by( 'slug', $term_slug, $taxonomy = 'who');
        $term = 'term_'.$get_term->term_id;
        $iconimage = get_field('wm_taxonomy_featured_icon',$term);
        $iconimageurl = $iconimage['url'];
        $color = get_field('wm_taxonomy_color',$term);
        $page_title = $get_term->name;
        $term_description = $get_term->description;
        $term_description_discovery = get_field('wm_html_description',$term);
}
if (isset($_GET['fwp_tipologia'])){
        $term_slug = $_GET['fwp_tipologia'];
        $get_term = get_term_by( 'slug', $term_slug, $taxonomy = 'activity');
        $term = 'term_'.$get_term->term_id;
        $iconimage = get_field('wm_taxonomy_featured_icon',$term);
        $iconimageurl = $iconimage['url'];
        $color = get_field('wm_taxonomy_color',$term);
        $page_title = $get_term->name;
        $term_description = $get_term->description;
        $term_description_discovery = get_field('wm_html_description',$term);
}
?>
<style type="text/css">
    #left-area-with-map-container {
        float: left;
        width: 65%;
        margin-right: 20px;
        padding: 0;
    }

    #left-area-with-map-container wm-map-container {
        width: 100%;
        height: 60vh;
    }

    #left-area-with-map-container .facetwp-template#left-area {
        width: 100%;
    }

    #map-container {
        margin-bottom: 20px;
    }

    #map-container #map-expander {
        height: 36px;
        letter-spacing: .5px;
        text-transform: uppercase;
        text-align: center;
        width: 100%;
        border: 1px solid #fff;
        background: #7AB400;
        color: #fff;
        transition: color 250ms, background 250ms, border 250ms;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
        position: relative;
    }

    #map-container #map-expander:hover {
        border: 1px solid #7AB400;
        background: #fff;
        color: #7AB400;
    }

    #map-container #map-expander i {
        margin: 0 10px;
        font-size: 1.2em;
    }

    @media screen and (max-width: 980px) {
        #left-area-with-map-container {
            float: left;
            width: 100%;
            margin-right: 0;
            padding: 0;
        }
    }
</style>
<div id="main-content" class="archive-route-page">
    <div class="page-title"> 
    <h1 class="txt-white" id="title-archive"><img src="<?php echo $iconimageurl;?>"><?php echo $page_title;?></h1>
        <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
        <div class="tour-description"><p><?php echo $term_description;?></p></div>
    </div>
    <div class="container">
        <div id="content-area" class="clearfix">
            <div id="left-area-with-map-container">
                <div id="map-container">
                    <wm-map-container></wm-map-container>
                    <script src="/wp-content/plugins/wm-embedmaps/assets/js/index.js"></script>
                    <div id="map-expander">
                        <i class="wm-icon-ios7-world-outline"></i>
                        <div id="map-expander-text">show map</div>
                        <i class="wm-icon-ios7-world-outline"></i>
                    </div>
                    <script type="text/javascript">
                        (function($) { 
                            $("wm-map-container").css({display: 'none'});
                            $("#map-expander").click(function () {
                                if ($('wm-map-container').is(':visible')){
                                    $('wm-map-container').css({display: 'none'});
                                    $('#map-expander-text').text('show map');
                                    $('#map-expander').css({top: '0'});
                                }
                                else {
                                    $('wm-map-container').css({display: 'inline-block'});
                                    $('#map-expander-text').text('hide map');
                                    $('#map-expander').css({top: '-5px'});
                                    window.dispatchEvent(new Event('resize'));
                                }
                            });
                        })(jQuery);
                    </script>
                </div>
                <div id="left-area" class="facetwp-template">
            <?php
            if (!empty($term_description_discovery)){
                echo $term_description_discovery;
            }
            
            if ( $loop->have_posts() ) :
                $layer = array(
                    'type' => 'FeatureCollection',
                    'features' => array()
                );

                while ( $loop->have_posts() ) :
                    $loop->the_post();
                    $post_format = et_pb_post_format(); 
                    $post_id = get_the_ID();

                    $feature = array(
                        'type' => 'Feature',
                        'geometry' => array(
                            'type' => 'Point',
                            'coordinates' => array(
                                floatval(get_field('vn_longitude', $post_id)),
                                floatval(get_field('vn_latitude', $post_id))
                            )
                        ),
                        'properties' => array(
                            'id' => $post_id,
                            'web' => get_the_permalink(),
                            'image' => get_the_post_thumbnail_url()
                        )
                    );

                    // gets the promotion value from italian corrispondent if this route is in english 
                    $post_id_ita = '';
                    $promotion_value = '';
                    $post_id_quote = '';
                    $promotion_name = get_field('promotion_name',$post_id);
                    $get_lang = $_GET['lang'];
                    if (isset($_GET['lang'])) {
                        $post_id_ita = apply_filters( 'wpml_object_id', $post_id, 'route', FALSE, 'it' );
                    }
                    if ($post_id_ita) {
                        $promotion_value = get_field('promotion_value',$post_id_ita);
                        $post_id_quote = $post_id_ita;
                    } else {
                        $promotion_value = get_field('promotion_value',$post_id);
                        $post_id_quote = $post_id;
                    }

                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

                <?php
                    $thumb = '';

                    $width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

                    $height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                    $classtext = 'et_pb_post_main_image';
                    $titletext = get_the_title();
                    $feature['properties']['name'] = $titletext;
                    $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, true, 'Blogimage' );
                    $thumb = $thumbnail["thumb"];

                    et_divi_post_format_content();

                    if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) {
                        if ( 'video' === $post_format && false !== ( $first_video = et_get_first_video() ) ) :
                            printf(
                                '<div class="et_main_video_container">
                                    %1$s
                                </div>',
                                $first_video
                            );
                        elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : 
                    ?>
                        <div class="entry-featured-image-url" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>);" >
                        </div>
                        <div class="gallery-fdn">
                            <?php

                            $dog_friendly = get_field ('vn_meta_dog');
                            if ( $dog_friendly)
                                echo "<img src='/wp-content/themes/wm-child-verdenatura/images/dog-friendly.jpg' class='df-card' alt='dog-friendly'>";


                            $new = get_field( 'vn_new' );
                            if( $new )
                                echo "<img src='/wp-content/themes/wm-child-verdenatura/images/new.png' class='card' alt='Novità'>";

                            ?>
                        </div>

                    <?php
                        elseif ( 'gallery' === $post_format ) :
                            et_pb_gallery_images();
                        endif;
                    } ?>


                        <?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
                    <?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php endif; ?>



                    <div class="row-1">
                        <div class="scheda-route">
                            <div class="route-infos sx">
                                <p class="main-content-preventivo">
                                    <?php
                                    $vn_desc_min = get_the_excerpt();
                                    if ( $vn_desc_min )
                                    echo $vn_desc_min;
                                    ?>
                                </p>

                            <div class="durata-preventivo">

                            <?php
                            $days = get_field('vn_durata');
                            if ( $days )
                            {
                            $nights = $days - 1;
                            ?> <span class="dur">
                            <?php
                            echo __('Duration' , 'wm-child-verdenatura' ) . "</span>" . "<span class='dur-txt'>" .  " $days" . __( 'days' , 'wm-child-verdenatura' ) . "/$nights" . __( 'nights' , 'wm-child-verdenatura' ) ;
                            ?>
                            </span>

                            <?php

                            $vn_note_dur = get_field( 'vn_note_dur' );
                            if ( $vn_note_dur )
                                echo "<span class='webmapp_route_duration_notes'> ($vn_note_dur)</span>";
                        }
                        ?>
                    </div> <!-- chiudo .durata-preventivo -->
                            <br>
                            <div class="departure-preventivo-aside"> <!------------ Departure / Partenze -->
                                <span class='durata-txt'>
                                    <p class="tab-section">
                                        <?php
                                        if( have_rows('departures_periods') ){
                                        echo __('Departures:' ,'wm-child-verdenatura').':';}?>
                                    </p>
                                </span>
                                
                                <?php
                                    if( have_rows('departures_periods') ): ?>
                                    
                                    <div class="departure_name">
                                    </div>
                                    <div class="grid-container-period-aside">
                                    <div class="departure_start">
                                        <p><?php echo __('From:' ,'wm-child-verdenatura'); ?></p>
                                    </div>
                                        <div class="departure_stop">
                                                <p><?php echo __('To:' ,'wm-child-verdenatura'); ?></p>
                                        </div>
                                        <div class="departure_week_days"></div>
                                        <?php while( have_rows('departures_periods') ): the_row(); 
                                
                                        // vars
                                        $name = get_sub_field('name');
                                        $start = get_sub_field('start');
                                        $stop = get_sub_field('stop');
                                        $week_days = get_sub_field('week_days');
                                        $dateformatstring = "l";
                                
                                        ?>
                                        
                                        <div class="departure_start">
                                            <?php if( $start ): ?>
                                                <p><?php echo $start; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="departure_stop">
                                            <?php if( $stop ): ?>
                                                <p><?php echo $stop; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="departure_week_days">
                                            <?php if( $week_days ): ?>
                                                <ul>
                                                    <?php if (count($week_days) == 7) { ?>
                                                        <li style="display: inline;" ><?php echo __('Every day' ,'wm-child-verdenatura'); ?></li>
                                                        <?php }else { ?>
                                                            <span><?php echo __('Only' ,'wm-child-verdenatura').' '; ?></span>
                                                            <?php 
                                                            $i = 0;
                                                            $len = count($week_days);
                                                            foreach( $week_days as $week_day ): 
                                                                if ($i == 0){ ?>
                                                                    <li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                                                <?php } elseif ($i == $len -1){ ?>
                                                                    <?php echo __('and' ,'wm-child-verdenatura').' '; ?><li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                                                <?php } else { ?>
                                                                <span><?php echo __(',' ,'wm-child-verdenatura').' '; ?></span><li style="display: inline;" ><?php echo date_i18n($dateformatstring, strtotime($week_day)); ?></li>
                                                                <?php } $i++ ;?>
                                                    <?php endforeach; } ?>
                                                </ul>
                                            <?php endif; ?>
                                    </div>
                                
                                    <?php endwhile; ?>
                                
                                    </div>
                                
                                    <?php endif; ?>
                                    
                                    <?php // ---------- single departures ----------------//
                                    if( have_rows('departure_dates') ): ?>
                                    <div class="single-departure">
                                            <p class="tab-section"><?php echo __('Single departures' ,'wm-child-verdenatura').':';?></p>
                                    </div>
                                    <div class="grid-container-single">
                                    
                                    <?php while( have_rows('departure_dates') ): the_row(); 
                                
                                        // vars
                                        $date = get_sub_field('date');            
                                        ?>
                                
                                        <div class="departure_name">
                                            <?php if( $date ): ?>
                                                <p><?php echo $date; ?></p>
                                            <?php endif; ?>
                                        </div>
                                
                                    <?php
                                        endwhile;
                                    ?>
                                
                                    </div>
                                
                                    <?php endif; ?> <!-- End ---------- single departures -->
                            </div>
                            <p class="vn-note">
                        <?php
                        $vn_note = get_field('vn_note');
                        if ( $vn_note)
                            echo $vn_note;
                        ?>
                    </p>

                                <?php endif; ?>

                            </div> <!--route-infos sx--->

                <!---icone scheda route-archive--->
                            <div class="icone-scheda-archive dx">
                                <div class="nazione">
                        <?php
                        the_term_image_with_name( $post_id , 'where' ) ; ?>
                    </div> <!--.nazione-->
                    <?php
                    the_term_image_with_name( $post_id , 'who' );
                    ?>
                    <div class="attività-route vn-meta-align">
                        <?php
                        the_term_image_with_name( $post_id , 'activity' );
                        ?>
                    </div>
                    <?php
                    $numero = get_field('vn_diff');
                    if ( $numero )
                    {
                        ?>
                        <div class="livello vn-meta-align">
                            <a class="fancybox" href="#difficulty_icon_popup">
                                <img src="<?php the_calcola_url( $numero ) ?>">
                            </a>
                            <p> <?php echo __('Level' ,'wm-child-verdenatura');?></p>
                        </div> <!--.livello-->
                        <?php
                    }
                    ?>


                    </div> <!-- .icone-scheda-archive dx--->
                </div> <!-- .row-01--->

                            <div class="row-02">
                            <div class="prezzo-container"> <!-- prezzo start-->
                                    <p class="promotion-trip">
                                        <?php
                                            
                                            if ( $promotion_value )
                                            echo __( 'Trip in promotion' , 'wm-child-verdenatura' );
                                        ?>
                                    </p> 
                                    <div class="prezzo">
                                    <?php echo __('Prices from' , 'wm-child-verdenatura'); ?>
                                    <span class="cifra <?php if ( $promotion_value){ echo 'old-price';}?>"><?php
                                    $vn_prezzo = get_field('wm_route_price');
                                    $lowest_price = explode('€',$vn_prezzo);
                                    if ($lowest_price) {
                                        echo $lowest_price[0];
                                    } else {
                                        echo $vn_prezzo;
                                    }
                                    ?>
                                    € </span>
                                    <?php if ( $promotion_value):?>
                                    <span class="new-price">
                                        <?php 
                                            if ($lowest_price) {
                                                echo $lowest_price[0] - $promotion_value;
                                            } else {
                                                echo $vn_prezzo - $promotion_value;
                                            }
                                        ?>
                                    € </span>
                                    <?php endif; ?>
                                    </div> 
                                </div><!--.prezzo  end-->
                                <span class="det-btt  dx ">
                                    <button class="details-butt">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo __('DETAILS','wm-child-verdenatura');?>
                                        </a>
                                    </button>
                                </span>

                            </div> <!-- .row-02--->


                        </div> <!-- .scheda-route --->



                    </article> <!-- .et_pb_post -->

            <?php
                array_push($layer['features'], $feature);
                endwhile;
                echo do_shortcode ('[facetwp pager="true"]');
            ?>
            <script type="text/javascript">
                var layers = [<?php echo json_encode($layer); ?>];
                var definitions = [
                    {
                        id: 'vn-routes',
                        icon: 'wm-icon-flag',
                        color: '#f00'
                    }
                ];
                window.localStorage.setItem('wm_geojson_layers', JSON.stringify(layers));
                window.localStorage.setItem('wm_overlays_definition', JSON.stringify(definitions));
                document.dispatchEvent(new Event('wm_overlays_updated'));
            </script>
            <?php
                else :
                    get_template_part( 'includes/no-results', 'index' );
                endif;
            ?>

            </div> <!-- #left-area -->
        </div>


                <?php
                    if ( shortcode_exists('facetwp') ) :
                ?>
                        <div id="sidebar" class="h-facet" >
                            <h2 class="filtra-viaggi"><?php echo __('Filter tours by','wm-child-verdenatura').'...';?></h2>
                        </div> <!-- chiudo .h-facet -->
                        <div id="sidebar" class="side-facet">
                            <?php
                                $facets = array(
                                        'tipologia' => '',
                                        'targets' => '',
                                        'places_to_go' => '',
                                        'durata' => '',
                                        'seasons' => '',
                                );
                                foreach ( $facets as $facet => $label)
                                {
                                    echo do_shortcode("[facetwp facet='$facet' title='$label']");
                                    echo '<br>';
                                }
                            
                                ?>
                                <div class="no-filters"><a href="/route/<?php if (isset($_GET['lang'])){ echo "?lang=".$_GET['lang'];} ?>"><p><?php echo __('Remove filters' ,'wm-child-verdenatura');?></p></a></div>
                                <script>
                                    (function($) { 
                                        $(document).on('facetwp-loaded', function() {  // function for wpfacet labels
                                            
                                            // scroll to top on facetwp pagination reload
                                            if (FWP.loaded) {
                                                $('html, body').animate({
                                                    scrollTop: $('#et-main-area').offset().top
                                                }, 0);
                                            }
                                        });

                                            $(".showmore").hide();
                                            $(".ng-hide").click(function(){
                                                $(this).hide();
                                                $(".showmore").show();
                                            });
                                    })(jQuery);
                                </script>
                        </div>
                     <?php
                    endif;
                    ?>

        </div> <!-- #content-area -->
    </div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
