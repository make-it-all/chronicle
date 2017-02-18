<?php namespace Chronicle\Connection;

class Adapter {
  use DatabaseStatements;

  public function __construct($connection) {
    $this->connection = $connection;
  }

  public function select($sql) {
    return $this->execute($sql)->fetchAll();
  }

  public function select_all($table_name) {
    $sql = "SELECT * FROM `$table_name`";
    return $this->execute($sql)->fetchAll();
  }

  public function insert($sql) {
    return $this->execute($sql);
  }

  public function update($table_name, $attributes) {
    return $this->execute($sql);
  }

  public function delete($sql) {
    return $this->execute($sql);
  }

  public function count($table_name) {
    $sql = "SELECT COUNT(*) FROM `$table_name`";
    $result = $this->execute($sql);
    return $result->fetchColumn();
  }
  public function table_exists($table_name) {
    $sql = "SHOW TABLES LIKE '$table_name'";
    return $this->execute($sql)->rowCount() > 0;
  }

  public function columns($table_name) {
    $sql = "SHOW FIELDS FROM $table_name";
    $columns = [];
    foreach($this->execute($sql) as $field) {
      $columns[] = new Column($field['Field'], $field['Type'], $field['Default'], $field['Null'] == 'YES');
    }
    return $columns;
  }

  public function quote($value) {
    return $this->connection->quote($value);
  }

  public function execute($sql) {
    return $this->connection->query($sql);
  }

  /*
    'str' => 'str',
    123 => '123',
    false => '0|f|false',
    true => '1|t|true',
    null => 'null'
  */
  public function sanitize_value($value) {
    if (is_null($value)) {
      return "NULL";
    }
    if (is_bool($value)) {
      return ($value)? "'1'" : "'0'";
    }
    $value = $this->quote($value);
    return "$value";
  }

  public function sanitize_column_name($name) {
    return "`$name`";
  }

  // (column1,column2,column3,...) VALUES (value1,value2,value3,...);
  public function parse_attributes_for_insert($attributes) {
    $cols = [];
    $vals = [];
    $sql = '';
    foreach($attributes as $attribute) {
      if (!$attribute->is_column()) { continue; }
      $cols[] = $this->sanitize_column_name($attribute->name());
      $vals[] = $this->sanitize_value($attribute->get_for_db());
    }
    $cols = implode(',', $cols);
    $vals = implode(',', $vals);
    return "($cols) VALUES ($vals)";
  }

}
