<?php namespace Chronicle;

trait Finders {

  public static function all() {
    return new Query\Select(get_called_class());
  }

  public static function find($id) {
    $record = self::find_by(['id' => $id]);
    if ($record===null) { throw new Error\RecordNotFound(); }
    return $record;
  }

  public static function find_by(...$args) {
    return self::where(...$args)->limit(1)->first();
  }

  public static function find_or_initialize_by($args) {
    $record = self::find_by($args);
    if ($record === null) {
      $record = self::new($args);
    }
    return $record;
  }

  public static function where(...$args) {
    return self::all()->where(...$args);
  }

  public static function exists(...$args) {
    $records = self::all()->select()->where(...$args);
    return $records->any();
  }

  public static function first($n=1) {
    return self::find_nth(1, $n);
  }

  public static function second() {
    return self::find_nth(2);
  }

  public static function third() {
    return self::find_nth(3);
  }
  public static function forth() {
    return self::find_nth(4);
  }

  public static function fifth() {
    return self::find_nth(5);
  }

  public static function last($n=1) {
    return self::find_nth_from_last(1, $n);
  }

  public static function second_to_last() {
    return self::find_nth_from_last(2);
  }

  public static function third_to_last() {
    return self::find_nth_from_last(3);
  }

  public static function forth_to_last() {
    return self::find_nth_from_last(4);
  }

  public static function fifth_to_last() {
    return self::find_nth_from_last(5);
  }

  public static function find_nth($n, $count=1) {
    $records = self::all()->limit($count)->offset($n-1);
    return ($count == 1) ? $records->first() : $records;
  }

  public static function find_nth_from_last($n, $count=1) {
    $records = self::all()->limit($count)->offset($n-1)->order('id DESC');
    return ($count == 1) ? $records->first() : $records;
  }


}
