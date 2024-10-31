<?php
/**
 * WordPress Settings Framework
 *
 * @author Gilbert Pellegrom, James Kemp
 * @link https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

add_filter( 'wpsf_register_settings_queue', 'queue_settings' );

function queue_settings( $wpsf_settings ) {

    // Tab 1
    $wpsf_settings['tabs'][] = array(
        'id' => 'main',
        'title' => __('Main'),
    );
    
    $wpsf_settings['sections'][]  = array(
        'tab_id' => 'main',
        'section_id' => 'general',
        'section_title' => 'General Settings',
        'section_order' => 2,
        'fields' => array(
            array(
                'id' => 'campaign',
                'title' => 'Campaign ID',
                'desc' => 'Please enter your Queue campaign ID.<br>To find select your campaign > management area > integration section > wordpress.',
                'placeholder' => 'campaign id.',
                'type' => 'text',
            ),
        )
    );

    $wpsf_settings['sections'][]  = array(
        'tab_id' => 'main',
        'section_id' => 'general',
        'section_title' => 'General Settings',
        'section_order' => 3,
        'fields' => array(
            array(
                'id' => 'exit_modal',
                'title' => 'Exit Modal',
                'desc' => 'Use this to enable or disable the exit popup signup form.<br>You can customize the call to action for your campaign in the setup area >  conversion tools > exit pop',
                'type' => 'select',
                'std' => 'enabled',
                'choices' => array(
                    'enabled' => 'Enabled',
                    'disabled' => 'Disabled',
                )
            )
        )
    );

    return $wpsf_settings;
}
