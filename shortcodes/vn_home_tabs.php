<?php



add_shortcode( 'vn_home_tabs', 'vn_render_home_tabs_shortcode' );
function vn_render_home_tabs_shortcode( $atts ) {

    ob_start();
    ?>




<div id="tabs" class="vn-tab-home">
  <ul class="tabs-home-tab">
      <li class="in-bici"><a href="#tabs-1" style="border-right: 1px solid #ccc;  background-color: white; color: #ca0a1d; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/bicicletta.png" class="bici-img" style="width: 2.5em; vertical-align: bottom; margin-right: 20px;"> IN BICICLETTA</a></li>
      <li class="bici-barca"><a href="#tabs-2" style="border-right: 1px solid #ccc; background-color: white; color: #990066; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/bici-barca.png" class="bici-barca-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">IN BICI E BARCA</a></li>
      <li class="a-piedi"><a href="#tabs-3" style="border-right: 1px solid #ccc; background-color: white; color: #ff9933; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/piedi.png" class="piedi-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">A PIEDI</a></li>
      <li class="in-famiglia"><a href="#tabs-4" style="border-right: 1px solid #ccc;  background-color: white; color: #00cccc; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/famiglia.png" class="famiglia-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">IN FAMIGLIA</a></li>
      <li class="esplo"><a href="#tabs-5" style="border-right: 1px solid #ccc; background-color: white; color: #b06131; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/esplorazione.png" class="esplorazione-img" style="width: 2.5em;vertical-align: bottom; margin-right: 20px;">ESPLORAZIONE</a></li>
      <li class="wend"><a href="#tabs-6" style="background-color: white; color: #ffc400; font-weight: bold;"><img src="/wp-content/themes/wm-child-verdenatura/images/weekend.png" class="weekend-img" style="width: 2.3em;vertical-align: bottom; margin-right: 20px;">WEEKEND</a></li>
  </ul>

    <div id="tabs-1" class="bici-content">
        <p style="color: #666; "><img src="/wp-content/themes/wm-child-verdenatura/images/bicicletta.png" style="float: left; padding: 15px 10px 0 0;"> <h2>in bicicletta</h2>
        Le vacanze in bicicletta in hotel, agriturismi ecc. su percorsi appositamente selezionati e testati lungo piste
        ciclabili o tranquille strade secondarie. Scegliete dove, quando e con chi, al resto penseremo noi. Prenoteremo
        gli hotel, vi metteremo a disposizione le bici adatte e i road book dettagliati e trasporteremo i vostri bagagli
        da un hotel all’altro in modo che voi possiate semplicemente godere della vostra vacanza. In base alle vostre
        esigenze potete scegliere la formula di viaggio in gruppo con la guida o la formula viaggio individuale.        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="84" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-2">
      <p style="color: #666;"> <img src="/wp-content/themes/wm-child-verdenatura/images/bici-barca.png" style="float: left; padding: 15px 10px 0 0;"> <h2>in bici e barca</h2>
        Un viaggio che unisce terra e acqua, una vacanza unica dove al tour in bicicletta viene unita la navigazione in mare o lungo fiumi e canali. Di giorno ci si sposta in bicicletta ritrovando poi la barca/hotel per la cena e la notte. Tutte le barche hanno cabine con servizi (salvo alcune come specificato nei programmi) e un salone dove viene servita la cena. Alle tratte in bicicletta che si alternano i momenti di relax sul ponte della barca. E se non volete pedalare, potrete passare la giornata in barca godendovi la navigazione.
      </p>
        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="116" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-3">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/piedi.png" style="float: left; padding: 15px 10px 0 0;"> <h2> a piedi</h2>
        Viaggi al ritmo dei propri passi non solo in montagna, ma anche e soprattutto in stupendi ambienti naturali come modo alternativo, sano ed interessante, per visitare i luoghi. Potete scegliere vacanze di gruppo con una guida esperta o in completa libertà. In ogni caso avrete sempre la certezza di un hotel o un rifugio prenotati per la notte e del servizio di trasporto bagagli
        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="81" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-4">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/famiglia.png" style="float: left; padding: 15px 10px 0 0;"> <h2>in famiglia</h2>
        Viaggi pensati per le famiglie, dove la lunghezza e le caratteristiche dell’itinerario sono perfette per i bambini. Gli hotel hanno disponibilità di camere triple e quadruple e possiamo fornirvi il noleggio dei mezzi adatti per far viaggiare i più piccoli: cammellini, seggiolini, trailer ecc. Trovate i tour “speciali famiglie” in tutte le tipologie di viaggio : bici e barca, bicicletta e trekking. Se volete condividere questa vacanza con altre famiglie, potete scegliere un tour con la guida.
        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="164" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-5">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/esplorazione.png" style="float: left; padding: 15px 10px 0 0;"> <h2>esplorazione</h2>
        Le nostre guide ogni stagione vanno in avanscoperta a testare nuovi itinerari. Se avete un po’ di spirito d’adattamento e un po’ di allenamento potrete da quest’anno accompagnarli in questi viaggi. I servizi saranno per la maggior parte prenotati e organizzati ma dovrete essere pronti anche a qualche imprevisto o cambiamento di percorso. Un’occasione da non perdere per chi cerca vacanze con un pizzico in più di avventura!
        </p>

        <?php
        echo do_shortcode('[webmapp_anypost post_type="route" term_id="165" template="vnhome" posts_count=3 rows=1 posts_per_page=3 ]');
        ?>
    </div>

    <div id="tabs-6">
        <p style="color: #666;"><img src="/wp-content/themes/wm-child-verdenatura/images/weekend.png"style="float: left; padding: 15px 10px 0 0;"><h2>weekend</h2>
            Weekend e vacanze brevi a piedi e in bicicletta, pensati apposta per chi desidera inserire una parentesi slow all'interno di un viaggio lontano da casa, o per esplorare insieme alle nostre guide gli angoli nascosti del nostro bellissimo paese.
        </p>

    </div>
</div>

    <script>
        ( function($) {
            $( "#tabs" ).tabs();
        } )(jQuery);

        jQuery(function(){
            window.et_pb_smooth_scroll = () => {};
        });
    </script>


    <?php

    $html = ob_get_clean();
    return $html;
}
