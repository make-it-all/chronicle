<?php namespace Chronicle\Validators;

class Absence extends AbstractValidator {

  public function execute() {
    if (!empty($this->attribute->get())) {
      $this->record->errors()->add($this->attribute, 'must be blank');
    }
  }
}
