<?php namespace Chronicle\Query;

class Delete extends AbstractQuery {
  use Parts\Where;

  private $executed = false;


  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function toSQL() {
    $from = 'FROM ' .$this->table_name;
    $where = empty($this->where)? '' : 'WHERE ' .implode(' AND ', $this->where);
    return "DELETE $from $where";
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
