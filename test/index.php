<?php

require __DIR__.'/../vendor/autoload.php';

Chronicle\Base::setup_connection([
  'driver'   => 'mysql',
  'host'     => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'make-it-all'
]);


class Hardware extends Chronicle\Base {

  public static $table_name = 'hardware';

}

class HardwareType extends Chronicle\Base {

  public static $table_name = 'hardware_types';

  public function hardwares() {
    return Hardware::where(['hardware_type_id'=>$this->id()]);
  }

}


class User extends Chronicle\Base {

  public static $table_name = 'users';

  public function before_validation() {
    echo "Before Validation";
  }

  public function before_create() {
    echo "Before Create";
  }

  public function before_save() {
    echo "Before Save";
  }

  public static $validations = [
    'name' => ['presence'=>true, 'length'=>['max', 255]],
    // 'email' => ['presence'=>true, 'length'=>['max', 255], 'format'=>true, 'uniqueness'=>true],
    // 'password_digest' => ['presence'=>true, 'length'=>['max', 255]],
    // 'current_sign_in_at' => ['format'=>true],
    // 'current_sign_in_ip' => ['length'=>['max',10], 'numericality'=>true, 'uniqueness'=>true],
    // 'last_sign_in_at' => ['format'=>true],
    // 'last_sign_in_ip' => ['length'=>['max',10], 'numericality'=>true],
    // 'personnel_id' => ['numericality'=>true, 'length'=>['max',11], 'uniqueness'=>true],
    // 'is_specialist' => ['presence'=>true, 'numericality'=>true, 'length'=>['equal',1]],
    // 'is_operator' => ['presence'=>true, 'numericality'=>true, 'length'=>['equal',1]],
    // 'is_admin' => ['presence'=>true, 'numericality'=>true, 'length'=>['equal',1]],
    // 'is_lboro_admin' => ['presence'=>true, 'numericality'=>true, 'length'=>['equal',1]],
    // 'last_seen_at' => ['format'=>true],
    // 'updated_by' => ['presence'=>true, 'numericality'=>true, 'length'=>['max',11]],
    // 'updated_at' => ['format'=>true],
    // 'created_by' => ['presence'=>true, 'numericality'=>true, 'length'=>['max',11]],
    // 'created_at' => ['format'=>true]

  ];
}

$user = User::new(['name'=>'ح']);
$user->save();
echo $user->validate();

if ($user->errors()->any()) {
  echo '<ul>';
  foreach($user->errors()->full_messages() as $msg) {
    echo "<li>$msg</li>";
  }
  echo '</ul>';
}
echo $user;

?>
<?php exit(); ?>
