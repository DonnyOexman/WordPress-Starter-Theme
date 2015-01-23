<?php

use WPCore\Taxonomy\Taxonomy;


// Add taxonomy 'Genres'
$options_genres = array(
    'id' => 'genre',
    'post_types' => array( 'post' ),
    'args' => array(
        'labels' => array(
            'name' => __( 'Genres' ),
            'singular_name' => __( 'Genre' )
        ),
        'rewrite' => array(
            'slug' => __( 'genre' )
        ),
        'hierarchical' => true
    )
);

new Taxonomy( $options_genres );
