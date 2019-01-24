<?php get_header(); ?>

<div id="main-content" class="archive-route-page">
    <div class="page-title">
        <h1 class="txt-white" id="title-archive">Viaggi</h1>
        <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
    </div>
	<div class="container">
		<div id="content-area" class="clearfix">
            <div id="left-area" class="facetwp-template">

                <?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					$post_format = et_pb_post_format(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>

				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
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
						elseif ( ! in_array( $post_format, array( 'gallery' ) ) && 'on' === et_get_option( 'divi_thumbnails_index', 'on' ) && '' !== $thumb ) : ?>

                        <div class="entry-featured-image-url" style="background-image: url(<?php the_post_thumbnail_url('large'); ?>);" >
                        </div>
                            <div class="gallery-fdn">
                                <?php
                                $vn_formula_fdn = get_field('wm_fdn');
                                if( $vn_formula_fdn )
                                {
                                    echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-omino.jpg" class="fdn-card">';
                                }

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
                                    $vn_desc_min = get_field('vn_desc_min');
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
                    </div> <!-- chiudo .durata-preventivo -->
                            <br>
                            <p class='durata-txt'>
                        <?php
                        echo __('Departures: ' ,'wm-child-verdenatura');?>
                    </p>
                            <div class="content-partenze">
                        <?php
                        $vn_part_sum = get_field('vn_part_sum');
                        if ($vn_part_sum)
                            echo $vn_part_sum;
                        ?>
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
                    $vn_formula_fdn = get_field('wm_fdn');
                    if( $vn_formula_fdn )
                    {
                        echo "<div class=\"vn-target vn-meta-align\">";
                        echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-omino.jpg">';
                        echo __('Made by us' , 'wm-child-verdenatura' );
                        echo "</div> <!--.vn-target-->";
                    }


                    $vn_self_guided = get_field('wm_self_guided');
                    if( $vn_self_guided )
                    {
                        echo "<div class=\"vn-target vn-meta-align\">";
                        echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-individuale.png">';
                        echo __('Self guided' , 'wm-child-verdenatura' );
                        echo "</div> <!--.vn-target-->";
                    }


                    $vn_guided = get_field('wm_guided');
                    if( $vn_guided )
                    {
                        echo "<div class=\"vn-target vn-meta-align\">";
                        echo '<img src="/wp-content/themes/wm-child-verdenatura/images/logo-guida.png">';
                        echo __('Guided' , 'wm-child-verdenatura' );
                        echo "</div> <!--.vn-target-->";
                    }

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
                            <img src="<?php the_calcola_url( $numero ) ?>">
                            <p> <?php __('Level' ,'wm-child-verdenatura');?></p>
                        </div> <!--.livello-->
                        <?php
                    }
                    ?>


                            </div> <!-- .icone-scheda-archive dx--->
                        </div> <!-- .row-01--->

                            <div class="row-02">
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
                                </div>
                                <span class="det-btt  dx ">
                                 <button class="details-butt"> <a href="<?php
                                     the_permalink(); ?>">
                                        <?php
                                        echo __('DETAILS' ,'wm-child-verdenatura');
                                        ?>
                                         </a>
                                    </button>
                                        </span>

                            </div> <!-- .row-02--->


                        </div> <!-- .scheda-route --->



                    </article> <!-- .et_pb_post -->

			<?php
					endwhile;

					if ( function_exists( 'wp_pagenavi' ) )
						wp_pagenavi();
					else
						get_template_part( 'includes/navigation', 'index' );
				else :
					get_template_part( 'includes/no-results', 'index' );
				endif;
			?>

			</div> <!-- #left-area -->


                <?php
                    if ( shortcode_exists('facetwp') ) :
                ?>
                            <div id="sidebar" class="h-facet" >
                            <h2 class="filtra-viaggi">Filtra viaggi per...</h2>
                            </div> <!-- chiudo .h-facet -->
                        <div id="sidebar" class="side-facet">

                        <?php

                            $facets = array(
                                    'viaggio_con_guida',
                                    'formula',
                                    'targets',
                                    'tipologia',
                                    'places_to_go',
                                    'durata',
                                    'seasons',
                                    'themes'
                            );
                            foreach ( $facets as $facet )
                            {
                                echo do_shortcode("[facetwp facet='$facet' title='$label']");
                            }

                            ?>
                        </div>
                <?php
                    endif;
                    ?>

		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php

get_footer();
