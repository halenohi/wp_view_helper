<?php
trait RssThumbnailHelper {
  public function __rss_thumbnail_helper_construct() {
    add_action('atom_entry', [$this, 'rss_item_action_hook']);
    add_action('rdf_item', [$this, 'rss_item_action_hook']);
    add_action('rss_item', [$this, 'rss_item_action_hook']);
    add_action('rss2_item', [$this, 'rss_item_action_hook']);
  }


  public function rss_item_action_hook() {
    global $post;
    $thumb_url = '';
    if (has_post_thumbnail($post->ID)) {
      $thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail')[0];
    }
    echo '<thumb>' . $thumb_url . '</thumb>';
  }
}
