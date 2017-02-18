<?php namespace Chronicle;

class Errors {

  private $record;
  private $messages = [];

  public function __construct($record) {
    $this->record = $record;
  }

  public function add($attribute, $message) {
    if (!array_key_exists($attribute, $this->messages)) {
      $this->messages[$attribute] = [];
    }
    $this->messages[$attribute][] = $message;
  }

  public function messages() {
    return $this->messages;
  }

  public function full_messages() {
    $full_messages = [];
    foreach($this->messages as $attribute => $messages) {
      $full_messages = array_merge($full_messages, array_map(function($message) use ($attribute) {
        return "$attribute $message";
      }, $messages));
    }
    return $full_messages;
  }

  public function empty() {
    return empty($this->messages());
  }

  public function any() {
    return !$this->empty();
  }

  public function __debugInfo() {
    return ['errors' => $this->messages()];
  }

}
