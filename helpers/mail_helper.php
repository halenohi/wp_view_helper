<?php
trait MailHelper {
  private $_mail;

  public function mail() {
    if (!$this->_mail) {
      $this->_mail = new WPViewHelper_Mail();
    }
    return $this->_mail;
  }
}

class WPViewHelper_Mail {
  private $_smtp;

  function __construct() {
    require_once dirname(__FILE__) . '/lib/Mail.php';
    date_default_timezone_set('Asia/Tokyo');
  }

  public function smtpConfig($options) {
    $this->_smtp = Mail::factory('smtp', $options);
  }

  public function send($options) {
    $headers = [
      'From' => $options['from'],
      'To' => $options['to'],
      'Subject' => $options['subject']
    ];
    $result = $this->_smtp->send($options['to'], $headers, $options['body']);
    return PEAR::isError($mail);
  }
}
