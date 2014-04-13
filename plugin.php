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
  'debug',
  'page_title',
  'page_description',
  'author_list',
  'breadcrumb',
  'search_query',
  'rss_thumbnail',
  'custom_post_type',
  'form',
  'mail',
  'tag_list'
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
  use PageTitleHelper;
  use PageDescriptionHelper;
  use AuthorListHelper;
  use BreadcrumbHelper;
  use SearchQueryHelper;
  use RssThumbnailHelper;
  use CustomPostTypeHelper;
  use FormHelper;
  use MailHelper;
  use TagListHelper;

  public function __construct() {
    $this->__asset_helper_construct();
    $this->__rss_thumbnail_helper_construct();
    $this->__custom_post_type_construct();
  }

  static function setOptions() {
    update_option('permalink_structure', '/%category%/%year%/%monthnum%/%postname%');
    update_option('home', preg_replace('/\/wp$/', '', get_option('home')));
  }
}

//register_activation_hook(__FILE__, ['WPViewHelper', 'setOptions']);
$helper = new WPViewHelper;
