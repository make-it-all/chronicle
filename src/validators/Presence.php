<?php namespace Chronicle\Validators;

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
