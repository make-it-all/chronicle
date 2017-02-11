<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/base.php';

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


print_r(new User);
// print_r(Chronicle\Base::connection()->columns('users'));
