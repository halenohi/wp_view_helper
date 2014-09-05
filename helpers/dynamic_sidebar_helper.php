<?php
trait DynamicSidebar {
  public function dynamic_sidebar($sidebar_id) {
    ob_start();
    dynamic_sidebar($sidebar_id);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
  }
}
