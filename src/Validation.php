<?php namespace Chronicle;

trait Validation {

  protected static $validations;

  private $errors;
  private $validators;

  private function parse_validations() {
    if ($this->validators !== null) { return; }
    $this->validators = [];
    foreach((static::$validations ?? []) as $attribute => $validations) {
      if (!$this->is_attribute($attribute)) {
        throw new InvalidAttribute($attribute);
      }
      $attribute = $this->get_attribute($attribute);
      foreach($validations as $validation => $options) {
        switch ($validation) {
          case 'presence':
            $validator = new Validators\Presence($this, $attribute, $options);
            break;
          case 'uniquiness':
            $validator = new Validators\Uniqueness($this, $attribute, $options);
            break;
          case 'acceptance':
            $validator = new Validators\Acceptance($this, $attribute, $options);
            break;
          case 'exclusion':
            $validator = new Validators\Exclusion($this, $attribute, $options);
            break;
          case 'inclusion':
            $validator = new Validators\Inclusion($this, $attribute, $options);
            break;
          case 'length':
            $validator = new Validators\Length($this, $attribute, $options);
            break;
          case 'numericality':
            $validator = new Validators\Numericality($this, $attribute, $options);
            break;
          case 'absence':
            $validator = new Validators\Absence($this, $attribute, $options);
            break;
          case 'confirmation':
            $validator = new Validators\Confirmation($this, $attribute, $options);
            break;
        }
        $this->validators[] = $validator;
      }
    }
  }

  public function errors() {
    if (is_null($this->errors)) {
      $this->errors = new Errors($this);
    }
    return $this->errors;
  }

  public function validate() {
    $this->parse_validations();
    $this->errors = new Errors($this);
    array_map(function($validator) {$validator->execute();}, $this->validators);
    return $this->errors()->empty();
  }

}
