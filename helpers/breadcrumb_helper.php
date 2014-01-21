<?php
trait BreadcrumbHelper {
  private $default_results = [ [ 'name' => 'Home', 'path' => '/' ] ];

  public function breadcrumbs() {
    $items = $this->getItems();
    if (count($items) === 0) {
      return $this->default_results;
    }
    if (is_category()) {
      return $this->parseForCategory($items);

    } elseif (is_archive()) {
      if ($items[0] === 'author') {
        return $this->parseForAuthor($items);
      } elseif ($items[0] === 'tag') {
        return $this->parseForTag($items);
      } else {
        return $this->parseForArchive($items);
      }

    } elseif (is_author()) {
      return $this->parseForAuthor($items);

    } elseif (is_single()) {
      return $this->parseForSingle($items);

    } elseif (is_page()) {
      return $this->parseForPage($items);

    } elseif (is_404()) {
      return $this->parseFor404();

    } else {
      return $this->default_results;
    }
  }

  private function getItems() {
    $result = [];
    $items = explode('/', $this->requestPath());
    foreach ($items as $item) {
      if (!empty($item)) {
        $result[] = $item;
      }
    }
    return $result;
  }

  private function requestPath() {
    return (!empty($_REQUEST['q']) ? $_REQUEST['q'] : '');
  }

  private function parseForCategory($items, $merge_default = true) {
    return $this->parse($items, function($item) {
      $cat = get_category_by_slug($item);
      return $cat->name;
    }, $merge_default);
  }

  private function parseForArchive($items, $merge_default = true) {
    return $this->parse($items, function($item) {
      if (preg_match('/^[0-9]{4}$/', $item)) {
        return $item . '年';
      } elseif (preg_match('/^[0-9]{2}$/', $item)) {
        if (preg_match('/^0/', $item)) {
          $item = substr($item, -1);
        }
        return $item . '月';
      }
    }, $merge_default);
  }

  private function parseForAuthor($items) {
    return $this->parse($items, function($item) {
      if ($item === 'author') {
        return false;
      } else {
        $user = get_user_by('login', $item);
        return $user->data->display_name;
      }
    });
  }

  private function parseForSingle($items) {
    $cats = [];
    $archives = [];
    $post_results = [];
    foreach ($items as $i => $item) {
      if (preg_match('/^([0-9]{4})|([0-9]{2})$/', $item)) {
        $archives[] = $item;
      } elseif (count($items) !== $i + 1) {
        $cats[] = $item;
      } else {
        $post = get_posts([
          'post_name' => $item,
          'post_type' => 'post',
          'post_status' => 'publish',
          'posts_per_page' => 1
        ])[0];
        $post_result['name'] = $post->post_title;
        $post_result['path'] = $this->requestPath();
        $post_results[] = $post_result;
      }
    }
    $cat_results = $this->parseForCategory($cats, false);
    $archive_results = $this->parseForArchive($archives, false);
    return array_merge($this->default_results, $cat_results, $archive_results, $post_results);
  }

  private function parseForPage($items) {
    return $this->parse($items, function($item) {
      $page = get_posts([
        'post_name' => $item,
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1
      ])[0];
      return $page->post_title;
    });
  }

  private function parseForTag($items) {
    return $this->parse($items, function($item) {
      if ($item === 'tag') {
        return false;
      } else {
        $tag = get_term_by('slug', $item, 'post_tag');
        return 'タグ: ' . $tag->name;
      }
    });
  }

  private function parseFor404() {
    return array_merge($this->default_results, [
      [
        'name' => 'ページが見つかりませんでした',
        'path' => $this->requestPath()
      ]
    ]);
  }

  private function parse($items, $iterator, $merge_default = true) {
    $results = [];
    foreach ($items as $i => $item) {
      $name = $iterator($item);
      if ($name) {
        $path_items = array_slice($items, 0, ($i + 1));
        $result = [];
        $result['name'] = $name;
        $result['path'] = '/' . implode('/', $path_items);
        $results[] = $result;
      }
    }
    if ($merge_default) {
      return array_merge($this->default_results, $results);
    } else {
      return $results;
    }
  }
}
