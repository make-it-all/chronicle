<?php namespace Chronicle\Query\Parts;

//Provides functionality to allow the use of where queries
trait Where {

  private $where = [];
  public function where(...$args) {
    if (is_string($args[0])) {
      $condition = $args[0];
      if (isset($args[1])) {
        $args = (array)$args[1];
        $i = 0;
        $condition = preg_replace_callback('/(\?|:(\w+))/', function($matches) use ($args, &$i){
          if ($matches[0] == '?') {
            return $args[$i++];
          } else {
            return $args[$matches[2]];
          }
        }, $condition);
      }
      $this->where[] = $condition;
    } else {
      $conditions = [];
      foreach($args[0] as $column=>$value) {
        if (is_array($value)) {
          $values = array_map(function($value){return "'$value'";}, $value);
          $values = implode(', ', $values);
          $conditions[] = "$column IN ($values)";
        } else {
          $conditions[] = "$column = '$value'";
        }
      }
      $this->where = array_merge($this->where, $conditions);
    }
    $this->executed = false;
    return $this;
  }

}
