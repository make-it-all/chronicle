<?php namespace Chronicle\Validators;

class Numericality extends AbstractValidator {

  public function execute() {
    if (!ctype_digit($this->attribute->get())) {
      $this->record->errors()->add($this->attribute, 'must be only numbers');
    }
  }
}
