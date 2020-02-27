
<script src="http://code.jquery.com/jquery-latest.js"></script>

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
        $featured_image = get_the_post_thumbnail_url();

    
        ?>


            <!-- musthead -->

            <div class="page-title">
                <h1 class="txt-white"><?php the_title();?></h1>
                <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
            </div> <!--chiudo .page-title-->

                               <!--griglia-->
            <div class="webmapp-container-fluid">
                <div class="row single-post-route-row">


                    <!--Colonna sinistra-->

                    <div class="col-sm-12 col-md-8 single-promotion-main-container">
                        <div class="box-price">
                                <div class="promotion-prezzo-container"> <!-- prezzo start-->
                                    
                                    <div class="prezzo">
                                    <?php echo __('Discount:', 'wm-child-verdenatura'); ?>
                                    <span class="cifra">
                                        <?php
                                        $vn_prezzo = get_field('value');
                                        echo $vn_prezzo;
                                        ?>
                                    € </span>
                                    </div> 
                                </div><!--.prezzo  end-->

                        </div> <!-- chiudo .box-preventivo-aside -->
                        <div class="departure-preventivo-aside"> <!------------ Departure / Partenze -->
                            <?php 
                            while( have_rows('periods') ): the_row();
                                $start = get_sub_field('start_date');
                            endwhile;       
                            if( have_rows('periods') && $start): 
                            ?>
                            <span class='durata-txt'>
                                <p class="tab-section">
                                <?php
                                if( have_rows('periods') ){
                                echo __('Promotion dates:' ,'wm-child-verdenatura');
                                } ?>
                                </p>
                                <p class="part-e-pre"></p>
                            </span>
                            <?php endif; ?>
                            <?php
                                if( have_rows('periods') ): ?>
                                
                                <div class="departure_name">
                                </div>
                                <div class="grid-container-period-aside">
                                
                                    <?php while( have_rows('periods') ): the_row(); 
                            
                                    // vars
                                    $name = get_sub_field('name');
                                    $start = get_sub_field('start_date');
                                    $stop = get_sub_field('stop_date');
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
                            
                                <?php endwhile; ?>
                            
                                </div>
                            
                                <?php endif; ?>
                                
                                <?php // ---------- single departures ----------------//
                                while( have_rows('dates') ): the_row(); 
                                $date = get_sub_field('date');            
                                endwhile;
                                if( have_rows('dates') && $date ): ?>
                                <div class="single-departure">
                                        <p class="tab-section"><?php if (have_rows('periods') && !empty($start) && have_rows('dates')) { echo __('Other promotion dates:' ,'wm-child-verdenatura'); } else{ echo __('Promotion dates:' ,'wm-child-verdenatura');}?></p>
                                        <p class="part-e-pre"></p>
                                </div>
                                <div class="grid-container-single">
                                
                                <?php while( have_rows('dates') ): the_row(); 
                            
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

                        <div class="container-promotion">
                            <p class="desc-route">
                                <?php
                                $vn_desc = get_the_content();
                                if ( $vn_desc )
                                    echo $vn_desc;
                                ?>
                            </p>
                        </div> <!--chiudo .scheda-preventivo-->

                    </div> <!-- chiudo .col-12 .col-sm-6 .col-md-8 -->


                    <!--Colonna destra-->

                    <div class="col-sm-12 col-md-4">
                        
                        <div class="promotion-featured-image">
                            <?php 
                            if ($featured_image) :
                            ?>
                            <div class="featured-image-img" style="background-image: url('<?php echo $featured_image; ?>')">
                            </div>
                            
                            <?php endif;?>
                        </div>

                    </div> <!-- chiudo .col -->

                </div> <!-- chiudo .row -->
                <div class="row"> <!--row anypost-->
                    <div class="col-sm-12 col-md-12 anypost-promotion-row">
                        <?php // anypost for all the routes in promotion
                        $apply_to_all_routes = get_field('all_routes'); 
                        if ( $apply_to_all_routes):
                        ?>
                        <div class="apply-to-all-routes">
                            <h2 class="promotion-all-routes">
                                <?php echo __('This promotion is applied to all trips','wm-child-verdenatura')?>
                            </h2>
                        </div>
                        <?php else : 
                        $route_list = get_field('routes',$post_id);
                        $routes_count = count($route_list);
                        $routes_rows = $routes_count/3;
                        ?>
                        <div class="apply-to-selected-routes">
                            <h2 class="promotion-all-routes">
                                <?php echo __('This promotion is for the following trips','wm-child-verdenatura')?>
                            </h2>
                            <?php
                                echo do_shortcode('[webmapp_anypost post_type="route" template="vnhome" post_ids="'.implode(",",$route_list).'" posts_count="'.$routes_count.'" rows="'.ceil($routes_rows).'" posts_per_page="'.$routes_count.'" ]');
                            ?> 
                        </div><!-- chiudo anypost per le routes  -->
                        <?php endif;?>
                    </div>
                </div><!-- chiudo .row  anypost-->
                
            </div> <!-- .webmapp-container-fluid -->

        <?php endwhile; ?>
    </div> <!--chiudo #single-post-route-main-content -->
</div> <!-- chiudo #content-area --->

<?php


get_footer();

?>
