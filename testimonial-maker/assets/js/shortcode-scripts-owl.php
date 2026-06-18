<?php
// Testimonial Premium - Owl Carousel Configuration Scripts
// Auto-extracted for modularity

if (!defined('ABSPATH'))
	exit;
?>
<script>
	jQuery(document).ready(function ($) {
		var owl = jQuery('#tml-carousel-<?php echo esc_attr($post_id['id']); ?>');

		// Save copy of original child slides for filtering before Owl carousel initializes
		var originalSlides = [];
		owl.children().each(function () {
			originalSlides.push(jQuery(this).clone());
		});
		owl.data('original-slides', originalSlides);

		<?php if ($tml_progress_bar == 'true') { ?>
			function startProgressBar() {
				jQuery('.tml-slider-progress-bar').css({
					width: '100%',
					transition: 'width <?php echo intval($tml_timeout_speed); ?>ms linear'
				});
			}
			function resetProgressBar() {
				jQuery('.tml-slider-progress-bar').css({
					width: '0%',
					transition: 'none'
				});
			}
		<?php } ?>


		<?php
		$force_single_item = ($testimonial_carousel_design == 13) ? true : false;
		?>
		function initTmlOwlCarousel_<?php echo esc_attr($post_id['id']); ?>($owlEl) {
			$owlEl.owlCarousel({
				items: <?php echo $force_single_item ? '1' : intval(!empty($tml_col_d) ? $tml_col_d : '3'); ?>,
				margin: 30,
				autoHeight: <?php echo ($tml_auto_hight == 'true') ? 'true' : 'false'; ?>,
				rtl: <?php echo ($tml_rtl == 'true') ? 'true' : 'false'; ?>,

				<?php if ($tml_progress_bar == 'true') { ?>
					onInitialized: startProgressBar,
					onTranslate: resetProgressBar,
					onTranslated: startProgressBar,
				<?php } ?>
						
				<?php
				$animOut = '';
				$animIn = '';
				if ($tml_animateOut_effect == 'fade') {
					$animOut = 'fadeOut';
					$animIn = 'fadeIn';
				} elseif ($tml_animateOut_effect == 'flip') {
					$animOut = 'flipOutX';
					$animIn = 'flipInX';
				} elseif ($tml_animateOut_effect == 'zoom') {
					$animOut = 'zoomOut';
					$animIn = 'zoomIn';
				}
				?>
				<?php if ($animOut) { ?>
					animateOut: '<?php echo esc_js($animOut); ?>',
					animateIn: '<?php echo esc_js($animIn); ?>',
				<?php } ?>
				loop: <?php echo ($tml_testimonial_loop == 'true') ? 'true' : 'false'; ?>,
				mouseDrag: <?php echo ($tml_mouse_draggable == 'true') ? 'true' : 'false'; ?>,
				autoplay: <?php echo ($auto_play_carousel == 'true') ? 'true' : 'false'; ?>,
				autoplayTimeout: <?php echo intval(!empty($tml_timeout_speed) ? $tml_timeout_speed : '3000'); ?>,
				autoplayHoverPause: <?php echo ($tml_hover_pause == 'true') ? 'true' : 'false'; ?>,
				autoplaySpeed: <?php echo intval(!empty($tml_slide_speed) ? $tml_slide_speed : '3000'); ?>,
				smartSpeed: <?php echo intval(!empty($tml_slide_speed) ? $tml_slide_speed : '3000'); ?>,
				responsive: {
					0: {
						items: 1,
						autoplay: <?php echo ($auto_play_carousel == 'true' && $tml_autoplay_mobile == 'true') ? 'true' : 'false'; ?>,
						nav: <?php echo ($tml_nav == 'true' && $tml_nav_mobile_hide == 'false') ? 'true' : 'false'; ?>,
						dots: <?php echo ($tml_pagination == 'true' && $tml_pagination_mobile_hide == 'false') ? 'true' : 'false'; ?>
					},
					768: {
						items: <?php echo $force_single_item ? '1' : intval(!empty($tml_col_t) ? $tml_col_t : '2'); ?>,
						autoplay: <?php echo ($auto_play_carousel == 'true') ? 'true' : 'false'; ?>,
						nav: <?php echo ($tml_nav == 'true') ? 'true' : 'false'; ?>
					},
					1024: {
						items: <?php echo $force_single_item ? '1' : intval(!empty($tml_col_d) ? $tml_col_d : '3'); ?>,
						autoplay: <?php echo ($auto_play_carousel == 'true') ? 'true' : 'false'; ?>,
						nav: <?php echo ($tml_nav == 'true') ? 'true' : 'false'; ?>
					}
				},
				dots: <?php echo ($tml_pagination == 'true') ? 'true' : 'false'; ?>,
				dotsData: false,
				<?php
				$arrow_style = !empty($tml_nav_arrow_style) ? $tml_nav_arrow_style : 'chevron';
				$prev_svg = '<svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>';
				$next_svg = '<svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>';

				switch ($arrow_style) {
					case 'angle_double':
						$prev_svg = '<svg viewBox="0 0 24 24"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>';
						$next_svg = '<svg viewBox="0 0 24 24"><polyline points="13 17 18 12 13 7"></polyline><polyline points="6 17 11 12 6 7"></polyline></svg>';
						break;
					case 'arrow':
						$prev_svg = '<svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>';
						$next_svg = '<svg viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>';
						break;
					case 'long_arrow':
						$prev_svg = '<svg viewBox="0 0 24 24"><line x1="20" y1="12" x2="4" y2="12"></line><polyline points="10 18 4 12 10 6"></polyline></svg>';
						$next_svg = '<svg viewBox="0 0 24 24"><line x1="4" y1="12" x2="20" y2="12"></line><polyline points="14 6 20 12 14 18"></polyline></svg>';
						break;
					case 'caret':
						$prev_svg = '<svg viewBox="0 0 24 24" class="tml-caret"><polygon points="15 18 9 12 15 6"></polygon></svg>';
						$next_svg = '<svg viewBox="0 0 24 24" class="tml-caret"><polygon points="9 18 15 12 9 6"></polygon></svg>';
						break;
				}
				?>
				navText: [
					'<?php echo $prev_svg; ?>',
					'<?php echo $next_svg; ?>'
				],

						<?php if ($tml_url_hash_slide == 'true') { ?>
					URLhashListener: true,
					startPosition: 'URLHash',
				<?php } ?>
			});
		}

		// Store the init function reference
		owl.data('owl-init-fn', initTmlOwlCarousel_<?php echo esc_attr($post_id['id']); ?>);

		// Call init for first-time page load
		initTmlOwlCarousel_<?php echo esc_attr($post_id['id']); ?>(owl);


		<?php if ($tml_mouse_control == 'true') { ?>
			owl.on('mousewheel', '.owl-stage', function (e) {
				if (e.deltaY > 0) {
					owl.trigger('next.owl');
				} else {
					owl.trigger('prev.owl');
				}
				e.preventDefault();
			});
		<?php } ?>

	});
</script>