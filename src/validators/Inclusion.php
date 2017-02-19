<?php namespace Chronicle\Validators;

class Inclusion extends AbstractValidator {

private $inclusions;
// Ability to set $inclusions either elsewhere or in call

  public function execute() {
    $inclusions = [];
    if (!(in_array($this->attribute->get(), $inclusions))) {
      $this->record->errors()->add($this->attribute->name(), 'is not included in the list');
    }
  }
}
