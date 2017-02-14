<?php 

	$values = get_post_custom( $post->ID );
	global $nz_ninzio;
	$nz_port_layout    = ($nz_ninzio['port-layout']) ? $nz_ninzio['port-layout'] : "medium";
	$nz_audio_mp3      = isset($values["audio_mp3"][0]) ? $values["audio_mp3"][0] : "";
	$nz_audio_ogg      = isset($values["audio_ogg"][0]) ? $values["audio_ogg"][0] : "";
	$nz_audio_embed    = isset($values["audio_embed"][0]) ? $values["audio_embed"][0] : "";
	$nz_video_mp4      = isset($values["video_mp4"][0]) ? $values["video_mp4"][0] : "";
	$nz_video_ogv      = isset($values["video_ogv"][0]) ? $values["video_ogv"][0] : "";
	$nz_video_webm     = isset($values["video_webm"][0]) ? $values["video_webm"][0] : "";
	$nz_video_embed    = isset($values["video_embed"][0]) ? $values["video_embed"][0] : "";
	$nz_video_poster   = isset($values["video_poster"][0]) ? $values["video_poster"][0] : "";
	$nz_rh             = (isset( $values['rh'][0]) && !empty($values['rh'][0])) ? $values["rh"][0] : "true";
	$nz_project_link   = (isset( $values['project_link'][0]) && !empty($values['project_link'][0]) ) ? $values["project_link"][0] : "";
	$nz_format         = (isset( $values['format'][0]) && !empty($values['format'][0]) ) ? $values["format"][0] : "image";
	$nz_solo_layout    = (isset( $values['layout'][0]) && !empty($values['layout'][0]) ) ? $values["layout"][0] : "false";

?>

<?php if (!is_single()): ?>
	<div class="post-body">
		<?php ninzio_port_thumbnail($nz_port_layout, $post->ID); ?>
		<div class="project-details">
			<?php if ( '' != get_the_title() ){ ?>
				<a href="<?php echo get_permalink(); ?>">
					<h4 class="project-title"><?php echo get_the_title() ?></h4>
				</a>
			<?php } ?>
			<?php if ($nz_port_layout == "small" || $nz_port_layout == "medium" || $nz_port_layout == "large" || $nz_port_layout == "full"): ?>
				<?php if('' != get_the_term_list($post->ID, 'portfolio-category')): ?>
					<div class="port-cat">
						<?php echo get_the_term_list( $post->ID, 'portfolio-category', '', ', ', '' ); ?>
					</div>
				<?php endif ?>
			<?php endif ?>
		</div>
	</div>
<?php else: ?>
	<?php if ($nz_solo_layout == "true"): ?>
		<?php if ('' != get_the_content()) {the_content();} ?>
	<?php else: ?>
		<div class="nz-clearfix">
			<div class="post-body main-content">

				<?php if ($nz_format == "image"): ?>
					<?php ninzio_port_thumbnail($nz_port_layout, $post->ID); ?>
				<?php elseif($nz_format == "gallery"): ?>
					<?php  ninzio_port_gallery($nz_port_layout, $post->ID); ?>
				<?php elseif($nz_format == "audio"): ?>
					<?php if (!empty($nz_audio_mp3) || !empty($nz_audio_ogg) || !empty($nz_audio_embed)): ?>
						<?php 
							if(!empty($nz_audio_embed) && empty($nz_audio_ogg) && empty($nz_audio_mp3)) {
								echo "<div class='post-audio media'><div class='post-audio-embed'>".$nz_audio_embed."</div></div>";
							} elseif (!empty($nz_audio_ogg) || !empty($nz_audio_mp3)) {
								ninzio_port_thumbnail($nz_port_layout, $post->ID);
								echo "<div class='post-audio media'>".do_shortcode('[audio mp3="'.$nz_audio_mp3.'" ogg="'.$nz_audio_ogg.'"][/audio]'."</div>"); 
							}
						?>
					<?php endif ?>
				<?php elseif($nz_format == "video"): ?>
					<?php if (!empty($nz_video_mp4) || !empty($nz_video_ogv) || !empty($nz_video_webm) || !empty($nz_video_embed)): ?>
						<div class="post-video media">
							<?php
								if(!empty($nz_video_embed) && empty($nz_video_mp4) && empty($nz_video_ogv) && empty($nz_video_webm)) {
									echo "<div class='post-video-embed'><div class='flex-mod'>".$nz_video_embed."</div></div>";
								} elseif((!empty($nz_video_mp4) || !empty($nz_video_ogv) || !empty($nz_video_webm))) {
									echo do_shortcode('[video mp4="'.$nz_video_mp4.'" ogv="'.$nz_video_ogv.'" webm="'.$nz_video_webm.'" poster="'.$nz_video_poster.'"][/video]');
								}
							?>
						</div>
					<?php endif; ?>
				<?php endif ?>
			</div>	
			<div class="single-details sidebar">

				<?php if ($nz_rh == "false"): ?>
					<?php if ( '' != get_the_title() ){ ?>
						<h2 class="project-title"><?php echo get_the_title() ?></h2>
					<?php } ?>
				<?php endif; ?>

				<?php if ($nz_ninzio['port-ss'] && $nz_ninzio['port-ss'] == 1): ?>
					<div class="post-social-share social-links nz-clearfix left">
						<a class="post-twitter-share icon-twitter4" target="_blank" href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php the_permalink(); ?>"><span><?php echo __("Tweet this!", TEMPNAME); ?></span></a>
					    <a class="post-facebook-share icon-facebook5" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>"><span><?php echo __("Share on Facebook", TEMPNAME); ?></span></a>
					    <a class="post-linkedin-share icon-linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;title=<?php the_title(); ?>&amp;url=<?php the_permalink(); ?>"><span><?php echo __("Share on LinkedIn", TEMPNAME); ?></span></a>
					    <a class="post-google-share icon-googleplus6" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><span><?php echo __("Share on Google+", TEMPNAME); ?></span></a>
					    <a class="post-pinterest-share icon-pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $url; ?>"><span><?php echo __("Share on Pinterest", TEMPNAME); ?></span></a>
					</div>
				<?php endif; ?>

				<?php if ('' != get_the_content()): ?>
					<div class="project-content nz-clearfix"><?php the_content() ?></div>
				<?php endif ?>

				<?php if('' != get_the_term_list($post->ID, 'portfolio-category')): ?>
					<ul class="nz-i-list square">
						<?php echo get_the_term_list( $post->ID, 'portfolio-category', '<li><div><span class="icon icon-checkmark"></span></div><div>', '<li><div><span class="icon icon-checkmark"></span></div><div>', '</div></li>' ); ?>
					</ul>
				<?php endif ?>

				<?php if (!empty($nz_project_link)): ?>
					<a href="<?php echo $nz_project_link; ?>" target="_blank" class="project-link medium button"><?php echo __("Launch project", TEMPNAME); ?></a>
				<?php endif ?>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>