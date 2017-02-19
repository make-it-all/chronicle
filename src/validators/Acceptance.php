<?php namespace Chronicle\Validators;

class Acceptance extends AbstractValidator {

  public function execute() {
    if ($this->attribute->get() != true) {
      $this->record->errors()->add($this->attribute->name(), 'must be accepted');
    }
  }
}
