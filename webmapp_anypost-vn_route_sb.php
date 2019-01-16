<?php


global $wm_anypost_bootstrap_col_type,
       $wm_anypost_global_taxonomies,
       $wm_anypost_template,
       $wm_anypost_post_type;

$title_link = get_the_permalink();
$get_the_post_thumbanil = get_the_post_thumbnail_url(get_the_ID() ,'full');
$current_post_type = get_post_type();


?>

<div class="col-sm-12 col-md-<?php echo $wm_anypost_bootstrap_col_type?> webmapp_shortcode_any_post post_type_<?php echo $wm_anypost_post_type?>">

    <div class="webmapp_post-title">
        <h2>
            <?php the_title() ?>
        </h2>
    </div>

    <div class="webmapp_route_duration">
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

    <div class="webmapp_post-featured-img">
        <?php
        echo "<a href='$title_link' title=\"".get_the_title()."\">";

        $own_made = get_field( 'wm_fdn' );
        if ( $own_made )
            echo "<img src='/wp-content/themes/wm-child-verdenatura/images/logo-omino.jpg' alt='Fatto da noi' id='fdn-card'>";

        $new = get_field( 'vn_new' );
        if( $new )
            echo "<img src='/wp-content/themes/wm-child-verdenatura/images/new.png' alt='Novità'>";


        ?>

        <figure class="webmapp_post_image" style="background-image: url('<?php echo $get_the_post_thumbanil; ?>')">
        </figure>



        <?php
        echo "</a>";
        ?>
    </div>
    <div class="webmapp_post_meta">

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


            <?php
            $numero = get_field('vn_diff');

            if ( $numero )
            {
                ?>
        <div class="livello">
            <img src="<?php the_calcola_url( $numero ) ?>">
            <p>Livello</p>
        </div> <!--.livello-->
            <?php
            }
            ?>

        <div class="attività-route">
            <?php
            the_term_image_with_name( $post_id , 'activity' );
            ?>
        </div>

    </div>



</div>
