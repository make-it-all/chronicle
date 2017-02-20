<?php namespace Chronicle\Validators;

class Presence extends AbstractValidator {

  public function execute() {

    if (empty($this->attribute->get())) {
      $this->record->errors()->add($this->attribute, 'cant be blank');
    }
  }
}
