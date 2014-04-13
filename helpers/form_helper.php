<?php
trait FormHelper {
  private $_form;

  public function form() {
    if (!$this->_form) {
      $this->_form = new WPViewHelper_Form();
    }
    return $this->_form;
  }
}

class WPViewHelper_Form {
  public $options;
  public $errors;
  private $req_method;

  function __construct() {
    $this->req_method = $_SERVER['REQUEST_METHOD'];
    $this->errors = [];
  }

  public function config($options) {
    $this->options = $options;

    if ($this->isPost()) {
      $this->params = $_POST[$this->options['param_root']];
    } else {
      $this->params = [];
    }
  }

  public function isValid() {
    if ($this->isGet()) return true;
    $result = true;
    foreach ($this->options['fields'] as $field) {
      $param = $this->params[$field['name']];
      if ($field['require'] && empty($param)) {
        $result = false;
        $this->errors[$field['name']] =
          "{$field['name_ja']}は必須項目です";
        if (!$result) break;
      }
    }
    return $result;
  }

  public function isGet() {
    return $this->req_method === 'GET';
  }

  public function isPost() {
    return $this->req_method === 'POST';
  }
}

