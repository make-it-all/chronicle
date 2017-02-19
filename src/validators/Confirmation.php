<?php namespace Chronicle\Validators;

class Confirmation extends AbstractValidator {

  public function execute() {
    $string = $this->options[0];
    if (!($this->attribute->get() === $string)) {
      $this->record->errors()->add($this->attribute->name(), 'strings do not match');
    }
  }
}
