<?php
trait AuthorListHelper {
  public function authorsData() {
    $result = [];
    $data = get_users();
    foreach ($data as $datum) {
      $_datum = $datum->data;
      $_datum->description = get_the_author_meta('description', $_datum->ID);
      $result[] = $_datum;
    }
    return $result;
  }
}
