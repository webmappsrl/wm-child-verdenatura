<!-- <script src="http://code.jquery.com/jquery-latest.js"></script> -->


<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );

wp_enqueue_style('route-single-post-style', get_stylesheet_directory_uri() . '/single-route-style.css');

$language = ICL_LANGUAGE_CODE;

?>


<div id="single-post-route-main-content">
    <div id="content-area" class="clearfix webmapp-grid-system">
        <?php while ( have_posts() ): the_post();
        $post_id = get_the_ID();

        // gets the promotion value from italian corrispondent if this route is in english 
        $post_id_ita = '';
        $promotion_value = '';
        $post_id_quote = '';
        $promotion_name = get_field('promotion_name',$post_id);

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

        //checks if it has promotion and creates a list of dates of promotion period
        $in_promotion_active = get_field('wm_route_in_promotion');
        $in_promotion = false;
        $promotion_dates_list = array();
        while( have_rows('model_promotion') ): the_row();
        $promotion_periods = get_sub_field('periods');
        $promotion_departure_dates = get_sub_field('departure_dates');
        foreach ( $promotion_periods as $period ) {
            $start_period = str_replace('/', '-', $period['start']);
            $stop_period = str_replace('/', '-', $period['stop']);
            $begin = new DateTime( $start_period );
            $end = new DateTime( $stop_period );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);
            foreach($daterange as $date){
                $promotion_single_date = $date->format("d-m-Y");
                array_push( $promotion_dates_list, $promotion_single_date );
            }
        }
        foreach ($promotion_departure_dates as $date){
            $single_date =  str_replace('/', '-', $date['date']);
            array_push( $promotion_dates_list, $single_date );
        }
        endwhile;
        $current_date = date("d-m-Y");
        foreach ( $promotion_dates_list as $dates_list ){
            if ( $dates_list == $current_date ){
                $in_promotion = true;
            }
        }



        //check if the route is in boat or not
        $boat_trip = get_field('trip_with_boat');
        if ($boat_trip) {
            $place = __('cabin','wm-child-verdenatura');
        } else {
            $place = __('room','wm-child-verdenatura');
        }
        ?>


            <!-- musthead -->

            <div class="page-title">
                <h1 class="txt-white"><?php the_title();?></h1>
                <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
            </div> <!--chiudo .page-title-->


                               <!--griglia-->
            <div class="webmapp-container-fluid">
                <div class="row single-post-route-row">


                    <!--Colonna destra-->

                    <div class="col-sm-12 col-md-8">
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
                        <div class="top-gallery-single-post-route">
                            <?php
                            $vn_gallery_route = get_field('wm_route_gallery');//n7webmap_track_media_gallery//wm_route_gallery
                            //print_r($vn_gallery_route);
                            if (is_array($vn_gallery_route) && ! empty($vn_gallery_route)) {
                                $vn_id_gallery_route=  array_map(function ($i) {
                                  return $i['ID'];
                                },$vn_gallery_route);
                                $stringa_id_gallery= implode (',', $vn_id_gallery_route);
                                //print_r($vn_id_gallery_route);
                                echo do_shortcode ("[wm_gallery media_ids='$stringa_id_gallery']");
                            }
                            ?>

                        </div> <!-- chiudo .top gallery-->

                        <div class="scheda-preventivo">
                            <?php
                            //echo do_shortcode('[caldepartures name="Bob"]');
                            echo do_shortcode('[vn_route_tabs]');
                            ?>
                        </div> <!--chiudo .scheda-preventivo-->


                        <?php 
                        $products = get_field('product');
                        $departure_periods = get_field('departures_periods');
                        $departure_dates = get_field('departure_dates');
                        $not_salable = get_field('wm_route_not_salable');
                        
                        if ( $not_salable === true ){
                            $hide_button = "hide-button";
                        }  else {
                                $hide_popup_contact = "hide-button";
                            }
                        ?>
                        <div class="container-button-preventivo">
                            <div class="button-preventivo <?php echo $hide_button;?>"><a id="rich-prev-desktop-corpo" target="_blank" href="http://vnquote.webmapp.it/#/<?php echo $post_id_quote.'?lang='.$language;?>">
                                        <?php //
                                        echo __('MAKE A QUOTE' ,'wm-child-verdenatura');
                                        ?>
                                    </a>
                            </div> <!--chiudo .button-preventivo -->
                            <div class="button-preventivo <?php echo $hide_popup_contact;?>"><a class="fancybox" href="#contact_form_pop">
                                        <?php //
                                        echo __('REQUEST INFORMATION' ,'wm-child-verdenatura');
                                        ?>
                                    </a>
                            </div> <!--chiudo .button-richiedi informazione -->

                        </div>
                        
                        <div class="fancybox-hidden" style="display: none;">
                            <div id="contact_form_pop"><?php echo do_shortcode('[contact-form-7 id="45093" title="Contact form 1"]');?></div>
                        </div>

                        <div class="scheda-commenti">
                            <h3><?php
                                echo __('Your experiences' ,'wm-child-verdenatura');
                                ?></h3>
                            <p class="p-ex"><?php
                                echo __('Share your experience with us or read the stories of those who traveled with us.' ,'wm-child-verdenatura');
                                ?></p>
                            <button class="button-esperienze"><?php
                                echo __('SHARE YOUR EXPERIENCE' ,'wm-child-verdenatura');
                                ?></button>

                                <script>
                                jQuery(document).ready(function() {
                                 //Faccio sparire il pulsante "Mostra"
                                 jQuery("#respond").hide();
                                 jQuery(".button-esperienze").click(function(){
                                    jQuery("#respond").toggle();
                                 });

                               })
                                </script>


                            <?php

                            if ( ( comments_open() || get_comments_number() ) && 'on' === et_get_option( 'divi_show_postcomments', 'on' ) )
                            {
                                comments_template( '', true );
                            }
                            ?>

                            <br>
                            <hr>

                        </div> <!--chiudo .scheda-commenti -->


                    </div> <!-- chiudo .col-12 .col-sm-6 .col-md-8 -->

                    <!--Colonna sinistra-->

                    <div class="col-sm-12 col-md-4">
                        <div class="box-preventivo-aside">
                            <h2 class="title-preventivo" style="color: #0f7a68;"><?php the_title();?></h2>
                            <p class="sottotitolo-preventivo"><?php
                                echo __('Reference code: ' ,'wm-child-verdenatura');
                                $n7webmapp_route_cod=get_field('n7webmapp_route_cod');
                                If ($n7webmapp_route_cod)
                                echo ($n7webmapp_route_cod);
                            ?>
                            </p>

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
                                    ?>
                                     <?php
                                    echo __( 'Duration' , 'wm-child-verdenatura' ) . "<span class='dur-txt'>" .  " $days" . __( 'days' , 'wm-child-verdenatura' ) . "/$nights" . __( 'nights' , 'wm-child-verdenatura' ) ;
                                ?>
                                    </span>

                                    <?php

                                     $vn_note_dur = get_field( 'vn_note_dur' );
                                    if ( $vn_note_dur )
                                        echo "<span class='webmapp_route_duration_notes'> ($vn_note_dur)</span>";
                                }
                                ?>
                            </div>
                            <br>
                            <?php 
                            $only_double = get_field('wm_route_only_double');
                            if ($only_double):
                            ?>
                            <div class="only-double">
                                <p> <?php echo sprintf(__('Only single and double %s is available for this trip', 'wm-child-verdenatura'), $place); ?></p>
                            </div>
                            <br>
                            <?php endif; ?>
                            <div class="departure-preventivo-aside"> <!------------ Departure / Partenze -->
                                <?php 
                                while( have_rows('departures_periods') ): the_row();
                                    $start = get_sub_field('start');
                                endwhile;       
                                if( have_rows('departures_periods') && $start): 
                                ?>
                                <span class='durata-txt'>
                                    <p class="tab-section">
                                    <?php
                                    if( have_rows('departures_periods') ){
                                    echo __('Dates:' ,'wm-child-verdenatura');
                                    } ?>
                                    </p>
                                    <p class="part-e-pre"></p>
                                </span>
                                <?php endif; ?>
                                <?php
                                    if( have_rows('departures_periods') ): ?>
                                    
                                    <div class="departure_name">
                                    </div>
                                    <div class="grid-container-period-aside">
                                    
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
                                                <p><?php echo __('From:' ,'wm-child-verdenatura').' '.$start; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="departure_stop">
                                            <?php if( $stop ): ?>
                                                <p><?php echo __('To:' ,'wm-child-verdenatura').' '.$stop; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="departure_week_days">
                                            <?php if( $week_days ): ?>
                                                <ul>
                                                    <?php if (count($week_days) == 7) { ?>
                                                        <li style="display: inline;" ><?php echo __('Every day' ,'wm-child-verdenatura'); ?></li>
                                                        <?php }else { ?>
                                                            <span><?php echo __('Each' ,'wm-child-verdenatura').' '; ?></span>
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
                                    while( have_rows('departure_dates') ): the_row(); 
                                    $date = get_sub_field('date');            
                                    endwhile;
                                    if( have_rows('departure_dates') && $date ): ?>
                                    <div class="single-departure">
                                            <p class="tab-section"><?php if (have_rows('departures_periods') && !empty($start) && have_rows('departure_dates')) { echo __('Other dates:' ,'wm-child-verdenatura'); } else{ echo __('Dates:' ,'wm-child-verdenatura');}?></p>
                                            <p class="part-e-pre"></p>
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
                                
                                    <?php endwhile; ?>
                                
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

                            <div class="specifiche-viaggio">
                                <div class="nazione">
                                    <?php
                                        the_term_image_with_name( $post_id , 'where' ) ; ?>

                                </div> <!--.nazione-->


                                    <?php


                                    // $vn_self_guided = get_field('wm_self_guided');
                                    // if( $vn_self_guided )
                                    // {
                                    //     echo "<div class=\"vn-target vn-meta-align ind-sp\">";
                                    //     echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-individuale.png">';
                                    //     echo __('Self guided' , 'wm-child-verdenatura' );
                                    //     echo "</div> <!--.vn-target-->";
                                    // }


                                    // $vn_guided = get_field('wm_guided');
                                    // if( $vn_guided )
                                    // {
                                    //     echo "<div class=\"vn-target vn-meta-align guid-sp\">";
                                    //     echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-guida.png">';
                                    //     echo __('Guided' , 'wm-child-verdenatura' );
                                    //     echo "</div> <!--.vn-target-->";
                                    // }

                                    ?>



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
                            <div class="act-tar">
                                <!-- <div class="attività-route vn-meta-align">
                                    <?php
                                    // the_term_image_with_name( $post_id , 'activity' );
                                    ?>
                                </div> -->

                                <!-- <div class="targets-route vn-meta-align"> -->
                                    <?php
                                    the_term_image_with_name( $post_id , 'activity' );
                                    the_term_image_with_name( $post_id , 'who' );
                                    ?>
                                <!-- </div> -->

                            </div> <!--.act-tar-->
                            </div> <!--- .specifiche-viaggio -->

                            <div class="prezzo-container"> <!-- prezzo start-->
                                <p class="promotion-trip">
                                    <?php
                                        
                                        if ( $promotion_value )
                                        echo __( 'Discounted trip!' , 'wm-child-verdenatura' );
                                    ?>
                                </p> 
                                <div class="prezzo">
                                <p class="prezzo-text"><?php echo __('Prices from' , 'wm-child-verdenatura'); ?></p>
                                <p><span class="cifra <?php if ( $promotion_value){ echo 'old-price';}?>"><?php
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
                                € </span></p>
                                <?php endif; ?>
                                </div> 
                            </div><!--.prezzo  end-->
                            <?php //if(function_exists('pf_show_link')){echo pf_show_link();} ?>
                            <div class="button-preventivo <?php echo $hide_button;?>">
                                <a id="rich-prev-desktop-card" target="_blank" href="http://vnquote.webmapp.it/#/<?php echo $post_id_quote.'?lang='.$language;?>">
                                    <?php //
                                    echo __('MAKE A QUOTE' ,'wm-child-verdenatura');
                                    ?>
                                </a>
                            </div>
                            <div class="button-preventivo <?php echo $hide_popup_contact;?>"><a class="fancybox" href="#contact_form_pop">
                                        <?php //
                                        echo __('REQUEST INFORMATION' ,'wm-child-verdenatura');
                                        ?>
                                    </a>
                            </div> <!--chiudo .button-richiedi informazione -->


                        </div> <!-- chiudo .box-preventivo-aside -->


                        <div class="map-material-placeholder">
                            <?php
                            $vn_immagine_mappa = get_field('vn_immagine_mappa');
                            if ( $vn_immagine_mappa )
                            {
                                $img_id = $vn_immagine_mappa['ID'];
                                $img_url = $vn_immagine_mappa['url'];
                                $img_url_medium = $vn_immagine_mappa['sizes']['medium'];
                                //$img_lrg = wp_get_attachment_image( $img_id , 'large');
                                // print_r($vn_immagine_mappa);
                                ?>
                                <div class="et_pb_module et_pb_gallery et_pb_gallery_0 et_pb_bg_layout_light  et_pb_slider et_pb_gallery_fullwidth">
                                    <div class="" data-per_page="1">
                                        <div class="et_pb_gallery_item et_pb_bg_layout_light">
                                            <div class="et_pb_gallery_image landscape">
                                                <a href="<?php echo $img_url; ?>" title="<?php echo $image['title']; ?>" caption="<?php echo $image['caption']; ?>">
                                                    <!-- <div class="template_gallery_image" style="background-image: url(<?php //echo $img_url; ?>);">
                                                    </div> -->
                                                    <img src="<?php echo $img_url; ?>" alt="" class="template_gallery_image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php
                            }
                            ?>
                        </div> <!--chiudo .map-material-placeholder -->

                        <!-- and modal popup for routes waiting for new data -->
                        <?php if ($not_salable){ ?>
                        <a id="fancybox-auto" class="fancybox" href="#work-in-progress"></a>
                        <?php } ?>
                        <div  class="fancybox-hidden" style="display: none;">
                            <div id="work-in-progress">
                                    <div id="modaldiff" class="modal open" style="z-index: 1003; display: block; opacity: 1; transform: scaleX(1); top: 10%; ">
                                    <div class="modal-content">
                                        <h3><?php echo __('Warning!' ,'wm-child-verdenatura');?></h3>
                                        <p><?php echo __('We are working on the new version of the trip.' ,'wm-child-verdenatura');?></p>
                                        <p><?php echo __('Dates and prices will be updated soon.' ,'wm-child-verdenatura');?></p>
                                    </div>
                                </div>
                            </div>
                        </div>	
                    

                        <div class="interessi">
                            <h2><?php
                                echo __('You might be interested in...' ,'wm-child-verdenatura');
                                ?></h2>

                            <div class="vn-post-interessi">
                                <?php
                                echo do_shortcode('[webmapp_anypost post_type="route" term_id="84" template="vn_route_sb" posts_count=3 rows=3 posts_per_page=3 orderby="rand"]');
                                ?>


                            </div><!-- chiudo .vn-post-interessi-->
                        </div>  <!--chiudo .interessi -->
                    </div> <!-- chiudo .col -->
                </div> <!-- chiudo .row -->
                

            </div> <!-- .webmapp-container-fluid -->

        <?php endwhile; ?>
    </div> <!--chiudo #single-post-route-main-content -->
</div> <!-- chiudo #content-area --->

<?php


get_footer();

?>
