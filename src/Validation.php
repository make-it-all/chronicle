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
          case 'uniquiness':
            $validator = new Validators\Uniqueness($this, $this->get_attribute($attribute));
            break;
          case 'acceptance':
            $validator = new Validators\Acceptance($this, $this->get_attribute($attribute));
            break;
          case 'exclusion':
            $validator = new Validators\Exclusion($this, $this->get_attribute($attribute));
            break;
          case 'inclusion':
            $validator = new Validators\Inclusion($this, $this->get_attribute($attribute));
            break;
          case 'length':
            $validator = new Validators\Length($this, $this->get_attribute($attribute));
            break;
          case 'numericality':
            $validator = new Validators\Numericality($this, $this->get_attribute($attribute));
            break;
          case 'absence':
            $validator = new Validators\Absence($this, $this->get_attribute($attribute));
            break;
          case 'confirmation':
            $validator = new Validators\Confirmation($this, $this->get_attribute($attribute));
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
