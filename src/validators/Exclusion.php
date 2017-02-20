<?php namespace Chronicle\Validators;
/*
  Exclusion Validator: Validates whether any value is included within an array,
                       if it is, then adds an error to the record.
  @contributers Chris Head
*/
class Exclusion extends AbstractValidator {

  public function execute() {
    $exclusions = $this->options;
    if (in_array($this->attribute->get(), $exclusions)) {
      $this->record->errors()->add($this->attribute, 'is reserved');
    }
  }
}
