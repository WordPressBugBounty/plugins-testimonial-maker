<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="tml-testimonial" style="text-align: center;">
																					<!-- Centered Avatar -->
											<?php if ($tml_ds_image_show == 'show') { ?>
																						<div class="pic <?php echo esc_attr($image_shape_class); ?>"
																							style="<?php echo esc_attr($pic_style); ?> margin: 0 auto 15px auto; display: block; float: none;">
																							<img src="<?php echo esc_url($tml_fe_image_thumb[0]); ?>">
																						</div>
											<?php } ?>

																					<!-- Name, Designation & Website Wrapper with dynamic alignment -->
					<?php
					$tml_title_align = isset($testimonial_settings['tml_typo_title_align']) ? $testimonial_settings['tml_typo_title_align'] : 'center';
					$tml_title_flex = ($tml_title_align === 'left') ? 'flex-start' : (($tml_title_align === 'right') ? 'flex-end' : 'center');

					$tml_desig_align = isset($testimonial_settings['tml_typo_designation_align']) ? $testimonial_settings['tml_typo_designation_align'] : 'center';
					$tml_desig_flex = ($tml_desig_align === 'left') ? 'flex-start' : (($tml_desig_align === 'right') ? 'flex-end' : 'center');

					$tml_website_align = isset($testimonial_settings['tml_typo_website_align']) ? $testimonial_settings['tml_typo_website_align'] : 'center';
					$tml_website_flex = ($tml_website_align === 'left') ? 'flex-start' : (($tml_website_align === 'right') ? 'flex-end' : 'center');
					?>
					<div class="tml-author-info" style="display: flex; flex-direction: column; width: 100%; gap: 2px;">
						<?php if ($tml_ds_name_show == 'show') { ?>
							<<?php echo esc_attr($tml_ds_name_tag); ?> class="testimonial-title tml-name"
								style="margin-bottom: 5px; font-size: 16px; font-weight: 700; width: 100%; align-self: <?php echo esc_attr($tml_title_flex); ?>; text-align: <?php echo esc_attr($tml_title_align); ?>;">
								<?php the_title(); ?>
							</<?php echo esc_attr($tml_ds_name_tag); ?>>
						<?php } ?>

						<?php if ($tml_ds_designation_show == 'show') { ?>
							<p class="testimonial-designation tml-desig"
								style="font-size: 13px; opacity: 0.8; margin-top: 0; margin-bottom: 8px; align-self: <?php echo esc_attr($tml_desig_flex); ?>; text-align: <?php echo esc_attr($tml_desig_align); ?>;">
								<?php echo esc_html($t_designation); ?>
							</p>
						<?php } ?>

						<?php if ($t_website_url) { ?>
							<p class="testimonial-link" style="margin-bottom: 10px; align-self: <?php echo esc_attr($tml_website_flex); ?>; text-align: <?php echo esc_attr($tml_website_align); ?>;"><a
									href="<?php echo esc_url($t_website_url); ?>"
									style="text-decoration: none; font-weight: 600;"><?php echo esc_html($t_website_url); ?></a>
							</p>
						<?php } ?>
					</div>

																					<!-- Stars rating centered -->
																					<div class="tml-rating-container"
																						style="text-align: center; margin-bottom: 12px; display: block; width: 100%;">
												<?php echo tml_display_star_rating($t_star_rating, $tml_show_star_rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
																					</div>

																					<!-- Centered Description Section -->
											<?php if ($tml_ds_content_show == 'show') { ?>
																						<div class="tml-description tml-desc"
																							style="width: 100%; box-sizing: border-box; text-align: center; margin: 0; padding: 0; background: transparent; border: none; box-shadow: none; border-radius: 0;">
													<?php echo $display_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
																						</div>
											<?php } ?>
											<?php echo tml_display_social_profiles($testimonial_post_settings) /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ; ?>
																				</div>