<?php

/*
 * @package BenzeePlugin
 */

if (! defined('WP_UNINSTALL_PLUGIN')){
    die;
}

//    $movies = get_posts(array('post_type'=>'movies', 'numberposts' => -1));
//    foreach ($movies as $movie){
//        wp_delete_post($movie->ID,false);
//    }

    global $wpdb;

    $wpdb->query("DELETE FROM wp_posts WHERE post_type = 'movies'");
    $wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
    $wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
