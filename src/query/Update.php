<?php namespace Chronicle\Query;

class Update extends AbstractQuery {
  use Parts\Where;

  private $executed = false;
  private $set = []

  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function set($attrs) {
    $this->set = array_merge($this->set, $attrs);
  }

  private function parseSet() {
    $attrs = [];
    foreach($this->set as $key=>$value) {
      switch (gettype($value)) {
        case 'Boolean':
          $value = ($value)?'0':'1';
          break;
      }
      $attrs[] = "$key=$value";
    }
    return implode(',', $attrs);
  }
  public function toSQL() {
    $from = $this->table_name;
    $set = 'SET ' . $this->parseSet();
    $where = empty($this->where)? '' : 'WHERE ' .implode(' AND ', $this->where);
    return "UPDATE $from $where";
  }

  public function execute() {
    if (!$this->executed) {
      $this->results = \Chronicle\Base::connection()->delete($this->toSQL());
      $this->executed = true;
    }
    return $this->results;
  }

  public function results() {
    return $this->execute();
  }

}
