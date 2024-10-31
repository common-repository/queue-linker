<?php

// Creating the widget 
class QueueTechWidgetGreetingBar extends WP_Widget {
      
    public $_tag   = 'greeting-bar';
    public $_title = 'Greeting Bar';

  function __construct() {
      parent::__construct(
        // Base ID of your widget
        'queue_widget' . $this->_tag, 

        // Widget name will appear in UI
        __($this->_title, 'queue_widget' . $this->_tag), 

        // Widget description
        array( 'description' => __( $this->_title, 'queue_widget' . $this->_tag ), ) 
      );
  }

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
      global $queue_campaign_id;
      $title = apply_filters( 'widget_title', $instance['title'] );

      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
      echo "<queue-" . $this->_tag . "></queue-" . $this->_tag . ">";
      echo $args['after_widget'];
  }
        
  // Widget Backend 
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'New title', 'queue_widget' . $this->_tag );
    }
  ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
<?php
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
      $instance = array();
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      $instance['type']  = $new_instance['type'];
      return $instance;
    }
  }
