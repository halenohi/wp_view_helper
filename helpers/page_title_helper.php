<?php
trait PageTitleHelper {
  public function page_title() {
    $divider = ' | ';
    if (is_404()) {
      return 'お探しのページは見つかりませんでした 404 Not Found' . $divider;
    } elseif (is_category()) {
      return $this->category_page_title() . $divider;
    } elseif (is_single()) {
      return $this->single_page_title() . $divider;
    } elseif (is_page()) {
      return $this->single_page_title() . $divider;
    } elseif (is_tag()) {
      return $this->tag_page_title() . $divider;
    } elseif (is_author()) {
      return $this->author_page_title() . $divider;
    } elseif (is_archive()) {
      return $this->archive_page_title() . $divider;
    }
  }

  public function category_page_title() {
    global $wp_query;
    $category = $wp_query->queried_object;
    $parent_name = $category->category_parent > 0 ? ' ' . get_term($category->category_parent, 'category')->name : '';
    return $category->name . $parent_name;
  }

  public function single_page_title() {
    global $wp_query;
    return $wp_query->post->post_title;
  }

  public function tag_page_title() {
    global $wp_query;
    return 'タグ：' . $wp_query->query['tag'];
  }

  public function author_page_title() {
    global $wp_query;
    return '執筆者：' . $wp_query->queried_object->data->display_name;
  }

  public function archive_page_title() {
    global $wp_query;
    $result = 'アーカイブ：';
    if (isset($wp_query->query['year'])) {
      $result .= $wp_query->query['year'] . '年';
    }
    if (isset($wp_query->query['monthnum'])) {
      $result .= $wp_query->query['monthnum'] . '月';
    }
    return $result;
  }
}
