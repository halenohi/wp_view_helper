<?php
trait PartialHelper {
  public function partial($relative_path, $theme_name = '') {
    $root_path = empty($theme_name) ? $this->theme_root_path : $this->change_theme_name($theme_name);
    $partial_path = dirname(WP_CONTENT_DIR) . $root_path . $relative_path;
    return file_get_contents($partial_path);
  }
}
