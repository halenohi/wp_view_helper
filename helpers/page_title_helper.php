<?php
trait PageTitleHelper {
  public function page_title() {
    $divider = ' | ';
    if (is_404()) {
      return 'お探しのページは見つかりませんでした 404 Not Found' . $divider;
    } elseif (is_category()) {
      return $this->category_name() . $divider;
    } elseif (is_single()) {
      return $this->single_name() . $divider;
    } elseif (is_page()) {
      return $this->single_name() . $divider;
    }
  }

  public function category_name() {
    global $wp_query;
    $category = $wp_query->queried_object;
    $parent_name = $category->category_parent > 0 ? ' ' . get_term($category->category_parent, 'category')->name : '';
    return $category->name . $parent_name;
  }

  public function single_name() {
    global $wp_query;
    return $wp_query->post->post_title;
  }
}
