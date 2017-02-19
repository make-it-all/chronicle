<?php namespace Chronicle;

class Base {

  use Connection\Connection;
  use Attributes;
  use Persistence;
  use Finders;
  use Updaters;
  use Validation;

  public static $table_name;
  public static $columns;
  public static $columns_names;

  protected function __construct($attributes=[], $new_record=true) {
    $this->set_attributes_from_columns();

    $this->is_new_record = $new_record;

    if ($new_record) {
      $this->assign_attributes($attributes);
    } else {
      $this->assign_initial_attributes($attributes);
    }
    #run init callbacks

  }

  public static function new($attributes=[]) {
    $cls = get_called_class();
    $record = new $cls($attributes);
    return $record;
  }
  public static function new_from_result($attributes=[]) {
    $cls = get_called_class();
    $record = new $cls($attributes, false);
    return $record;
  }



  public static function count() {
    return self::connection()->count(static::$table_name);
  }

  public static function table_exists() {
    return self::connection()->table_exists(static::$table_name);
  }

  public function set_attributes_from_columns() {
    $cols = self::columns();
    array_walk($cols, function($column){
      $this->add_attribute($column);
    });
  }

  public static function columns() {
    if (!isset(self::$columns)) {
      static::$columns = self::connection()->columns(static::$table_name);
    }
    return self::$columns;
  }

  public static function column_names() {
    return array_map(self::columns(), function($column_names, $column){
      $column_names[] = $column->name;
      return $column_names;
    }, []);
  }

  public static function create(...$attrs) {
    $records = new RecordArray(get_called_class());
    $records->from_attrs($attrs);
  }


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
