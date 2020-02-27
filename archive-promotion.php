<?php get_header(); ?>

<div id="main-content" class="archive-route-page">
    <div class="page-title"> 
    <h1 class="txt-white" id="title-archive"><?php echo __('Promotions','wm-child-verdenatura');?></h1>
        <img class="single-route-tree-spring" alt="tree-spring" src="/wp-content/themes/wm-child-verdenatura/images/tree_spring.png">
    </div>
	<div class="container">
		<div id="content-area" class="clearfix">
            <div id="left-area" class="facetwp-template">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
				$post_format = et_pb_post_format(); 
				$post_id = get_the_ID();
				?>
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
								<?php endif; ?>
								</p>
								<br>
								<div class="prezzo"> <!-- promotion value -->
									<?php echo __('Discount:', 'wm-child-verdenatura'); ?>
									<span class="cifra">
										<?php
										$vn_prezzo = get_field('value');
										echo $vn_prezzo;
										?>
									€ </span>
								</div> 
							</div> <!--route-infos sx--->

					</div> <!-- .row-01--->

						<div class="row-02">
						
							<span class="det-btt  dx ">
								<button class="details-butt"> <a href="<?php
									the_permalink(); ?>">
										<?php
										echo __('DETAILS','wm-child-verdenatura');
										?>
										</a>
								</button>
							</span>

						</div> <!-- .row-02--->


					</div> <!-- .scheda-route --->



				</article> <!-- .et_pb_post -->

		<?php
				endwhile;
				echo do_shortcode ('[facetwp pager="true"]');
			else :
				get_template_part( 'includes/no-results', 'index' );
			endif;
		?>

		</div> <!-- #left-area -->


			<?php
				if ( shortcode_exists('facetwp') ) :
			?>
					<div id="sidebar" class="h-facet" >
						<h2 class="filtra-viaggi"><?php echo __('Filter tours by','wm-child-verdenatura').'...';?></h2>
					</div> <!-- chiudo .h-facet -->
					<div id="sidebar" class="side-facet">
						<?php
							
								echo do_shortcode("[vn_home_search]");
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
