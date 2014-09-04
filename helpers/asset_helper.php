<?php
trait AssetHelper {
  public $theme_root_path = '';

  private function __asset_helper_construct() {
    $theme_path = parse_url(get_template_directory_uri(), PHP_URL_PATH);
    $this->theme_root_path = $theme_path . '/';
  }

  private function change_theme_name($new_name) {
    $split_path = explode('/', $this->theme_root_path);
    array_pop($split_path);
    array_pop($split_path);
    $split_path[] = $new_name;
    return implode('/', $split_path) . '/';
  }

  public function asset_path($file_name, $asset_type, $extension = '', $theme_name = '') {
    $root_path = empty($theme_name) ? $this->theme_root_path : $this->change_theme_name($theme_name);
    $path = $root_path . $asset_type . 's/' . $file_name;
    if ($asset_type !== 'image') {
      $path .= '.' . $extension;
    }
    return $path;
  }

  public function stylesheet_path($file_name, $theme_name = '') {
    return $this->asset_path($file_name, 'stylesheet', 'css', $theme_name);
  }

  public function javascript_path($file_name, $theme_name = '') {
    return $this->asset_path($file_name, 'javascript', 'js', $theme_name);
  }

  public function image_path($file_name, $theme_name = '') {
    return $this->asset_path($file_name, 'image', $theme_name);
  }
}
