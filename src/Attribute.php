<?php namespace Chronicle;


class Attribute {

  private $column, $name, $value, $value_was;

  public function __construct($column_or_name) {
    if ($column_or_name instanceof \Chronicle\Connection\Column) {
      $this->column = $column_or_name;
      $this->name = $column_or_name->name;
      $this->set_initial_value($column_or_name->default);
    } else {
      $this->name = (string)$column_or_name;
    }
  }

  public function set_initial_value($value) {
    $this->set($value);
    $this->value_was = $value;
  }

  public function name() {
    return $this->name;
  }

  public function get() {
    return $this->value;
  }

  public function get_was() {
    return $this->value_was;
  }

  public function set($value) {
    $this->value = $value;
  }

  public function reset() {
    $this->value = $this->value_was;
  }

  public function is_column() {
    return isset($this->column);
  }

  public function is_null() {
    return is_null($this->get());
  }

  public function has_changed() {
    return $this->get() !== $this->get_was();
  }

  public function human_name() {
    return implode(' ', explode('_', $this->name()));
  }

  public function get_for_db() {
    if (!$this->is_column()) { return $this->value; }
    return $this->column->cast_for_db($this->value);
  }

  public function attribute_methods($record, &$methods) {
    $methods["get_$this->name"] = [$this, 'get'];
    $methods["get_{$this->name}_was"] = [$this, 'get_was'];
    $methods["set_$this->name"] = [$this, 'set'];
    $methods["reset_$this->name"] = [$this, 'reset'];
  }

  public function __debugInfo() {
    return [$this->name => $this->get()];
  }

  public function __toString() {
    $key = $this->name();
    $value = $this->get();
    if ($value === null || is_scalar($value) || (is_object($value) && method_exists($value, '__toString'))) {
      $value = (string)$value;
    } else {
      $value = get_class($value);
    }
    return "$key: $value";
  }

}
