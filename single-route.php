

<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );


?>


<div id="single-post-route-main-content">
    <div id="content-area" class="clearfix webmapp-grid-system">
        <?php while ( have_posts() ): the_post();
        $post_id = get_the_ID();

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
                        <div class="top-gallery-single-post-route">
                            <?php
                            $vn_gallery_route=get_field ('n7webmap_track_media_gallery');
                            if (is_array($vn_gallery_route) && ! empty($vn_gallery_route)) {
                                $vn_id_gallery_route=  array_map(function ($i) {
                                  return $i ['ID'];
                                },$vn_gallery_route);
                                $stringa_id_gallery= implode (',', $vn_id_gallery_route);
                                echo do_shortcode ("[wm_gallery media_ids='$stringa_id_gallery']");
                            }
                            ?>

                        </div> <!-- chiudo .top gallery-->

                        <div class="scheda-preventivo">
                            <?php
                            echo do_shortcode('[vn_route_tabs]');
                            ?>
                        </div> <!--chiudo .scheda-preventivo-->

                        <div class="button-preventivo"><button>Richiedi preventivo</button>
                        </div> <!--chiudo .button-preventivo -->

                        <div class="scheda-commenti">
                            <h3>Racconti di viaggio</h3>
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
                            <h1 class="title-preventivo" style="color: #0f7a68;"><?php the_title();?></h1>
                            <p class="sottotitolo-preventivo">Codice viaggio:
                            <?php
                                $n7webmapp_route_cod=get_field('n7webmapp_route_cod');
                                If ($n7webmapp_route_cod)
                                echo ($n7webmapp_route_cod);
                            ?>
                            </p>


                            <p class="main-content-preventivo">

                            <?php
                                $vn_desc_min = get_field('vn_desc_min');
                                if ( $vn_desc_min )
                                echo $vn_desc_min;
                            ?>
                            </p>

                            <p class="durata-preventivo">Durata:
                            <span class="durata-content">
                                <?php
                                $vn_durata = get_field('vn_durata');
                                if ($vn_durata)
                                    echo $vn_durata;
                                ?> giorni </span>
                            (

                                <?php
                                $vn_note_dur = get_field('vn_note_dur');
                                if ( $vn_note_dur)
                                    echo $vn_note_dur;
                                ?>

                                )</p>
                            <br>


                            <span class="partenze_preventivo">Partenze:
                                <span class="content-partenze">
                                <?php
                                $vn_part_sum = get_field('vn_part_sum');
                                if ($vn_part_sum)
                                    echo $vn_part_sum;

                                ?>
                                </span>
                            </span>

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
                                        the_term_image_with_name( $post_id , 'where' );
                                    ?>
                                </div> <!--.nazione-->

                                <div class="vn-target">
                                    <?php
                                    the_term_image_with_name( $post_id , 'who' );
                                    ?>
                                </div> <!--.vn-target-->

                                <div class="livello">
                                <?php
                                $numero = get_field('vn_diff');

                                ?>   <img src="<?php the_calcola_url( $numero ) ?>">
                                    <p>Livello</p>
                                </div> <!--.livello-->

                                <div class="attività-route">
                                    <?php
                                    the_term_image_with_name( $post_id , 'activity' );
                                    ?>
                                </div>
                            </div> <!--- .specifiche-viaggio -->

                            <div class="prezzo">
                                <?php
                                echo __('From', 'wm-child-verdenatura');
                                ?>

                                <span class="cifra"><?php
                                $vn_prezzo = get_field('vn_prezzo');
                                if ($vn_prezzo)
                                echo $vn_prezzo;
                                ?>
                                € </span>
                            </div> <!--.prezzo -->

                            <div class="richiedi-preventivo">
                                <button>
                                    Richiedi preventivo
                                </button>
                            </div>


                        </div> <!-- chiudo .box-preventivo-aside -->


                        <div class="map-material-placeholder">
                            <?php
                            $vn_immagine_mappa = get_field('vn_immagine_mappa');
                            if ( $vn_immagine_mappa )
                            {
                                $img_id = $vn_immagine_mappa['ID'];
                                echo wp_get_attachment_image( $img_id , 'large');
                            }
                            ?>
                        </div> <!--chiudo .map-material-placeholder -->




                        <div class="interessi">
                            <h1>Può interessarti...</h1>

                            <div class="vn-post-interessi">

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
