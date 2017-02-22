<?php

require __DIR__.'/../vendor/autoload.php';

Chronicle\Base::setup_connection([
  'driver'   => 'mysql',
  'host'     => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'make-it-all'
]);


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
  ];

}

$user = User::first();
echo $user->name;
$user->name = 'Bobson';
$user->save();


?>
<?php exit(); ?>
