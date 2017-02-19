<?php namespace Chronicle\Validators;

class ValidatesWith extends AbstractValidator {

  public function execute() {
    $function_name = $this->options;
    $this->$funtion_name($this->attribute);
    }
  }
