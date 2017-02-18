<?php namespace Chronicle;

trait Validation {

  protected static $validations;

  private $errors;
  private $validators;


  private function parse_validations() {
    if ($this->validators !== null) { return; }
    foreach((static::$validations ?? []) as $attribute => $validations) {
      if (!$this->is_attribute($attribute)) {
        throw new InvalidAttribute($attribute);
      }
      foreach($validations as $validation => $options) {
        switch ($validation) {
          case 'presence':
            $validator = new Validators\Presence($this, $this->get_attribute($attribute));
            break;
        }
        $this->validators[] = $validator;
      }
    }
  }

  public function errors() {
    return $this->errors;
  }

  public function validate() {
    $this->parse_validations();
    $this->errors = new Errors($this);
    array_map(function($validator) {$validator->execute();}, $this->validators);
    return $this->errors->any();
  }

}
