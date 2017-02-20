<?php namespace Chronicle\Validators;

/*
  Length Validator: Validates whether any string's length is equal to, smaller
                    than or greater than a given value, or within a range of
                    values. An error is added to the record if it fails its
                    specific test.

  @Contributers: Christopher Head

*/

class
class Length extends AbstractValidator {

  // Tests whether a string's length is within a range of values.
  public function execute() {
    $limit = $this->options;
    if (count($limit) == 4) {
      if ((mb_strlen($this->attribute->get(),'utf8')) < $limit[1] || mb_strlen($this->attribute->get(),'utf8') > $limit[3]) {
        $this->record->errors()->add($this->attribute, "length must be between $limit[1] and $limit[3] characters long.");
     }
   }
   //Tests if a string's length to equal to another value.
    else if ($limit[0] === 'equal') {
      if ((mb_strlen($this->attribute->get(),'utf8')) != $limit[1]) {
        $this->record->errors()->add($this->attribute, "length must be $limit[1] characters long");
      }
    }
    //Tests if a strings's length is greater than a value.
    else if ($limit[0] === 'min') {
      if ((mb_strlen($this->attribute->get(),'utf8')) < $limit[1]) {
        $this->record->errors()->add($this->attribute, "length is too short, must be at least $limit[1] characters long.");
      }
    }
    //Tests if a string's length is smaller than a value.
    else if ($limit[0] === 'max') {
      if ((mb_strlen($this->attribute->get(),'utf8')) > $limit[1]) {
        $this->record->errors()->add($this->attribute, "length is too long, must be less than $limit[1] characters long.");
      }
    }
  }
}
