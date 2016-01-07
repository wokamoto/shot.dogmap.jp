<?php

function nu2013_twentythirteen_child_setup() {
        register_default_headers( array(
                'rain' => array(
                        'url' => '%2$s/images/headers/rain.png',
                        'thumbnail_url' => '%2$s/images/headers/rain-thumbnail.png',
                        'description' => 'rain'
                ),
                'sky' => array(
                        'url' => '%2$s/images/headers/sky.png',
                        'thumbnail_url' => '%2$s/images/headers/sky-thumbnail.png',
                        'description' => 'sky'
                )
        ) );
}
add_action( 'after_setup_theme', 'nu2013_twentythirteen_child_setup' );

$child_custom_header_defaults = array(
                'default-image' => '%2$s/images/headers/rain.png',
);
add_theme_support( 'custom-header', $child_custom_header_defaults );