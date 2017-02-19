<?php namespace Chronicle\Validators;

class Inclusion extends AbstractValidator {

  public function execute() {
    $inclusions = $this->options;
    if (!(in_array($this->attribute->get(), $inclusions))) {
      $this->record->errors()->add($this->attribute->name(), 'is not included in the list');
    }
  }
}
