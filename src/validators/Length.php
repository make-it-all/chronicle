<?php namespace Chronicle\Validators;

class Length extends AbstractValidator {

  public function execute() {
    $limit = $this->options;
    if (count($limit) == 4) {
      if (strlen($this->attribute->get()) < $limit[1] || strlen($this->attribute->get()) > $limit[3]) {
        $this->record->errors()->add($this->attribute, "length must be between $limit[1] and $limit[3] characters long.");
     }
   }
    else if ($limit[0] === 'equal') {
      if (strlen($this->attribute->get()) != $limit[1]) {
        $this->record->errors()->add($this->attribute, "length must be $limit[1] characters long");
      }
    }
    else if ($limit[0] === 'min') {
      if (strlen($this->attribute->get()) < $limit[1]) {
        $this->record->errors()->add($this->attribute, "length is too short, must be at least $limit[1] characters long.");
      }
    }
    else if ($limit[0] === 'max') {
      if (strlen($this->attribute->get()) > $limit[1]) {
        $this->record->errors()->add($this->attribute, "length is too long, must be less than $limit[1] characters long.");
      }
    }
  }
}
