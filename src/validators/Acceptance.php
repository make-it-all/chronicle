<?php namespace Chronicle\Validators;
/*
  Acceptance Validator: Validates whether any value is truthy, if not then adds
                        an error to the record.
  @Contributers: Christopher Head
*/
class Acceptance extends AbstractValidator {

  public function execute() {
    if ($this->attribute->get() != true) {
      $this->record->errors()->add($this->attribute->name(), 'must be accepted');
    }
  }
}
