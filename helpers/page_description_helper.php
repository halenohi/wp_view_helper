<?php
trait PageDescriptionHelper {
  public function page_description() {
    if (is_single()) {
      return $this->custom_field_description();
    } elseif (is_category()) {
      return $this->category_description();
    } else {
      return $this->site_description();
    }
  }

  public function site_description() {
    return get_bloginfo('description');
  }

  public function custom_field_description() {
    global $wp_query;
    $custom_fields = get_post_custom($wp_query->post->ID);
    if (array_key_exists('description', $custom_fields)) {
      return $custom_fields['description'][0];
    } else {
      return $this->site_description();
    }
  }

  public function category_description() {
    global $wp_query;
    $result = $wp_query->queried_object->description;
    if (empty($result)) {
      return $this->site_description();
    } else {
      return $result;
    }
  }
}
