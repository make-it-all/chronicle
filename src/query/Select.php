<?php namespace Chronicle\Query;

class Select extends AbstractQuery {
  use Parts\Where;

  public $class;
  public $table_name;

  private $executed = false;
  private $query_results;
  private $record_array;

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
      $this->query_results = \Chronicle\Base::connection()->select($this->toSQL());
      $this->executed = true;
    }
    return $this->query_results;
  }

  public function results() {
    if ($this->record_array === null) {
      $this->record_array = new \Chronicle\RecordArray($this->class);
      $this->record_array->fromSQL($this);
    }
    return $this->record_array;
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


    //
    //
    //
    // //----- ArrayAccess - Methods
    // public function offsetExists($key) {
    //   return isset($this->results()[$key]);
    // }
    // public function offsetUnset($key) {
    //   unset($this->results()[$key]);
    // }
    // public function offsetSet($key, $value) {
    //   if (is_null($key)) {
    //     $this->results()[] = $value;
    //   } else {
    //     $this->results()[$key] = $value;
    //   }
    // }
    // public function offsetGet($key) {
    //   return isset($this->results()[$key]) ? $this->results()[$key] : null;
    // }
    //
    // //----- Iterator - Methods
    // public function current(){
    //   $this->results();
    //   return current($this->record_array);
    // }
    // public function next() {
    //   $this->results();
    //   return next($this->record_array);
    // }
    // public function key() {
    //   $this->results();
    //   return key($this->record_array);
    // }
    // public function valid() {
    //   $this->results();
    //   return $this->offsetExists($this->key());
    // }
    // public function rewind() {
    //   $this->results();
    //   return reset($this->record_array);
    // }



}
