<?php namespace Chronicle\Validators;

class Exclusion extends AbstractValidator {

private $exclusions;
// Ability to set $exclusions either elsewhere or in call

  public function execute() {
    $exclusions = [];
    if (in_array($this->attribute->get(), $exclusions)) {
      $this->record->errors()->add($this->attribute->name(), 'is reserved');
    }
  }
}
