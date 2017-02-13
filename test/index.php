<?php

require __DIR__.'/../vendor/autoload.php';

Chronicle\Base::setup_connection([
  'driver'   => 'mysql',
  'host'     => 'localhost',
  'username' => 'root',
  'password' => '',
  'database' => 'chronicle_test'
]);


class User extends Chronicle\Base {

  public static $table_name = 'users';

}

$users = User::all();
$users->load();
foreach ($users as $user) {
  var_dump($user);
  echo '<BR>';
}
// print_r(Chronicle\Base::connection()->columns('users'));
