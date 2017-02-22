<?php namespace Chronicle\Connection;

class Adapter {
  use DatabaseStatements;

  //
  public function __construct($connection) {
    $this->connection = $connection;
  }

  //Allows the use of select queries
  public function select($sql) {
    return $this->execute($sql)->fetchAll();
  }

  //Allows the use of select all queries
  public function select_all($table_name) {
    $sql = "SELECT * FROM `$table_name`";
    return $this->execute($sql)->fetchAll();
  }

  //Allows the use of insert queries
  public function insert($sql) {
    return $this->execute($sql);
  }

  //Allows the use of update queries
  public function update($sql) {
    return $this->execute($sql);
  }

  //Allows the use of delete queries
  public function delete($sql) {
    return $this->execute($sql);
  }

  //Returns the number of rows in a given table
  public function count($table_name) {
    $sql = "SELECT COUNT(*) FROM `$table_name`";
    $result = $this->execute($sql);
    return $result->fetchColumn();
  }

  //Checks if the given table is in the database
  public function table_exists($table_name) {
    $sql = "SHOW TABLES LIKE '$table_name'";
    return $this->execute($sql)->rowCount() > 0;
  }

  //Returns an array of column names from a given table
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

  public function parse_attributes_for_insert($attributes) {
    $attrs = [];
    foreach($attributes as $attribute) {
      if (!$attribute->is_column()) { continue; }
      if (!$attribute->has_changed()) { continue; }
      var_dump($attribute->get());
      var_dump($attribute->get_was());
      $name = $this->sanitize_column_name($attribute->name());
      $val = $this->sanitize_value($attribute->get_for_db());
      $attrs[] = "$name=$val";
    }
    return implode(', ', $attrs);
  }

}
