<?php
/*
Plugin Name: Created Updated Date
Description: Adds creation and modification dates to pages and posts and includes meta tags for dates.
Version: 1.0
Author: Paul H
*/

//Add date meta tags to head
function cud_add_dcterms_meta_tags() {
  if (is_single() || is_page()) {
    $post_id = get_queried_object_id();
    $post_created = get_the_date('Y-m-d', $post_id);
    $post_modified = get_the_modified_date('Y-m-d', $post_id);

    echo '<meta property="dcterms.created" content="' . esc_attr($post_created) . '">' . "\n";
    echo '<meta property="dcterms.modified" content="' . esc_attr($post_modified) . '">' . "\n";
  }
}

add_action('wp_head', 'cud_add_dcterms_meta_tags');

//Display create and modified dates at the bottom of post or page
function cud_display_post_dates($content) {
  if (is_single() || is_page()) {
    $post_created = get_the_date('F j, Y');
    $post_modified = get_the_modified_date('F j, Y');

    $date_info = '<div class="created-modified-dates">';
    $date_info .= 'Created ' . $post_created;

    if ($post_created !== $post_modified) {
        $date_info .= ', Updated ' . $post_modified;
    }

    $date_info .= '</div>';

    $content .= $date_info;
  }
  return $content;
}

add_filter('the_content', 'cud_display_post_dates');