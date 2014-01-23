<?php
trait AssetHelper {
  public $theme_root_path = '';

  private function __asset_helper_construct() {
    $pattern = '/^http(s)?\:\/\/(localhost|[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})(\:[0-9]+)?/';
    $theme_path = preg_replace($pattern, '', get_template_directory_uri());
    $this->theme_root_path = $theme_path . '/';
  }

  public function asset_path($file_name, $asset_type, $extension = '') {
    $path = $this->theme_root_path . $asset_type . 's/' . $file_name;
    if ($asset_type !== 'image') {
      $path .= '.' . $extension;
    }
    return $path;
  }

  public function stylesheet_path($file_name) {
    return $this->asset_path($file_name, 'stylesheet', 'css');
  }

  public function javascript_path($file_name) {
    return $this->asset_path($file_name, 'javascript', 'js');
  }

  public function image_path($file_name) {
    return $this->asset_path($file_name, 'image');
  }
}
