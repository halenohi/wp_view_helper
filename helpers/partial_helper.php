<?php
trait PartialHelper {
  private $template_engine;
  private $template_engine_name = 'Mustache_Engine';
  private $template_extension = 'mustache';

  public function partial($relative_path, $theme_name = '', $local_assigns = null) {
    $partial_path = $this->makePartialPath($relative_path, $theme_name);
    if (!file_exists($partial_path)) {
      return '';
    }
    return $this->render($partial_path, $local_assigns);
  }

  private function makePartialPath($relative_path, $theme_name) {
    $root_path = empty($theme_name) ? $this->theme_root_path : $this->change_theme_name($theme_name);
    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $wp_dir = dirname(WP_CONTENT_DIR);
    if ($document_root != $wp_dir) {
      $wp_dir = $document_root;
    }
    return $wp_dir . $root_path . $relative_path;
  }

  private function template() {
    if (empty($this->template_engine)) {
      $this->template_engine = new $this->template_engine_name;
    }
    return $this->template_engine;
  }

  private function render($partial_path, $local_assigns) {
    $partial_str = file_get_contents($partial_path);
    if (preg_match('/\.' . $this->template_extension . '$/', $partial_path)) {
      $partial_str = $this->template()->render($partial_str, $local_assigns);
    }
    return $partial_str;
  }
}
