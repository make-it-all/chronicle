<?php namespace Chronicle\Validators;

/*
  Absence Validator: Validates whether any value is not empty,
                     if not then adds an error to the record.

  @Contributers: Christopher Head                  

*/

class Absence extends AbstractValidator {

  public function execute() {
    if (!empty($this->attribute->get())) {
      $this->record->errors()->add($this->attribute, 'must be blank');
    }
  }
}
