<?php namespace Chronicle\Validators;
/*
  ValidatesWith Validator: Validates whether any value against another function.
  @contributers Chris Head
*/
class ValidatesWith extends AbstractValidator {

  public function execute() {
    $function_name = $this->options;
    $this->$function_name($this->attribute);
  }

}
