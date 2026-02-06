<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Enqueue scripts and styles properly
function tml_enqueue_scripts() {
	if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
		wp_enqueue_script( 'jquery' );
	}
	if ( ! wp_script_is( 'tml-owl-js', 'enqueued' ) ) {
		wp_enqueue_script( 'tml-owl-js', TML_PLUGIN_URL . 'assets/js/owl.carousel.min.js', array( 'jquery' ), '1.0', true );
	}
	if ( ! wp_style_is( 'tml-bootstrap-css', 'enqueued' ) ) {
		wp_enqueue_style( 'tml-bootstrap-css', TML_PLUGIN_URL . 'assets/css/bootstrap.css' );
	}
	if ( ! wp_style_is( 'tml-font-awesome-css', 'enqueued' ) ) {
		wp_enqueue_style( 'tml-font-awesome-css', TML_PLUGIN_URL . 'assets/css/font-awesome.css' );
	}
	if ( ! wp_style_is( 'tml-owl-carousel-css', 'enqueued' ) ) {
		wp_enqueue_style( 'tml-owl-carousel-css', TML_PLUGIN_URL . 'assets/css/owl.carousel.min.css' );
	}
	if ( ! wp_style_is( 'tml-owl-theme-css', 'enqueued' ) ) {
		wp_enqueue_style( 'tml-owl-theme-css', TML_PLUGIN_URL . 'assets/css/owl.theme.min.css' );
	}
	if ( ! wp_style_is( 'tml-owl-transitions-css', 'enqueued' ) ) {
		wp_enqueue_style( 'tml-owl-transitions-css', TML_PLUGIN_URL . 'assets/css/owl.transitions.css' );
	}
}
add_action( 'wp_enqueue_scripts', 'tml_enqueue_scripts' );

