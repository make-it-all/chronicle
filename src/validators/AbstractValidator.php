<?php namespace Chronicle\Validators;

/*
  AbstractValidator:

  @Contributers: Henry Morgan                   

*/

abstract class AbstractValidator {

  protected $record;
  protected $attribute;
  protected $options;

  public function __construct($record, $attribute, $options) {
    $this->record = $record;
    $this->attribute = $attribute;
    $this->options = $options;
  }

  abstract public function execute();

}
