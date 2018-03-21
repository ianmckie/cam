<?php get_header(); ?>

<div id="main-content">
	<div class="container">
		<div id="content-area" class="clearfix post-page">
		<?php 
			if(is_category()){
				echo '<h1>';
				
				single_cat_title();
				
				echo '</h1>';
				
				if(category_description()){
					echo '<div class="cat-description">'.category_description().'</div>'; 
				}
			}
			else{		
		?>
			<div class="top-area">
				<?php 

					wp_reset_postdata();
					$thumb = '';
					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_pb_post_main_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];
					
					$postsx = new WP_Query(array(
						'posts_per_page' => 4,
						'post__in' => get_option('sticky_posts'),
						'ignore_sticky_posts' => 4
					));
					
					if($postsx->have_posts()) :
						while($postsx->have_posts()) :
							$postsx->the_post(); 
				?>
					<div class="sticky-item">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<div class="post-info">
								<div class="post-tags">
									<?php $category = get_the_category();?>
									<div class="post-cat <?php echo strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $category[0]->cat_name)); ?>">
										<span></span>
										<?php echo $category[0]->cat_name; ?>	
									</div>
								</div>
								<h2 class="entry-title">
									<?php the_title(); ?>
								</h2>
								<div class="the-author" style="display:none"><span>by </span> <?php echo get_the_author(); ?></div>
							</div>
							<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
						</a>
					</div>	
				<?php 
						endwhile;
						wp_reset_query();
					endif; 
				?>
				<div class="clearfix"></div>
			</div>

				<?php } ?>
			
			<div id="left-area">
		<?php

			wp_reset_postdata();

			$thumb = '';
			$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
			$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
			$classtext = 'et_pb_post_main_image';
			$titletext = get_the_title();
			$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
			$thumb = $thumbnail["thumb"];

			$postsx = new WP_Query(array(
				'posts_per_page' =>3,
				'post__not_in' => get_option( 'sticky_posts' )
			));

			if ( $postsx->have_posts() ) :
				while ( $postsx->have_posts() ) : $postsx->the_post();
					$post_format = et_pb_post_format(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
						<div class="article-inner listing-inner">

					<?php
						$thumb = '';

						$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

						$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
						$classtext = 'et_pb_post_main_image';
						$titletext = get_the_title();
						$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
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
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height ); ?>
								</a>
						<?php
							elseif ( 'gallery' === $post_format ) :
								et_pb_gallery_images();
							endif;
						} ?>
							<div class="post-info">
								<?php if ( ! in_array( $post_format, array( 'link', 'audio', 'quote' ) ) ) : ?>
									<?php if ( ! in_array( $post_format, array( 'link', 'audio' ) ) ) : ?>
										<?php $category = get_the_category();?>
										<div class="post-cat <?php echo strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $category[0]->cat_name)); ?>">
											<span></span>
											<?php echo $category[0]->cat_name; ?>	
										</div>
										<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
									<?php endif; ?>

									<?php
										et_divi_post_meta();
									?>
								<?php endif; ?>
								<div class="clearfix"></div>
								<div class="social-buttons">
									<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" rel="nofollow">
										<i class="icon-facebook"></i>
									</a>
										<a href="https://twitter.com/intent/tweet?url=Check out this article @ <?php the_permalink(); ?>" target="_blank" rel="nofollow">
										<i class="icon-twitter"></i>
									</a>
										<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank" rel="nofollow">
										<i class="icon-google"></i>
									</a>
										<a href="http://www.linkedin.com/shareArticle?url=<?php the_permalink(); ?>&amp;mini=true" target="_blank" rel="nofollow">
										<i class="icon-linkedin"></i>
									</a>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="spacer"></div>
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

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer(); ?>