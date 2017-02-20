<?php require 'test_helper.php'; ?>
<?php 
  class User extends Chronicle\Base {
    public static $table_name = 'users';
  }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>SQL</title>
</head>
<body>

	<table>
		<tr><th>Chronicle Generated</th><th>Should be</th></tr>
    <tr>
      <td>
        <?php 
          echo User::where('id<5')->select('name', 'email', 'last_signed_in_at')->toSQL();
         ?>
      </td>
      <td>
        SELECT name,email,last_signed_in_at FROM `users` WHERE id<5;
      </td>
    </tr>
    <tr>
      <td>
        <?php echo User::where(['id'=>'value', 'id2'=>'value3'])->toSQL(); ?>
      </td>
      <td>
        SELECT all FROM `users` WHERE id = 'value' AND id2 = 'value3';
      </td>
    </tr>
    <tr>
      <td>
        <?php echo User::where('id < ? OR id > ?', [10, ";' OR 1=1'"])->toSQL(); ?>
      </td>
      <td>
        SELECT all FROM users WHERE id < 10 OR id > \;\' OR 1=1\'
      </td>
    </tr>
    <tr>
      <td>
        <?php echo User::where('name = :name OR ?', ['name' => 'Jackson', 234])->toSQL(); ?>
      </td>
      <td>
        SELECT all FROM users WHERE name = Jackson OR 234
      </td>
    </tr>
	</table>


</body>
</html>