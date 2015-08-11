<?php 

class cr3ativ_career extends WP_Widget {

	// constructor
	function cr3ativ_career() {
        parent::__construct(false, $name = __('Career Loop', 'cr3at_career') );
    }

	// widget form creation
	function form($instance) { 
// Check values
 if( $instance) { 
     $title = esc_attr($instance['title']); 
     $numbertodisplay = esc_attr($instance['numbertodisplay']); 
     $sortby = esc_attr($instance['sortby']); 
} else { 
     $title = ''; 
     $text = ''; 
     $sortby = '';
} 
?>
<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'cr3at_career'); ?></label>
<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" style="margin-left:4px; width:86%;" />
</p>
<p>
<label for="<?php echo $this->get_field_id('numbertodisplay'); ?>"><?php _e('# Display?', 'cr3at_career'); ?></label>
<input id="<?php echo $this->get_field_id('numbertodisplay'); ?>" name="<?php echo $this->get_field_name('numbertodisplay'); ?>" type="text" value="<?php echo $numbertodisplay; ?>" style="float:right; width:56%;" />
</p>
<p>
<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Sort by ASC?', 'cr3at_career'); ?></label>
<input id="<?php echo $this->get_field_id('sortby'); ?>" name="<?php echo $this->get_field_name('sortby'); ?>" type="checkbox" value="1" <?php checked( '1', $sortby ); ?> style="float:right; margin-right:6px;" />
</p>

<?php }
	// widget update
	function update($new_instance, $old_instance) {
      $instance = $old_instance;
      // Fields
      $instance['title'] = strip_tags($new_instance['title']);
      $instance['numbertodisplay'] = strip_tags($new_instance['numbertodisplay']);
      $instance['sortby'] = strip_tags($new_instance['sortby']);
     return $instance;
}

	// widget display
	function widget($args, $instance) {
   extract( $args );
   // these are the widget options
   $title = apply_filters('widget_title', $instance['title']);
   $numbertodisplay = $instance['numbertodisplay'];
   $sortby = $instance['sortby'];
   echo $before_widget;
   if( $sortby == '1' ) {
   $sortby = 'ASC';
   } else {
   $sortby = 'DESC';
   }
      
		global $post;  
		$career = array(
		'post_type' => 'cr3ativcareers',
		'order' => $sortby,
		'posts_per_page' => $numbertodisplay,
		);   
   
   // Check if title is set
   if ( $title ) {
      echo $before_title . $title . $after_title;
   }	
   
   // Display the widget
?> 
<ul class="cr3ativcareer_widget">
		<?php 
   		query_posts($career); if (have_posts()) : while (have_posts()) : the_post(); ?>
        
<li>
<h3><a href="<?php the_permalink (); ?>"><?php the_title (); ?></a></h3>

<!-- Start of post content last -->
<div class="cr3ativcareer_post_content_last">

<?php
  $excerpt = get_the_excerpt();
  echo cr3careers_string_limit_words($excerpt,15);
?>

</div><!-- End of post content last -->

<?php endwhile; ?>

</li>
<?php else: ?> 
<p><?php _e( 'There are no posts to display. Try using the search.', 'cr3at_career' ); ?></p> 

<?php endif; ?>
</ul>
  
<?php     
   
   echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("cr3ativ_career");'));

?>