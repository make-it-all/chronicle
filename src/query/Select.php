<?php namespace Chronicle\Query;

class Select extends AbstractQuery {
  use Parts\Where;

  public $class;
  public $table_name;

  private $executed = false;
  private $results;

  private $columns = [];
  private $order = [];
  private $limit;
  private $offset;

  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function select(...$columns) {
    if (empty($columns)) {
      $this->columns = ['1'];
    } else {
      $this->columns = array_merge($this->columns, $columns);
      $this->executed = false;
    }
    return $this;
  }

  public function order($order) {
    $this->order[] = $order;
    $this->executed = false;
    return $this;
  }
  public function limit($limit) {
    $this->limit = $limit;
    $this->executed = false;
    return $this;
  }

  public function offset($offset) {
    $this->offset = $offset;
    $this->executed = false;
    return $this;
  }

  public function toSQL() {
    $columns = empty($this->columns)? '*' : implode(', ', $this->columns);
    $from = 'FROM ' .$this->table_name;
    $where = empty($this->where)? '' : 'WHERE ' .implode(' AND ', $this->where);
    $order = empty($this->order)? '' : 'ORDER BY '.implode(', ', $this->order);
    $limit = ($this->limit == null)? '' : "LIMIT $this->limit";
    $offset = ($this->offset == null)? '' : "OFFSET $this->offset";
    return "SELECT $columns $from $where $order $limit $offset";
  }

  public function execute() {
    if ($this->executed === false) {
      $this->results = \Chronicle\Base::connection()->select($this->toSQL());
      $this->executed = true;
    }
    return $this->results;
  }

  public function results() {
    if ($this->results === null) {
      $this->results = new \Chronicle\RecordArray($this->class);
      $this->results->fromSQL($this);
    }
    return $this->results;
  }

  public function __toString() {
    return (string)$this->results();
  }

  public function __call($key, $args) {
    return $this->results()->$key($args);
  }

  public function __debugInfo() {
    return ['sql' => $this->toSQL(), 'executed' => $this->executed];
  }
}
