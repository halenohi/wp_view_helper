<?php
trait CustomPostTypeHelper {
  public function __custom_post_type_construct() {
    $custom_post_types = [];
    foreach ($this->getConfigs() as $config_json) {
      $post_type_config = json_decode(file_get_contents($config_json));
      $custom_post_types[] = $post_type_config;
      $this->register($post_type_config);
    }
    add_action('admin_init', [$this, 'adminInit']);
  }

  private function getConfigs() {
    $custom_post_types_dir = get_template_directory() . '/custom_post_types';
    return glob($custom_post_types_dir . '/*.json');
  }

  public function register($config) {
    $options = [
      'labels' => [
        'singuler_name' => $config->name,
        'add_new_item' => "{$config->name}を新規登録",
        'add_new' => '新規登録',
        'edit_item' => "{$config->name}を編集",
        'new_item' => "新規{$config->name}",
        'view_item' => "{$config->name}を表示",
        'not_found' => "{$config->name}は見つかりませんでした",
        'not_found_in_trash' => "ゴミ箱に{$config->name}はありません",
        'search_items' => "{$config->name}を検索",
        'parent_item_colon' => ''
      ],
      'public' => true,
      'show_ui' => true,
      'query_var' => false,
      'capability_type' => 'post',
      'hierarchical' => false,
      'menu_position' => 5,
      'supports' => [
        'title',
        'author'
      ]
    ];
    // register_post_type($config->post_type, $options);
    // flush_rewrite_rules(false);
  }

  public function adminInit() {
    foreach ($this->custom_post_types as $type) {
      add_meta_box("{$type->post_type}-meta-box", "{$type->name}情報", [$this, "{$type->post_type}MetaBox"], $type->post_type);
    }
  }

  public function __call($name, $args) {
    
  }
}
