<?php
trait UrlHelper {
  public function current_url() {
    return 'http://' . $_SERVER['HTTP_HOST'] . $this->current_url();
  }

  public function current_path() {
    return $_SERVER['REQUEST_URI'];
  }
}
