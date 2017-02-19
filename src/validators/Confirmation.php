<?php namespace Chronicle\Validators;

class Confirmation extends AbstractValidator {

private $string;
// Ability to pass $string in validation call

  public function execute() {
    $string = 'Henry Morgan';
    if (!($this->attribute->get() === $string)) {
      $this->record->errors()->add($this->attribute->name(), 'strings do not match');
    }
  }
}
