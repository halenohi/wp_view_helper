<?php
trait DebugHelper {
  function pr($arg) {
    if (defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY) {
      echo '<pre>';
      print_r($arg);
      echo '</pre>';
    }
  }
}
