<?php



      /*
      Plugin Name: Queue
      Plugin URI: https://queueat.com
      Description: Queue: Viral Campaigns and Social Promotions
      Version: 1.0
      Author: Queue Technologies
      Author URI: https://queueat.com
      */



      class queueLinker {

        private $base_url;
        private $plugin_path;
        private $campaign;
        private $wpsf;

        private $enviroment = 'production';
        private $cdn;

        // constructor
        public function __construct(){

          $this->base_url = plugin_dir_url( __file__ );
          $this->plugin_path = plugin_dir_path( __file__ );
          $this->cdn = $this->enviroment == 'production' ? 'cdn.queueat.com' : 'd3ogtpqqdx3l88.cloudfront.net';

          add_action( 'admin_menu', array( $this, 'init_settings' ), 99 );

          require_once $this->plugin_path . 'admin/settings/framework.php';
          $this->wpsf = new WordPressSettingsFramework( $this->plugin_path .'admin/settings/settings.php', 'queue' );

          $data = $this->wpsf->get_settings();

          $this->campaign = $data['main_general_campaign'];

          // widgets
          foreach (glob($this->plugin_path."admin/widget/*.php") as $widget) {
            require_once $widget;
          }

          add_action( 'widgets_init', array($this, 'register_queuetech_widgets') );

          add_filter( 'clean_url', array($this, 'add_defer'), 11, 1 );

          // scripts
          add_action( 'wp_enqueue_scripts', array( $this, 'load_javascript' ) );
          add_action( 'wp_enqueue_scripts', array( $this, 'load_inline_javascript' ) );

          // short codes
          add_shortcode( 'queue-signup',        array( $this, 'shortcode_signup' ) );
          add_shortcode( 'queue-social-proof',  array( $this, 'shortcode_social_proof' ) );
          add_shortcode( 'queue-greetings-bar', array( $this, 'shortcode_greetings_bar' ) );
          add_shortcode( 'queue-community',     array( $this, 'shortcode_community' ) );

          if ( ($data['main_general_exit_modal'] == '' || $data['main_general_exit_modal'] == 'enabled') &&
             ($data['main_general_campaign'] != '')) {
             add_action( 'wp_footer', array($this, 'exit_modal') );
          }

          // backend
          if ( is_admin() ){
            require_once 'admin/editor/editor.php';
            add_action( 'admin_init', array( $this, 'load_admin_scripts' ) );
          }
        }

        public function init_settings() {
          $this->wpsf->add_settings_page( array(
            'page_title'  => __( 'Queue Technologies' ),
            'menu_title'  => __( 'Queue' ),
            'icon_url'    => $this->base_url . 'img/icon.png'
          ));
        }

        function validate_settings( $input ) {
          return $input;
        }

        // load admin scripts
        public function load_admin_scripts(){
          if(preg_match('/widgets.php/i', $_SERVER['REQUEST_URI'])) {
            wp_register_style( 'my_widget-css', plugin_dir_url( __file__ ) . 'admin/widget/widget.css' );
            wp_enqueue_style( 'my_widget-css' );
            wp_register_script( 'my_widget_js', plugin_dir_url( __file__ ) . 'admin/widget/widget.js' );
            wp_enqueue_script( 'my_widget_js' );
          }
        }

        public function load_javascript(){
          wp_register_script( 'queue_javascript', "//".$this->cdn."/assets/sdk/v3/queue.js", array('jquery'), null, true);
          wp_enqueue_script( 'queue_javascript'  );
        }

        public function load_inline_javascript(){
           $inline = "document.addEventListener('DOMContentLoaded', function(event) {
              window.queue = new Queue('" . $this->campaign . "');
            });";
           wp_add_inline_script( 'queue_javascript', $inline );
        }

        // shortcodes
        public function shortcode_signup( $atts ){
          $def = wp_parse_args( $atts, wp_embed_defaults());

          $atts = shortcode_atts( array(
            'width'  => '',
            'height' => '',
            'format' => 'horizontal',
            'debug'  => 'false'), $def );

          $this->atts = $atts;

          $data = $this->wpsf->get_settings();

          if (empty($this->campaign)){
            return;
          }

          $format = in_array($this->atts['format'], array('horizontal', 'vertical')) ? $this->atts['format'] : 'horizontal';
          return '<queue-signup type="'.$format.'"></queue-signup>';
        }

        public function shortcode_social_proof(){
          return "<queue-socialproof></queue-socialproof>";
        }

        public function shortcode_greetings_bar(){
          return "<queue-greeting-bar></queue-greeting-bar>";
        }

        public function shortcode_exit_popup(){
          return "<queue-exit-popup></queue-exit-popup>";
        }

        public function shortcode_community(){
          return "<queue-community></queue-community>";
        }

        function add_defer( $url ) {
          if ( FALSE === strpos( $url, 'queue' ) || FALSE === strpos( $url, '.js' )) {
              return $url;
          }
          return "$url' defer='defer";
        }

        function exit_modal() {
          echo $this->shortcode_exit_popup();
        }

        // Register and load the widget
        function register_queuetech_widgets() {
          register_widget( 'QueueTechWidgetCommunity' );
          register_widget( 'QueueTechWidgetGreetingBar' );
          register_widget( 'QueueTechWidgetSignupVertical' );
          register_widget( 'QueueTechWidgetSignupHorizontal' );
          register_widget( 'QueueTechWidgetSocialProof' );
        }
      }

      new queueLinker();
