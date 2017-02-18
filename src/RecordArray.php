<?php namespace Chronicle;

class RecordArray implements \ArrayAccess, \Iterator {

  private $_ids;
  private $_records;
  private $query;
  private $loaded = false;
  public function __construct($class) {
    $this->class = $class;
    $this->table_name = $class::$table_name ?? null;
  }

  public function from_pdo_results($results) {
    $this->_records = [];
    foreach($results as $result) {
      $record = $this->class::new_from_result($result);
      $record->new_record = false;
      $this->_records[] = $record;
    }
  }

  public function fromSQL($query) {
    $this->query = $query;
  }

  public function load() {
    if ($this->loaded == false && isset($this->query)) {
      $this->from_pdo_results($this->query->execute());
      $this->loaded = true;
    }
  }

  public function load_ids() {
    if ($this->_ids == null) {
      $this->_ids = array_map(function($rec){
        return $rec->id();
      }, $this->records());
    }
    return $this->_ids;
  }

  public function ids() {
    return $this->_ids ?? $this->load_ids();
  }

  public function records() {
    $this->load();
    return $this->_records;
  }

  public function first() {
    $records = $this->records();
    return $records[0] ?? null;
  }

  public function last() {
    $records = $this->records();
    return end($records);
  }
  public function count() {
    return sizeof($this->records());
  }
  public function empty() {
    return $this->count() == 0;
  }
  public function any() {
    return !$this->empty();
  }


  //----- ArrayAccess - Methods
  public function offsetExists($key) {
    return isset($this->records()[$key]);
  }
  public function offsetUnset($key) {
    unset($this->records()[$key]);
  }
  public function offsetSet($key, $value) {
    if (is_null($key)) {
      $this->records()[] = $value;
    } else {
      $this->records()[$key] = $value;
    }
  }
  public function offsetGet($key) {
    return isset($this->records()[$key]) ? $this->records()[$key] : null;
  }

  //----- Iterator - Methods
  public function current(){
    $this->load();
    return current($this->_records);
  }
  public function next() {
    $this->load();
    return next($this->_records);
  }
  public function key() {
    $this->load();
    return key($this->_records);
  }
  public function valid() {
    $this->load();
    return $this->offsetExists($this->key());
  }
  public function rewind() {
    $this->load();
    return reset($this->_records);
  }

  public function __toString() {
    $records = array_slice($this->records(), 0, 3);
    $records_string = implode(', ', array_map(function($record){return (string)$record;}, $records));
    if (sizeof($this->records()) > 3) {
      $records_string.= '...';
    }
    $count = $this->count();
    return "RecordArray($count $this->class){{$records_string}}";
  }

}
