<?php namespace Chronicle\Validators;

abstract class AbstractValidator {

  protected $record;

  public function __construct($record, $attribute) {
    $this->record = $record;
    $this->attribute = $attribute;
  }

  abstract public function execute();

}
