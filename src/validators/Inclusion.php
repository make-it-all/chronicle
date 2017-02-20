<?php namespace Chronicle\Validators;
/*
  Inclusion Validator: Validates whether any value is included within an array,
                       if not, then adds an error to the record.
  @contributers Chris Head
*/
class
class Inclusion extends AbstractValidator {

  public function execute() {
    $inclusions = $this->options;
    if (!(in_array($this->attribute->get(), $inclusions))) {
      $this->record->errors()->add($this->attribute, 'is not included in the list');
    }
  }
}
