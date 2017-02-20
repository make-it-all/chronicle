<?php namespace Chronicle\Validators;
/*
  ValidatesWith Validator: Validates whether any value against another function.
  @Contributers: Christopher Head
*/
class
class ValidatesWith extends AbstractValidator {

  public function execute() {
    $function_name = $this->options;
    $this->$funtion_name($this->attribute);
    }
  }
