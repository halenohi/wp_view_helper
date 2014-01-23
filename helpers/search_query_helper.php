<?php
trait SearchQueryHelper {
  public function searchQuery() {
    if (!empty($_GET['s'])) {
      return esc_html($_GET['s']);
    } else {
      return '';
    }
  }
}
