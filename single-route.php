

<?php

get_header();

$show_default_title = get_post_meta( get_the_ID(), '_et_pb_show_title', true );

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );


?>


    <div id="single-post-route-main-content">
        <div id="content-area" class="clearfix">

            <!-- musthead -->

            <div class="page-title"">
                <h1 class="txt-white">Titolo pagina</h1>
                <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
            </div> <!--chiudo .page-title-->

        <!--griglia-->

            <div class="row single-post-route-row">

                <!--Colonna destra-->

                <div class="col-12 col-sm-6 col-md-8">
                    <div class="top-gallery-single-post-route">
                    <img src="/wp-content/themes/wm-child-verdenatura/images/verde-natura-viaggi-in-bicicletta-offerta-fedelta-747x560.jpg">
                    </div> <!-- chiudo .top gallery-->

                    <div class="scheda-preventivo">
                        <h2>
                            Viaggio in gruppo internazionale con guida parlante italiano/inglese
                        </h2>
                        <hr>


                            <p>Due capitali europee, quattro nazioni attraversate, un cuore romantico e i colori verde e blu a fare da filo conduttore. Dal verde intenso della campagna inglese a quello vivace dei pascoli fiamminghi e variopinto dei frutteti olandesi. Il blu a rappresentare l’onnipresenza dell’acqua; dal Tamigi al Mare del Nord e i canali d’Olanda.


                            In partenza da Greenwich, calmo e modernissimo quartiere di Londra, pedaleremo attraverso la Contea del Kent, conosciuta anche come Il giardino d’Inghilterra per i suoi tanti e ricchi frutteti.

                            Dalle bianche scogliere di Dover ci imbarcheremo poi per attraversare il Canale della Manica e approdare a Dunkerque, in terra francese. Ad attenderci, le Fiandre e la romantica Bruges, che ci ospiterà per una magica notte.

                            Il Belgio è anche la patria del cioccolato, dei waffel e della birra: non dimenticate di assaggiare, anche questo fa parte del viaggio!

                            L’elegante Ostenda e il Mare del Nord ci regaleranno scorci indimenticabili, prima di entrare in Olanda, terra strappata alle acque, connubio di terra, fiumi e canali, patria degli zoccoli in legno e dei mulini a vento che diede i natali a immensi artisti come Rembrandt e Van Gogh.


                            Che dire di più? Non resta che partire per questo incredibile viaggio che saprà farvi riscoprire il gusto delle esplorazioni e regalarvi emozioni indimenticabili!
                        </p>
                    </div> <!--chiudo .scheda-preventivo-->

                    <div class="button-preventivo"><button>Richiedi preventivo</button>
                    </div> <!--chiudo .button-preventivo -->

                    <div class="scheda-commenti">
                        <h2>Racconti di viaggio</h2>
                        <p>Condividi la tua esperienza o leggi quella di coloro che hanno già viaggiato con noi.</p>
                        <button class="button-esperienze">Raccontaci la tua esperienza</button>
                        <hr>

                    </div> <!--chiudo .scheda-commenti -->


                </div> <!-- chiudo .col-12 .col-sm-6 .col-md-8 -->

                <!--Colonna sinistra-->

                <div class="col-6 col-md-4">
                    <div class="box-preventivo-aside">
                        <h1 class="title-preventivo" style="color: #0f7a68;">DA LONDRA AD AMSTERDAM IN BICICLETTA</h1>
                        <p class="sottotitolo-preventivo">Codice viaggio: G277</p>
                        <hr>
                        <p class="main-content-preventivo">
                            Due capitali europee, quattro paesi attraversati, una tale varietà di paesaggi, cibo e tradizioni da lasciavi a bocca aperta.
                        Durata: 8 giorni/7 notti (6 giorni di bicicletta)

                            Partenze:
                            28/07; 11/08/2019

                            Viaggio in gruppo internazionale con guida parlante italiano/inglese
                        </p>
                    </div> <!-- chiudo .box-preventivo-aside -->


                    <div class="map-material-placeholder">
                            <img class="materialboxed initialized" width="500" src="https://www.verde-natura.it/wpsite/wp-content/uploads/g277-da-londra-ad-amsterdam-in-bicicletta-mappa-percorso.jpg">
                        </div> <!--chiudo .map-material-placeholder -->

                        <div class="social-bar">
                            social 1 social2 social 3 social 4
                        </div>


                        <div class="interessi">

                            <h1>Può interessarti...</h1>
                            <hr>
                            <h1> DA LONDRA AD AMSTERDAM IN BICI
                        Durata: 8 giorni/7 notti(6 giorni di bicicletta)
                            </h1>
                            <p>DA LONDRA AD AMSTERDAM IN BICI
                                Durata: 8 giorni/7 notti(6 giorni di bicicletta)</p>
                            <img src="/wp-content/themes/wm-child-verdenatura/images/L277-Copia-di-1.g277-da-londra-ad-amsterdam-in-bicicletta-34-amsterdam-houses-650x400.jpg">
                            <h1>Può interessarti...
                                DA LONDRA AD AMSTERDAM IN BICI
                                Durata: 8 giorni/7 notti(6 giorni di bicicletta)
                            </h1>
                            <p>DA LONDRA AD AMSTERDAM IN BICI
                                Durata: 8 giorni/7 notti(6 giorni di bicicletta)</p>
                            <img src="/wp-content/themes/wm-child-verdenatura/images/L277-Copia-di-1.g277-da-londra-ad-amsterdam-in-bicicletta-34-amsterdam-houses-650x400.jpg">
                            <h1>Può interessarti...</h1>
                            <hr>
                            <h1> DA LONDRA AD AMSTERDAM IN BICI
                                Durata: 8 giorni/7 notti(6 giorni di bicicletta)
                            </h1>
                            <img src="/wp-content/themes/wm-child-verdenatura/images/L277-Copia-di-1.g277-da-londra-ad-amsterdam-in-bicicletta-34-amsterdam-houses-650x400.jpg">
                        </div>  <!--chiudo .interessi -->
                </div> <!-- chiudo .col -->
            </div> <!-- chiudo .row -->











<?php
        if ( et_builder_is_product_tour_enabled() ):
            // load fullwidth page in Product Tour mode
            while ( have_posts() ): the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
                    <div class="entry-content">
                        <?php
                        the_content();
                        ?>
                    </div> <!-- .entry-content -->

                </article> <!-- .et_pb_post -->

            <?php endwhile;
        else:
            ?>
            <div class="container">
                </div> <!-- #content-area -->
            </div> <!-- .container -->
        <?php endif; ?>
    </div> <!-- #main-content -->







<?php
get_footer();
