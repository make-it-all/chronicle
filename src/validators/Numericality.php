<?php namespace Chronicle\Validators;
/*
  Numericality Validator: Validates whether any value is composed entirely of
                          numbers, adds an error to the record if it is not.
  @Contributers: Christopher Head
*/
class
class Numericality extends AbstractValidator {

  public function execute() {
    if (!ctype_digit($this->attribute->get())) {
      $this->record->errors()->add($this->attribute, 'must be only numbers');
    }
  }
}
