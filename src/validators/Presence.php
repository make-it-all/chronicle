<?php namespace Chronicle\Validators;

class Presence extends AbstractValidator {

  public function execute() {

    $val = $this->attribute->get();
    if (isset($val) && !ctype_space($val)) {
      $this->record->errors()->add($this->attribute, 'cant be blank');
    }
  }
}
