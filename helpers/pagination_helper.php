<?php
trait PaginationHelper {
  private $html = '';
  private $current_page = 1;
  private $total_pages = 0;
  private $options = ['range' => 5];

  public function pagination($options = []) {
    $this->options = array_merge($this->options, $options);
    $this->set_current_page();
    $this->set_total_pages();
    if ($this->total_pages > 1) {
      $this->html .= '<ol class="pagination">';
      $this->append_page_links();
      $this->html .= '</ol>';
    }
    return $this->html;
  }

  public function set_current_page() {
    global $wp_query;
    if (array_key_exists('paged', $wp_query->query)) {
      $paged = (int)esc_html($wp_query->query['paged']);
      if ($paged > 0) {
        $this->current_page = $paged;
        return;
      }
    }
    $this->current_page = 1;
  }

  public function set_total_pages() {
    global $wp_query;
    if (($max_num_pages = $wp_query->max_num_pages)) {
      $this->total_pages = $max_num_pages;
    } else {
      $this->total_pages = 1;
    }
  }

  public function append_page_links() {
    list($num, $max_num) = $this->calc_base_and_max_num();
    while ($num <= $max_num) {
      if ($num == $this->current_page) {
        $this->html .= $this->tag('li', $num, ['class' => 'page current']);
      } else {
        $link = $this->link_to($num, get_pagenum_link($num));
        $this->html .= $this->tag('li', $link, ['class' => 'page']);
      }
      $num++;
    }
  }

  public function calc_base_and_max_num() {
    $base_num = $this->current_page >= ($this->options['range'] - 1) ? ($this->current_page - 2) : 1;
    $max_num = null;
    if ($this->total_pages <= $this->options['range']) {
      $max_num = $this->total_pages;
    } else {
      $max_num = $base_num + $this->options['range'] - 1;
      if ($max_num > $this->total_pages) {
        $max_num = $this->total_pages;
      }
    }
    $shortage = $max_num - ($base_num - 1);
    if ($shortage < $this->options['range']) {
      $base_num -= ($this->options['range'] - $shortage);
      $base_num = $base_num < 1 ? 1 : $base_num;
    }
    return [$base_num, $max_num];
  }
}
