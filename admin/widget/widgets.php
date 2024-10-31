<?php

// Creating the widget 
class QueueTechWidgets extends WP_Widget {

  function __construct() {
      parent::__construct(
        // Base ID of your widget
        'queue_widget', 

        // Widget name will appear in UI
        __('Queue Widget', 'queue_widget'), 

        // Widget description
        array( 'description' => __( 'Queue Widget', 'queue_widget' ), ) 
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

      switch ($instance['type']) {
        case 'signup-vertical':
            echo "<queue-signup type=\"vertical\"></queue-signup>";
          break;

        case 'signup-horizontal':
            echo "<queue-signup type=\"horizontal\"></queue-signup>";
          break;

        default:
            echo "<queue-" . $instance['type'] . "></queue-" . $instance['type'] . ">";
          break;
      }

      echo $args['after_widget'];
  }
        
  // Widget Backend 
  public function form( $instance ) {
    $types = array('signup-horizontal' => 'Signup Horizontal',
                   'signup-vertical'   => 'Signup Vertical',
                   'socialproof'       => 'Social Proof',
                   'greetings-bar'     => 'Greetings Bar',
                   // 'exit-popup'        => 'Exit Popup',
                   'community'         => 'Community');
    
    $type = !empty($instance['type']) ? $instance['type'] : '';

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
        <label for="<?php echo $this->get_field_id('type'); ?>">Render:</label>
        <select class="widefat" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
        <option <?php echo $type != '' ? 'selected ' : ''; ?> disabled>Select a widget to render</option>
<?php
        $html = '';
        foreach ( $types as $key => $option ) {
             $selected = $key == $type ? ' selected="selected"' : '';
             $html .= '<option value="' . $key . '"' . $selected . '>' . $option . '</option>';
        }
        echo $html;
?>
        </select>
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

  // Register and load the widget
  function register_queuetech_widgets() {
    register_widget( 'QueueTechWidgets' );
  }

  add_action( 'widgets_init', 'register_queuetech_widgets' );
