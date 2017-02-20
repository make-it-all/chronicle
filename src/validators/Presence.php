<?php namespace Chronicle\Validators;
/*
  Presence Validator: Validates whether any value is not empty, adds an error to
                      the record if the value is null, comprised of only
                      whitespace or contains no characters.
  @contributers Chris Head
*/
class Presence extends AbstractValidator {

  public function execute() {

    $val = $this->attribute->get();
    if (is_bool($val)) {
      return;
    }
    if (!isset($val) || ctype_space($val) || (mb_strlen($val,'utf8') < 1)) {
      $this->record->errors()->add($this->attribute, 'cant be blank');
    }
  }
}
