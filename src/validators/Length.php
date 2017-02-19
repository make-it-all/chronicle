<?php namespace Chronicle\Validators;

class Length extends AbstractValidator {

private $value;
//Ability to pass $value as option in validation call

  public function execute() {
    $value = 10;
    if (strlen($this->attribute->get()) != $value) {
      $this->record->errors()->add($this->attribute->name(), 'length is invalid');
    }
  }
}
