<?php
	global $be_themes_data;
	if(!isset($be_themes_data['slider_navigation_style']) || empty($be_themes_data['slider_navigation_style'])) {
		$arrow_style = 'style1-arrow';
	} else {
		$arrow_style = $be_themes_data['slider_navigation_style'];
	}
	if($arrow_style == 'style1-arrow' || $arrow_style == 'style3-arrow' || $arrow_style == 'style5-arrow'){
		$arrow_style_class = 'arrow-block';
	}else{
		$arrow_style_class = 'arrow-border';
	}

	$normal_scroll = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_vertical_slider_normal_scroll', true );
	if($normal_scroll == 1) {
		$normal_scroll = 'normal-scroll';
	}
?>
<div id="content" class="gallery-all-container resized <?php echo $arrow_style_class .' '. $arrow_style.' '.$normal_scroll; ?>">
	<div id="gallery-container-wrap" class="clearfix">
		<div id="gallery-container" class="vertical-carousel">
			<?php
				$overlay = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_enable_overlay', true );
				$overlay_color = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_overlay_color', true );
				$overlay_opacity = get_post_meta( get_the_ID(), 'be_themes_portfolio_horizontal_slider_overlay_color_opacity', true );
				$slide_height = get_post_meta( get_the_ID(), 'be_themes_portfolio_slide_height', true );
				$selected_categorey = wp_get_post_terms( get_the_ID(), 'portfolio_categories' );
				$meta = wp_list_pluck( $selected_categorey, 'term_id' );
				if(!isset($slide_height) || empty($slide_height)) {
					$slide_height = 100;
				}
				if(isset($overlay) && $overlay == 1) {
					if(!isset($overlay_opacity) || empty($overlay_opacity)) {
						$overlay_opacity = 85;
					}
					if(isset($overlay_color) && !empty($overlay_color)) {
						$overlay_color = be_themes_hexa_to_rgb( $overlay_color );
						$thumb_overlay_color = 'rgba('.$overlay_color[0].','.$overlay_color[1].','.$overlay_color[2].','.(intval($overlay_opacity) / 100 ).')';	
					} else {
						$thumb_overlay_color = '';
					}
				}
				if($meta) {
					$args = array (
						'post_type' => 'portfolio',
						'tax_query' => array (
							array (
								'taxonomy' => 'portfolio_categories',
								'field' => 'term_id',
								'terms' => $meta,
								'operator' => 'IN'
							)
						),
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> 'ASC',
						'status'=> 'publish'
					);
				} else {
					$args = array (
						'post_type' => 'portfolio',
						'posts_per_page' => '-1',
						'orderby'=> 'date',
						'order'=> 'ASC',
						'status'=> 'publish'
					);
				}
				$the_query = new WP_Query( $args );
				if($the_query) {
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$attachment_id = get_post_thumbnail_id(get_the_ID());
						$attach_img = wp_get_attachment_image_src($attachment_id, 'full');					
						$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);					
						if($video_url) {						
							$data_source = 'video';					
						} else {						
							$data_source = $attach_img[0];					
						}

						echo '<div class="placeholder style4_placehloder load center show-title" data-source="'.$data_source.'" data-href="'.get_permalink().'" style="height: '.$slide_height.'%">';			
						if($video_url) {						
							echo be_gal_video($video_url);					
						}
						if(isset($overlay) && $overlay == 1 && $normal_scroll != 'normal-scroll') {
							echo '<div class="overlay_placeholder" style="background: '.$thumb_overlay_color.';"></div>';
						}
						if( get_the_title(get_the_ID())) {
							echo '<div class="attachment-details attachment-details-custom-slider animated">';
							echo '<a href="'.get_permalink().'" target="_blank">'.get_the_title(get_the_ID()).'</a>';
							echo get_be_themes_portfolio_category_list(get_the_ID(), true);
							echo '</div>';
						}
						echo '</div>';				
					endwhile;
					wp_reset_postdata();
				}
			?>
		</div>
	</div>
	<?php 
		get_template_part( 'portfolio/gallery', 'content' );
		$show_carousel_bar = get_post_meta( get_the_ID(), 'be_themes_portfolio_show_carousel_bar', true );
		if($show_carousel_bar == 1) { ?>
			<div class="carousel_bar_area clearfix">
				<div class="carousel_bar_wrap">
					<div class="carousel_bar">
						<ul id="carousel" class="elastislide-list">
							<?php
							$count = 0;
							$the_query = new WP_Query( $args );
							if($the_query) {
								while ( $the_query->have_posts() ) : $the_query->the_post();
									$attachment_id = get_post_thumbnail_id(get_the_ID());
									$attach_img = wp_get_attachment_image_src($attachment_id, 'carousel-thumb');
									$video_url = get_post_meta($attachment_id, 'be_themes_featured_video_url', true);
									if($video_url && $video) {
										$data_source = '<img width="75" height="50" src="'.get_template_directory_uri().'/img/video-placeholder.jpg" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
									} else {
										$data_source = '<img width="75" height="50" src="'.$attach_img[0].'" class="attachment-carousel-thumb" alt="hanging_on_reduced">';
									}
									echo '<li><a href="#" class="gallery-thumb" data-target="'.$count.'">'.$data_source.'</a></li>';
									$count++;
								endwhile;
							}
							wp_reset_postdata();
							?>
						</ul>
					</div>
				</div>
			</div> <?php
		}
	?>
</div>