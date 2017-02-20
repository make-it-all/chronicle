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


<<<<<<< HEAD
$user = User::new(['name'=>false]);
=======
>>>>>>> 56463ac25a240a4fd0d8cd84fa22d96c9dbd9075

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
//
// foreach($users as $user) {
//   echo $user;
//   echo '<hr>';
// }


//
// $user = User::new(['name'=>'Henry Morgan', 'email'=>'henrys email']);
// $user->name = 'Bob';
// echo $user->name;

//
// $users = User::all()->results();
//
//
// var_dump($users);
// foreach($users as $user) {
//   $name = $user->name;
//   echo "$name<br>";
// }




// $user = User::new();
// $user->set_name('Henry Morgan');
// $user->set_email('hexmodr@gmail.com');
// $user->set_password_digist('Henry Morgan');
// $user->set_is_specialist(false);
// $user->set_is_operator(true);
// $user->set_is_admin(true);
// $user->set_is_lboro_admin(true);
// $user->set_updated_by(1);
// $user->set_updated_at('2017-02-18');
// $user->set_created_by(1);
// $user->set_created_at('2017-02-18');
// $user->set_created_at('2017-02-18');
//
// var_dump($user->get_created_at());
//
//
// echo (string)$user;
// echo '<hr>';
// var_dump($user->is_new_record());
// var_dump($user->save());
// exit();
// exit();

?>



<?php exit(); ?>



<h2>User::all()</h2>
<?php
  $users = User::all();
?>
<table>
  <thead>
    <tr>
      <th>id</th>
      <th>name</th>
      <th>email</th>
      <th>password_digist</th>
      <th>current_sign_in_at</th>
      <th>current_sign_in_ip</th>
      <th>last_sign_in_at</th>
      <th>last_sign_in_ip</th>
      <th>personnel_id</th>
      <th>is_specialist</th>
      <th>is_operator</th>
      <th>is_admin</th>
      <th>is_lboro_admin</th>
      <th>last_seen_at</th>
      <th>updated_by</th>
      <th>updated_at</th>
      <th>created_by</th>
      <th>created_at</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($users as $user): ?>
      <?php $user->setUpdatedAt(123); ?>
      <tr>
        <td><?php echo $user->getId(); ?></td>
        <td><?php echo $user->getName(); ?></td>
        <td><?php echo $user->getEmail(); ?></td>
        <td><?php echo $user->getPasswordDigist(); ?></td>
        <td><?php echo $user->getCurrentSignInAt(); ?></td>
        <td><?php echo $user->getCurrentSignInIp(); ?></td>
        <td><?php echo $user->getLastSignInAt(); ?></td>
        <td><?php echo $user->getLastSignInIp(); ?></td>
        <td><?php echo $user->getPersonnelId(); ?></td>
        <td><?php echo $user->getIsSpecialist(); ?></td>
        <td><?php echo $user->getIsOperator(); ?></td>
        <td><?php echo $user->getIsAdmin(); ?></td>
        <td><?php echo $user->getIsLboroAdmin(); ?></td>
        <td><?php echo $user->getLastSeenAt(); ?></td>
        <td><?php echo $user->getUpdatedBy(); ?></td>
        <td><?php echo $user->getUpdatedAt(); ?></td>
        <td><?php echo $user->getCreatedBy(); ?></td>
        <td><?php echo $user->getCreatedAt(); ?></td>
      </tr>
    <?php endforeach; ?>

  </tbody>
</table>
?>
<hr>
<h2>Finders</h2>

<fieldset>
  <legend>find</legend>
  <?php echo (string)User::find(5); ?>
</fieldset>
<fieldset>
  <legend>find_by</legend>
  <?php echo (string)User::find_by(['id'=>4]); ?>
</fieldset>

<fieldset>
  <legend>where</legend>
  <?php echo (string)User::where('id<=?', 5)->where('name=\'greg\''); ?>
</fieldset>
<fieldset>
  <legend>pluck</legend>
  <?php echo (string)User::pluck('id', 'name'); ?>
</fieldset>

<hr>

<?php
