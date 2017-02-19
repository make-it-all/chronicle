<?php namespace Chronicle\Validators;

class Exclusion extends AbstractValidator {

  public function execute() {
    $exclusions = $this->options;
    if (in_array($this->attribute->get(), $exclusions)) {
      $this->record->errors()->add($this->attribute->name(), 'is reserved');
    }
  }
}