add_shortcode( 'TML', 'testimonial_shortcode' );
function testimonial_shortcode( $post_id ) {
	// Make sure scripts are enqueued
	tml_enqueue_scripts();

	ob_start();

	// owl settings
	$testimonial_settings = get_option( 'testimonial_settings' );
	if ( isset( $testimonial_settings['testimonial_carousel_design'] ) ) {
		$testimonial_carousel_design = $testimonial_settings['testimonial_carousel_design'];
	} else {
		$testimonial_carousel_design = 'template1';
	}
	if ( isset( $testimonial_settings['carousal_effect'] ) ) {
		$carousal_effect = $testimonial_settings['carousal_effect'];
	} else {
		$carousal_effect = 'none';
	}
	if ( isset( $testimonial_settings['auto_play_carousel'] ) ) {
		$auto_play_carousel = $testimonial_settings['auto_play_carousel'];
	} else {
		$auto_play_carousel = 'true';
	}
	if ( isset( $testimonial_settings['title_color'] ) ) {
		$title_color = $testimonial_settings['title_color'];
	} else {
		$title_color = 'black';
	}
	if ( isset( $testimonial_settings['description_color'] ) ) {
		$description_color = $testimonial_settings['description_color'];
	} else {
		$description_color = 'black';
	}
	if ( isset( $testimonial_settings['designation_color'] ) ) {
		$designation_color = $testimonial_settings['designation_color'];
	} else {
		$designation_color = 'black';
	}
	if ( isset( $testimonial_settings['pagination11'] ) ) {
		$pagination11 = $testimonial_settings['pagination11'];
	} else {
		$pagination11 = 'false';
	}
	if ( isset( $testimonial_settings['star_rating_color'] ) ) {
		$star_rating_color = $testimonial_settings['star_rating_color'];
	} else {
		$star_rating_color = '#ffd700';
	}
	if ( isset( $testimonial_settings['enable_box_shadow'] ) ) {
		$enable_box_shadow = $testimonial_settings['enable_box_shadow'];
	} else {
		$enable_box_shadow = 'yes';
	}
	if ( isset( $testimonial_settings['border_radius'] ) ) {
		$border_radius = $testimonial_settings['border_radius'];
	} else {
		$border_radius = '10';
	}
	if ( isset( $testimonial_settings['image_shape'] ) ) {
		$image_shape = $testimonial_settings['image_shape'];
	} else {
		$image_shape = 'circle';
	}
	if ( isset( $testimonial_settings['hover_effect'] ) ) {
		$hover_effect = $testimonial_settings['hover_effect'];
	} else {
		$hover_effect = 'lift';
	}
	if ( isset( $testimonial_settings['font_size'] ) ) {
		$font_size = $testimonial_settings['font_size'];
	} else {
		$font_size = '16';
	}
	if ( isset( $testimonial_settings['maker_custom_css'] ) ) {
		$maker_custom_css = $testimonial_settings['maker_custom_css'];
	} else {
		$maker_custom_css = '';
	}
	if ( isset( $testimonial_settings['testimonial_column_layout'] ) ) {
		$testimonial_column_layout = $testimonial_settings['testimonial_column_layout'];
	} else {
		$testimonial_column_layout = '1';
	}

	?>
	<style>
		.testimonial-title	{
			color: <?php echo esc_html( $title_color ); ?>;
		}
		.description	{
			color: <?php echo esc_html( $description_color ); ?>;
			font-size: <?php echo esc_html( $font_size ); ?>px;
		}
		 .testimonial-designation	{
			color: <?php echo esc_html( $designation_color ); ?>;
		}

		/* Star Rating Color */
		.testimonial-rating .fa-star {
			color: <?php echo esc_html( $star_rating_color ); ?>;
		}

		/* Box Shadow */
		<?php if ( $enable_box_shadow == 'yes' ) { ?>
		.testimonial {
			box-shadow: 0 5px 20px rgba(0,0,0,0.1);
		}
		<?php } ?>

		/* Border Radius */
		.testimonial {
			border-radius: <?php echo esc_html( $border_radius ); ?>px;
		}

		/* Image Shape */
		<?php if ( $image_shape == 'circle' ) { ?>
		.testimonial .pic img {
			border-radius: 50%;
		}
		<?php } elseif ( $image_shape == 'square' ) { ?>
		.testimonial .pic img {
			border-radius: 0;
		}
		<?php } elseif ( $image_shape == 'rounded' ) { ?>
		.testimonial .pic img {
			border-radius: 15px;
		}
		<?php } ?>

		/* Hover Effects */
		<?php if ( $hover_effect == 'lift' ) { ?>
		.testimonial {
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}
		.testimonial:hover {
			transform: translateY(-10px);
			box-shadow: 0 15px 40px rgba(0,0,0,0.15);
		}
		<?php } elseif ( $hover_effect == 'scale' ) { ?>
		.testimonial {
			transition: transform 0.3s ease;
		}
		.testimonial:hover {
			transform: scale(1.05);
		}
		<?php } elseif ( $hover_effect == 'shadow' ) { ?>
		.testimonial {
			transition: box-shadow 0.3s ease;
		}
		.testimonial:hover {
			box-shadow: 0 20px 50px rgba(0,0,0,0.2);
		}
		<?php } elseif ( $hover_effect == 'glow' ) { ?>
		.testimonial {
			transition: box-shadow 0.3s ease;
		}
		.testimonial:hover {
			box-shadow: 0 0 30px rgba(102, 126, 234, 0.6);
		}
		<?php } ?>

		<?php echo $maker_custom_css; ?>
	</style>
	<?php
	// fetch all testimonials
	$all_testimonial  = array(
		'post_type' => 'testimonial-maker',
		'orderby'   => 'ASC',
	);
	$testimonial_loop = new WP_Query( $all_testimonial );

	if ( $testimonial_loop->have_posts() ) {
		// Enqueue template-specific CSS based on selected design
		if ( $testimonial_carousel_design == 'template1' ) {
			wp_enqueue_style( 'tml-owl-t1-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t1.css' );
		} elseif ( $testimonial_carousel_design == 'template2' ) {
			wp_enqueue_style( 'tml-owl-t2-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t2.css' );
		} elseif ( $testimonial_carousel_design == 'template3' ) {
			wp_enqueue_style( 'tml-owl-t3-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t3.css' );
		} elseif ( $testimonial_carousel_design == 'template4' ) {
			wp_enqueue_style( 'tml-owl-t4-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t4.css' );
		} elseif ( $testimonial_carousel_design == 'template5' ) {
			wp_enqueue_style( 'tml-owl-template5-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t7.css' );
		} elseif ( $testimonial_carousel_design == 'template6' ) {
			wp_enqueue_style( 'tml-owl-template6-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t8.css' );
		} elseif ( $testimonial_carousel_design == 'template7' ) {
			wp_enqueue_style( 'tml-owl-template7-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t9.css' );
		} elseif ( $testimonial_carousel_design == 'template8' ) {
			wp_enqueue_style( 'tml-owl-template8-css', TML_PLUGIN_URL . 'assets/css/owl-carousal/owl-t10.css' );
		}
		?>

		<div class="col-sm-12">
			<div id="testimonial-slider" class="owl-carousel">
				<?php
				while ( $testimonial_loop->have_posts() ) :
					$testimonial_loop->the_post();
					$testimonial_post_id       = get_the_ID();
					$testimonial_post_settings = get_post_meta( get_the_ID(), 'awl_testimonial' . get_the_ID(), true );
					$website_link              = isset( $testimonial_post_settings['website_link'] ) ? $testimonial_post_settings['website_link'] : '';
					$designation               = isset( $testimonial_post_settings['designation'] ) ? $testimonial_post_settings['designation'] : '';
					$star_rating               = isset( $testimonial_post_settings['star_rating'] ) ? $testimonial_post_settings['star_rating'] : '5';
					$video_url                 = isset( $testimonial_post_settings['video_url'] ) ? $testimonial_post_settings['video_url'] : '';

					// get testimonial data
					$t_text           = get_the_content();
					$t_website_url    = $website_link;
					$t_designation    = $designation;
					$t_star_rating    = $star_rating;
					$t_video_url      = $video_url;
					$t_fe_image_id    = get_post_thumbnail_id( $testimonial_post_id ); // featured image id
					$t_fe_image_thumb = wp_get_attachment_image_src( $t_fe_image_id, 'thumbnail', true );
					?>
					
					<?php if ( $testimonial_carousel_design == 'template1' ) { ?>
							<div class="testimonial">
								<div class="testimonial-content">
									<div class="description"><?php echo esc_html( ucwords( $t_text ) ); ?></div>
									<div class="pic">
										<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>">
									</div>
									<?php if ( $t_star_rating > 0 ) { ?>
									<div class="testimonial-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
											<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
										<?php } ?>
									</div>
									<?php } ?>
									<h3 class="testimonial-title"><?php the_title(); ?></h3>
									<p class="testimonial-designation"><?php echo esc_html( ucwords( $t_designation ) ); ?></p>
									<?php if ( $t_website_url ) { ?>
									<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
									<?php } ?>
								</div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template2' ) { ?>
							<div class="testimonial">
								<div class="pic">
									<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>">
								</div>
								<div class="testimonial-content">
									<div class="description"><?php echo esc_html( ucwords( $t_text ) ); ?></div>
									<?php if ( $t_star_rating > 0 ) { ?>
									<div class="testimonial-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
											<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
										<?php } ?>
									</div>
									<?php } ?>
									<h3 class="testimonial-title"><?php the_title(); ?></h3>
									<p class="testimonial-designation"><?php echo esc_html( ucwords( $t_designation ) ); ?></p>
									<?php if ( $t_website_url ) { ?>
									<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
									<?php } ?>
								</div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template3' ) { ?>
							<div class="testimonial">
								<div class="testimonial-content">
									<div class="description"><?php echo esc_html( ucwords( $t_text ) ); ?></div>
									<div class="pic">
										<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>">
									</div>
									<?php if ( $t_star_rating > 0 ) { ?>
									<div class="testimonial-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
											<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
										<?php } ?>
									</div>
									<?php } ?>
									<h4 class="testimonial-title"><?php the_title(); ?></h4>
									<p class="testimonial-designation"><?php echo esc_html( ucwords( $t_designation ) ); ?></p>
									<?php if ( $t_website_url ) { ?>
									<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
									<?php } ?>
								</div>
							</div>
							
					<?php } elseif ( $testimonial_carousel_design == 'template4' ) { ?>
							<div class="testimonial">
								<div class="pic">
									<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>">
								</div>
								<div class="testimonial-content">
									<h3 class="testimonial-title"><?php the_title(); ?>
									<small class="testimonial-designation"><?php echo esc_html( ucwords( $t_designation ) ); ?></small>
									</h3>
									<?php if ( $t_website_url ) { ?>
									<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
									<?php } ?>
									<?php if ( $t_star_rating > 0 ) { ?>
									<div class="testimonial-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
											<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
										<?php } ?>
									</div>
									<?php } ?>
									<div class="description"><?php echo esc_html( ucwords( $t_text ) ); ?></div>
								</div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template5' ) { ?>
							<div class="testimonial">
								<div class="pic">
									<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>" alt="<?php the_title(); ?>">
								</div>
								<h3 class="testimonial-title">
									<?php the_title(); ?>
									<span class="testimonial-verified"><i class="fa fa-check"></i> Verified</span>
								</h3>
								<p class="testimonial-designation"><?php echo esc_html( $t_designation ); ?></p>
								<?php if ( $t_star_rating > 0 ) { ?>
								<div class="testimonial-rating">
									<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
										<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
									<?php } ?>
								</div>
								<?php } ?>
								<?php if ( $t_website_url ) { ?>
								<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
								<?php } ?>
								<div class="description"><?php echo esc_html( $t_text ); ?></div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template6' ) { ?>
							<?php
							// Get YouTube video thumbnail
							$video_thumbnail = '';
							$video_id = '';

							if ( $t_video_url ) {
								// YouTube detection only
								if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i', $t_video_url, $match ) ) {
									$video_id = $match[1];
									$video_thumbnail = 'https://img.youtube.com/vi/' . $video_id . '/maxresdefault.jpg';
								}
							}

							// Get video playback setting
							$video_playback = get_option( 'testimonial_video_playback', 'external' ); // 'external' or 'inline'
							?>
							<div class="testimonial">
								<?php if ( $t_video_url && $video_id ) { ?>
								<div class="testimonial-video-wrapper" data-video-url="<?php echo esc_url( $t_video_url ); ?>" data-video-id="<?php echo esc_attr( $video_id ); ?>" data-playback="<?php echo esc_attr( $video_playback ); ?>">
									<img src="<?php echo esc_url( $video_thumbnail ); ?>" alt="<?php the_title(); ?>" class="testimonial-video-thumbnail">
									<div class="testimonial-play-button">
										<i class="fa fa-play"></i>
									</div>
								</div>
								<?php } ?>
								<div class="testimonial-content">
									<div class="description"><?php echo esc_html( $t_text ); ?></div>
									<?php if ( $t_star_rating > 0 ) { ?>
									<div class="testimonial-rating">
										<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
											<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
										<?php } ?>
									</div>
									<?php } ?>
									<div class="testimonial-author">
										<div class="pic">
											<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>" alt="<?php the_title(); ?>">
										</div>
										<div class="testimonial-author-info">
											<h3 class="testimonial-title"><?php the_title(); ?></h3>
											<p class="testimonial-designation"><?php echo esc_html( $t_designation ); ?></p>
											<?php if ( $t_website_url ) { ?>
											<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template7' ) { ?>
							<div class="testimonial">
								<div class="testimonial-platform"><i class="fa fa-twitter"></i> Review</div>
								<div class="testimonial-header">
									<div class="pic">
										<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>" alt="<?php the_title(); ?>">
									</div>
									<div class="testimonial-user-info">
										<h3 class="testimonial-title">
											<?php the_title(); ?>
											<span class="testimonial-verified-badge"><i class="fa fa-check"></i></span>
										</h3>
										<p class="testimonial-designation"><?php echo esc_html( $t_designation ); ?></p>
										<?php if ( $t_website_url ) { ?>
										<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank">@<?php echo esc_html( str_replace( array( 'http://', 'https://', 'www.' ), '', $t_website_url ) ); ?></a></p>
										<?php } ?>
									</div>
								</div>
								<div class="description"><?php echo esc_html( $t_text ); ?></div>
								<?php if ( $t_star_rating > 0 ) { ?>
								<div class="testimonial-rating">
									<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
										<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
									<?php } ?>
								</div>
								<?php } ?>
								<div class="testimonial-footer">
									<div class="testimonial-date"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></div>
									<div class="testimonial-social-actions">
										<span class="testimonial-social-action"><i class="fa fa-heart-o"></i> Like</span>
										<span class="testimonial-social-action"><i class="fa fa-share"></i> Share</span>
									</div>
								</div>
							</div>
					<?php } elseif ( $testimonial_carousel_design == 'template8' ) { ?>
							<div class="testimonial">
								<span class="testimonial-decoration"></span>
								<span class="testimonial-decoration"></span>
								<div class="description"><?php echo esc_html( $t_text ); ?></div>
								<div class="pic">
									<img src="<?php echo esc_url( $t_fe_image_thumb[0] ); ?>" alt="<?php the_title(); ?>">
								</div>
								<?php if ( $t_star_rating > 0 ) { ?>
								<div class="testimonial-rating">
									<?php for ( $i = 1; $i <= 5; $i++ ) { ?>
										<i class="fa fa-star<?php echo ( $i <= $t_star_rating ) ? '' : '-o'; ?>"></i>
									<?php } ?>
								</div>
								<?php } ?>
								<h3 class="testimonial-title"><?php the_title(); ?></h3>
								<p class="testimonial-designation"><?php echo esc_html( $t_designation ); ?></p>
								<?php if ( $t_website_url ) { ?>
								<p class="testimonial-link"><a href="<?php echo esc_url( $t_website_url ); ?>" target="_blank"><?php echo esc_html( $t_website_url ); ?></a></p>
								<?php } ?>
							</div>
					<?php } ?>
					<?php
				endwhile;
				?>
			</div>
		</div>
		<?php
		// Add inline script for owl carousel initialization
		$owl_init_script = "
		jQuery(document).ready(function($){
			if (typeof $.fn.owlCarousel !== 'undefined') {
				$('#testimonial-slider').owlCarousel({
					items: " . esc_js( $testimonial_column_layout ) . ",
					itemsDesktop:[1000,1],
					itemsDesktop:[990,2],
					itemsTablet:[768,2],
					itemsMobile:[650,1],
					pagination:" . esc_js( $pagination11 ) . ",
					" . ( $carousal_effect != 'none' ? "transitionStyle:'" . esc_js( $carousal_effect ) . "'," : '' ) . "
					navigationText:[''],
					autoPlay:" . esc_js( $auto_play_carousel ) . ",
					slideSpeed:1000
				});
			}

			// YouTube video play button handler
			$('.testimonial-play-button').on('click', function(e) {
				e.preventDefault();
				var wrapper = $(this).closest('.testimonial-video-wrapper');
				var videoUrl = wrapper.data('video-url');
				var videoId = wrapper.data('video-id');
				var playback = wrapper.data('playback');

				if (!videoUrl || !videoId) return;

				if (playback === 'inline') {
					// Inline playback - embed YouTube video
					var iframe = '<iframe src=\"https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>';

					// Remove thumbnail and play button, add iframe
					wrapper.find('.testimonial-video-thumbnail, .testimonial-play-button').fadeOut(300, function() {
						$(this).remove();
						wrapper.append(iframe);
					});
				} else {
					// External playback - open YouTube in new tab
					window.open(videoUrl, '_blank');
				}
			});
		});
		";
		wp_add_inline_script( 'tml-owl-js', $owl_init_script );
		wp_reset_query();
	} else {
		?>
		<div class="col-sm-12">
			<p style="text-align: center; padding: 20px; background: #f5f5f5; border-radius: 5px;">
				<?php esc_html_e( 'No testimonials found. Please add some testimonials first.', 'testimonial-maker' ); ?>
			</p>
		</div>
		<?php
	}
	?>
	<?php
	return ob_get_clean();
}?>
