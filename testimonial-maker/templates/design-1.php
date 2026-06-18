<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="tml-testimonial">
											<?php if ($tml_ds_image_show == 'show') { ?>
																				<div class="pic <?php echo esc_attr($image_shape_class); ?>"
																					style="<?php echo esc_attr($pic_style); ?>">
																					<img src="<?php echo esc_url($tml_fe_image_thumb[0]); ?>">
																				</div>
											<?php } ?>
																			<div class="testimonial-content">
												<?php if ($tml_ds_content_show == 'show') { ?>
																					<div class="tml-description tml-desc"><?php echo $display_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
																					</div>
												<?php } ?>
												<?php echo tml_display_star_rating($t_star_rating, $tml_show_star_rating); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
												<?php if ($tml_ds_name_show == 'show') { 
													$tml_title_align = isset($testimonial_settings['tml_typo_title_align']) ? $testimonial_settings['tml_typo_title_align'] : 'center';
													$tml_title_flex = ($tml_title_align === 'left') ? 'flex-start' : (($tml_title_align === 'right') ? 'flex-end' : 'center');

													$tml_desig_align = isset($testimonial_settings['tml_typo_designation_align']) ? $testimonial_settings['tml_typo_designation_align'] : 'center';
													$tml_desig_flex = ($tml_desig_align === 'left') ? 'flex-start' : (($tml_desig_align === 'right') ? 'flex-end' : 'center');

													$tml_website_align = isset($testimonial_settings['tml_typo_website_align']) ? $testimonial_settings['tml_typo_website_align'] : 'center';
													$tml_website_flex = ($tml_website_align === 'left') ? 'flex-start' : (($tml_website_align === 'right') ? 'flex-end' : 'center');
												?>
																					<div class="tml-author-info"
																						style="display: flex; flex-direction: column; width: 100%; gap: 4px;">
																						<<?php echo esc_attr($tml_ds_name_tag); ?> class="testimonial-title tml-name"
																							style="font-size: 16px; font-weight: 700; margin: 0; line-height: 1.4; align-self: <?php echo esc_attr($tml_title_flex); ?>; text-align: <?php echo esc_attr($tml_title_align); ?>;"><?php the_title(); ?></<?php echo esc_attr($tml_ds_name_tag); ?>>
														<?php if ($tml_ds_designation_show == 'show') { ?>
																							<span
																								class="tml-designation tml-desig"
																								style="align-self: <?php echo esc_attr($tml_desig_flex); ?>; text-align: <?php echo esc_attr($tml_desig_align); ?>;"><?php echo esc_html(ucwords($t_designation)); ?></span>
														<?php } ?>
														<?php if ($t_website_url) { ?>
																							<span class="testimonial-link"
																								style="align-self: <?php echo esc_attr($tml_website_flex); ?>; text-align: <?php echo esc_attr($tml_website_align); ?>;"><a
																									href="<?php echo esc_url($t_website_url); ?>"><?php echo esc_html(ucwords($t_website_url)); ?></a></span>
														<?php } ?>
																					</div>
												<?php } else { 
													$tml_desig_align = isset($testimonial_settings['tml_typo_designation_align']) ? $testimonial_settings['tml_typo_designation_align'] : 'center';
													$tml_website_align = isset($testimonial_settings['tml_typo_website_align']) ? $testimonial_settings['tml_typo_website_align'] : 'center';
												?>
													<?php if ($tml_ds_designation_show == 'show') { ?>
																						<span class="tml-designation tml-desig"
																							style="display:block; margin-top:5px; font-size:12px; color:#777; font-weight:normal; text-align: <?php echo esc_attr($tml_desig_align); ?>;"><?php echo esc_html(ucwords($t_designation)); ?></span>
													<?php } ?>
													<?php if ($t_website_url) { ?>
																						<span class="testimonial-link"
																							style="display:block; margin-top:5px; font-size:12px; font-weight:normal; text-align: <?php echo esc_attr($tml_website_align); ?>;"><a
																									href="<?php echo esc_url($t_website_url); ?>"><?php echo esc_html(ucwords($t_website_url)); ?></a></span>
													<?php } ?>
												<?php } ?>
												<?php echo tml_display_social_profiles($testimonial_post_settings) /* phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped */ ; ?>
																			</div>
																		</div>