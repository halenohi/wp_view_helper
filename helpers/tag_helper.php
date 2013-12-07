<?php
trait TagHelper {
  public function tag($tag_name, $content = '', $attributes = [], $is_single_tag = false) {
    $tag = "<{$tag_name} ";
    foreach ($attributes as $attr_name => $attr_value) {
      $tag .= "{$attr_name}='{$attr_value}' ";
    }
    if ($is_single_tag) {
      $tag .= '/>';
    } else {
      $tag .= ">{$content}</{$tag_name}>";
    }
    return $tag;
  }

  public function javascript_include_tag($file_name) {
    $path = $this->javascript_path($file_name);
    return $this->tag('script', '', ['src' => $path, 'type' => 'text/javascript']);
  }

  public function stylesheet_link_tag($file_name) {
    $path = $this->stylesheet_path($file_name);
    return $this->tag('link', '', ['href' => $path, 'rel' => 'stylesheet', 'type' => 'text/css'], true);
  }

  public function image_tag($file_name, $attributes = []) {
    $path = $this->image_path($file_name);
    return $this->tag('img', '', array_merge($attributes, ['src' => $path]), true);
  }

  public function link_to($content, $url = '', $attributes = []) {
    return $this->tag('a', $content, array_merge(['href' => $url], $attributes));
  }

  public function selected_class($path, $sensitive = false) {
    return $this->_class($path, 'selected', $sensitive);
  }

  public function current_class($path, $sensitive = false) {
    return $this->_class($path, 'current', $sensitive);
  }

  private function _class($path, $class_name, $sensitive = false) {
    $path = str_replace('/', '\/', $path);
    if ($sensitive) {
      $path .= '$';
    }
    preg_match("/^{$path}/", $this->current_path(), $matches);
    return (empty($matches) ? '' : " {$class_name} ");
  }
}
