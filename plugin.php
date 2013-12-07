<?php
/*
Plugin Name: WPViewHelper
Version: 0.1
Plugin URI: https://github.com/halenohi/wp_view_helper
Description: ViewHelper for WordPress development
Author: kozo yamagata
*/

$helper_names = [
  'asset',
  'tag',
  'pagination',
  'url',
  'archive',
  'debug'
];

foreach ($helper_names as $helper_name) {
  require_once dirname(__FILE__) . '/helpers/' . $helper_name . '_helper.php';
}

class WPViewHelper {
  use TagHelper;
  use PaginationHelper;
  use UrlHelper;
  use ArchiveHelper;
  use AssetHelper;
  use DebugHelper;

  public function __construct() {
    $this->__asset_helper_construct();
  }
}

$helper = new WPViewHelper;