<?php



add_shortcode( 'wm_gallery', 'wm_render_gallery' );
/**
 * @param $atts
 * @return string
 */
function wm_render_gallery ($atts ) {

    extract( shortcode_atts( array(
        'media_ids' => ''
    ), $atts ) );

    $images= explode (',', $media_ids);
 ob_start ();

    ?>

    <div class="slider-for">
            <?php foreach ($images as $id) {
                $image = wp_get_attachment_image_src( $id, 'large');
                echo '<div style="height: auto;">';
                echo '<div class="route-wm-gallery-image" style="background-image: url('.$image[0].');"></div>';
                echo '</div>';
            }
            ?>
    </div>

    <div class="slider-nav">
        <?php foreach ($images as $id) { 
            $image = wp_get_attachment_image_src( $id, 'thumbnail');
            echo '<div>';
            echo '<div class="route-wm-gallery-image-thumb" style="background-image: url('.$image[0].');"></div>';
            echo '</div>';
        }
        ?>
    </div>

    <script>
        (function ($) {
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                adaptiveHeight: true,
                asNavFor: '.slider-nav'
            })
                /**
                .on('setPosition', function (event, slick) {
                    slick.$slides.find('img').css('height', slick.$slideTrack.height() + 'px');
                    console.log (slick);

                })**/;
            $('.slider-nav').slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: false,
                arrows: false,
                centerMode: true,
                focusOnSelect: true,
                autoplay: true
            });
           
        } )(jQuery);

        

    </script>



    <?php

    $html = ob_get_clean();
    return $html;
}
