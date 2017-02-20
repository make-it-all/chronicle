<?php namespace Chronicle\Validators;
/*
  Confirmation Validator: Validates whether any two strings are identicle,
                          if not then adds an error to the record.
  @contributers Chris Head
*/
class Confirmation extends AbstractValidator {

  public function execute() {
    $string = $this->options[0];
    if (!($this->attribute->get() === $string)) {
      $this->record->errors()->add($this->attribute, 'strings do not match');
    }
  }
}
