<?php
trait ArchiveHelper {
  public function current_display_year_month() {
    global $wp_query;
    $result = '';
    if (array_key_exists('year', $wp_query->query)) {
      $result .= "{$wp_query->query['year']}年";
    }
    if (array_key_exists('monthnum', $wp_query->query)) {
      $result .= "{$wp_query->query['monthnum']}月";
    }
    return $result;
  }
}
