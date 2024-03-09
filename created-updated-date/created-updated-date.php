<?php
/*
Plugin Name: Created Updated Date
Plugin URI: http://example.com/
Description: Adds creation and modification dates to pages and posts, and includes meta tags for dates.
Version: 1.0
Author: Paul H
Author URI: http://example.com/
*/

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

function cud_display_post_dates($content) {
  if (is_single() || is_page()) {
    $post_created = get_the_date('F j, Y');
    $post_modified = get_the_modified_date('F j, Y');

    $date_info = '<p class="post-dates" style="font-style: italic;">';
    $date_info .= 'Created ' . $post_created;

    if ($post_created !== $post_modified) {
        $date_info .= ', Updated ' . $post_modified;
    }

    $date_info .= '</p>';

    $content .= $date_info;
  }
  return $content;
}

add_filter('the_content', 'cud_display_post_dates');