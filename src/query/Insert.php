<?php namespace Chronicle\Query;

class Insert extends AbstractQuery {

  private $executed = false;
  private $attributes;

  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function set_attributes($attributes) {
    $this->attributes = $attributes;
  }

  public function toSQL() {
    $into = 'INTO ' .$this->table_name;
    $values = $this->connection()->parse_attributes_for_insert($this->attributes);
    return "INSERT $into $values";
  }

  public function execute() {
    if (!$this->executed) {
      $this->results = $this->connection()->insert($this->toSQL());
      $this->executed = true;
    }
    return $this->results;
  }

  public function results() {
    return $this->execute();
  }

}
