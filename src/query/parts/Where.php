<?php namespace Chronicle\Query\Parts;

trait Where {

  private $where = [];

  /*
  User::where('column = 234');
  User::where('column = 234 AND true');
  User::where('column = ? and col2 = ?', [true, 'value2']);
  User::where('column = :first_arg', ['first_arg'=>'123']);
  User::where('column = :first_arg and x=?', ['first_arg'=>'123', 123]);

  User::where(['column'=>'value']);

  User::where(['column'=>['value', 'value2', 3]]);
  */
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
