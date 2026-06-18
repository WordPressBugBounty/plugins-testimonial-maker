<?php
// Testimonial Premium - Carousel Navigation Scripts
// Auto-extracted for modularity

if (!defined('ABSPATH'))
	exit;
?>
<script>
	jQuery(document).ready(function ($) {
		// Theme 10 Navigation Triggers
		$(document).off('click.tmlT10Prev').on('click.tmlT10Prev', '.tml-t10-prev', function (e) {
			e.preventDefault();
			$(this).closest('.owl-carousel').trigger('prev.owl.carousel');
		});
		$(document).off('click.tmlT10Next').on('click.tmlT10Next', '.tml-t10-next', function (e) {
			e.preventDefault();
			$(this).closest('.owl-carousel').trigger('next.owl.carousel');
		});

		// Theme 13 Navigation Triggers
		$(document).off('click.tmlT13AvatarLeft').on('click.tmlT13AvatarLeft', '.tml-t13-avatar-left', function (e) {
			e.preventDefault();
			$(this).closest('.owl-carousel').trigger('prev.owl.carousel');
		});
		$(document).off('click.tmlT13AvatarRight').on('click.tmlT13AvatarRight', '.tml-t13-avatar-right', function (e) {
			e.preventDefault();
			$(this).closest('.owl-carousel').trigger('next.owl.carousel');
		});

		window.initTmlRatingPositioning_<?php echo esc_attr($post_id['id']); ?> = function () {
			var ratingPos = "<?php echo esc_js($tml_ds_rating_pos); ?>";
			if (ratingPos) {
				var containerId = '#tml-main-wrapper-<?php echo esc_attr($post_id['id']); ?>';
				$(containerId + ' .tml-item-wrapper').each(function () {
					var $card = $(this);
					
					// Do not apply automatic rating repositioning to Design 17 (Custom Field Builder Layout)
					if ($card.find('.tml-testimonial').hasClass('tml-design-17')) {
						return;
					}

					var $rating = $card.find('.testimonial-rating');
					if (!$rating.length) return;

					var $title = $card.find('.testimonial-title, .tml-name');
					var $desc = $card.find('.tml-description, .tml-desc, .description');

					if (ratingPos === 'above_name') {
						if ($title.length) {
							$title.first().before($rating);
						}
					} else if (ratingPos === 'below_name') {
						if ($title.length) {
							$title.last().after($rating);
						}
					} else if (ratingPos === 'above_content') {
						if ($desc.length) {
							var $quoteContainer = $desc.closest('.tml-quote-container');
							if ($quoteContainer.length) {
								$quoteContainer.before($rating);
							} else {
								$desc.first().before($rating);
							}
						}
					} else if (ratingPos === 'below_content') {
						if ($desc.length) {
							var $quoteContainer = $desc.closest('.tml-quote-container');
							if ($quoteContainer.length) {
								$quoteContainer.after($rating);
							} else {
								$desc.last().after($rating);
							}
						}
					}
				});
			}
		};

		// Run on page load
		window.initTmlRatingPositioning_<?php echo esc_attr($post_id['id']); ?>();
	});
</script>