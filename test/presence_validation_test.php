<?php 

	require 'test_helper.php';

	class User extends Chronicle\Base {

		public static $table_name = 'users';

    public static $validations = [
      'name' => ['length' => ['min', 20]],
      'email' => ['presence'=>true],
    ];

	}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Presence Validation Test</title>
</head>
<body>
	<h1></h1>
	<?php
    $user = User::new(['name'=>'henry']);
    $user->email = 'hasdad';
    var_dump($user->validate());
    foreach ($user->errors()->full_messages() as $msg) {
      echo $msg;
      echo '<br>';
    }
  ?>
	<hr/>
</body>
</html>