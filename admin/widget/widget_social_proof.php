<?php

// Creating the widget 
class QueueTechWidgetSocialProof extends WP_Widget {

  public $_id   = 'socialproof';
  public $title = 'Social Proof';

  function __construct() {
    parent::__construct(
      'queue_widget' ,
      __($this->title, 'queue_widget' ), 
      array( 'description' => __( $this->title, 'queue_widget' ), ) 
    );
  }

  public function widget( $args, $instance ) {
      $title = apply_filters( 'widget_title', $this->title );
      echo "<queue-" . $this->_tag . "></queue-" . $this->_tag . ">";
  }
        
  // Widget Backend 
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'queue_widget' );
    }
  ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
  <?php 
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $instance ) {
      $instance = array();
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      $instance['type']  = $new_instance['type'];
      return $instance;
    }
}
