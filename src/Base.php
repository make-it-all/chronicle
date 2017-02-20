<?php namespace Chronicle;

/*
  It provides a variety of methods designed to manipulate, validate, query, and alter
  the database a simplistic and meaningful way.

  This model provides validations for all fields where the data is required to
  follow a format. for instance some data may be invalid if not present, or to long

  YADA YADA.... TODO

*/
class Base {

  use Connection\Connection;
  use Attributes;
  use Persistence;
  use Finders;
  use Updaters;
  use Validation;

  public static $table_name;
  private static $columns = [];
  public static $columns_names;

  //
  protected function __construct($attributes=[], $new_record=true) {
    $this->set_attributes_from_columns();

    $this->is_new_record = $new_record;

    if ($new_record) {
      $this->assign_attributes($attributes);
    } else {
      $this->assign_initial_attributes($attributes);
    }

  }

  //
  public static function new($attributes=[]) {
    $cls = get_called_class();
    return new $cls($attributes);
  }

  //
  public static function new_from_result($attributes=[]) {
    $cls = get_called_class();
    $record = new $cls($attributes, false);
    return $record;
  }

  //
  public function send_callback($callback) {
    if (method_exists($this, $callback)) {
      $this->$callback();
    }
  }

  //Counts the number of entries in the current database
  public static function count() {
    return self::connection()->count(static::$table_name);
  }

  //Checks if current table is present in the databse
  public static function table_exists() {
    return self::connection()->table_exists(static::$table_name);
  }

  //Extracts the attributes from each column and saves them into the attributes array of the
  //current object
  public function set_attributes_from_columns() {
    $cols = static::columns();
    array_walk($cols, function($column){
      $this->add_attribute($column);
    });
  }

  //Gets all the columns in the selected table for the class which called the method
  //returned as an array
  public static function columns() {
    if (!isset(self::$columns[get_called_class()])) {
      self::$columns[get_called_class()] = self::connection()->columns(static::$table_name);
    }
    return self::$columns[get_called_class()];
  }

  //takes just the names from all the columns and adds them to an array
  public static function column_names() {
    return array_map(self::columns(), function($column_names, $column){
      $column_names[] = $column->name;
      return $column_names;
    }, []);
  }

  //Creates a new record array for the class which called this method using the given attributes
  public static function create(...$attrs) {
    $records = new RecordArray(get_called_class());
    $records->from_attrs($attrs);
  }

  //returns the attributes for the current table and converts them to a string
  function __toString() {
    $cls = (string)get_class($this);
    if (get_class($this) == 'Base') {
      return 'Base';
    } elseif (static::table_exists()) {
      $attrs = array_map(function($attr){
        if (!$attr->is_null()) {
          return (string)$attr;
        }
      }, $this->attributes());
      $attrs = array_filter($attrs);
      $attrs_str = implode(', ', $attrs);
      return "$cls ($attrs_str)\n";
    } else {
      return "$cls (Table doesnt exist)\n";
    }
  }

}
