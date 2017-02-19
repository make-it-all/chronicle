<?php namespace Chronicle\Validators;

class Acceptance extends AbstractValidator {

  public function execute() {
    if ($this->attribute->get() == '0') {
      $this->record->errors()->add($this->attribute->name(), 'must be accepted');
    }
  }
}
