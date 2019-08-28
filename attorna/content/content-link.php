<?php
/**
 * The template part for displaying single posts
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="attorna-single-article attorna-blog-link-format" >
		<?php 
			global $pages;

			if( preg_match('#^<a.+href=[\'"]([^\'"]+).+</a>#', $pages[0], $match) ){ 
				$post_format_link = $match[1];
				$pages[0] = substr($pages[0], strlen($match[0]));
			}else if( preg_match('#^https?://\S+#', $pages[0], $match) ){
				$post_format_link = $match[0];
				$pages[0] = substr($pages[0], strlen($match[0]));
			}else{
				$post_format_link = get_permalink();
			}

			echo '<div class="attorna-single-article-content" >';
			echo '<a class="attorna-blog-icon-link" href="' . esc_url($post_format_link) . '" target="_blank" ><i class="icon_link" ></i></a>';

			echo '<div class="attorna-blog-content-wrap" >';
			echo '<h3 class="attorna-blog-title gdlr-core-skin-title" ><a href="' . esc_url($post_format_link) . '" target="_blank" >' . get_the_title() . '</a></h3>';
			echo '<div class="attorna-blog-content" >';
			the_content();
			echo '</div>'; 
			echo '</div>';
			echo '</div>';
		?>
		
	</div><!-- attorna-single-article -->
</article><!-- post-id -->
