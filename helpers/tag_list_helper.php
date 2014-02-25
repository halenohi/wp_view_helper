<?php
trait TagListHelper {
  public function tagList() {
    $max_level = $this->tagListMaxLevel();
    $tags = get_terms('post_tag', 'hide_empty=1&orderby=count&order=DESC');
    $max_count = $tags[0]->count;
    $result = [];

    if ($max_count >= $max_level) {
      $unit = $max_count / $max_level;
      $setted = [];
      for ($i = 1; $i <= $max_level; $i++) {
        $i_str = (string)$i;
        $result[$i_str] = @$result[$i_str] || [];
        $current_level = floor($unit * $i);
        foreach ($tags as $_i => $tag) {
          if ($tag->count <= $current_level && !in_array($tag->term_id, $setted)) {
            $result[$i_str][] = $tag;
            $setted[] = $tag->term_id;
          }
        }
      }
    } else {
      $result['1'] = $tags;
    }
    $result = array_reverse($result);
    return $result;
  }

  public function tagListMaxLevel() {
    return 4;
  }

  public function getCurrentTagListLevel($i) {
    return $this->tagListMaxLevel() - $i;
  }
}
