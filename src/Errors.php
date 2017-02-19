<?php namespace Chronicle;

class Errors {

  private $record;
  private $messages = [];

  public function __construct($record) {
    $this->record = $record;
  }

  public function add($attribute, $message) {
    $key = $attribute->name();
    if (!array_key_exists($key, $this->messages)) {
      $this->messages[$key] = [];
    }
    $this->messages[$key][] = $message;
  }

  public function messages() {
    return $this->messages;
  }

  public function full_messages() {
    $full_messages = [];
    foreach($this->messages as $attribute => $messages) {
      $full_messages = array_merge($full_messages, array_map(function($message) use ($attribute) {
        $name = $attribute->human_name();
        return "$name $message";
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
