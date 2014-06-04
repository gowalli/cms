<?php

require('cms-init.php');

if(isset($_POST['email'])) {
	$user = User::login($_POST['email'], $_POST['password']);
	if(is_object($user)) {
		$user->set_login_cookie();
		header('Location: /');
	}
}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
 <title>Login</title>
</head>

<body>
<?php if(isset($_POST['email'])) : ?><p class="error">The username and password specified was not found.</p><?php endif; ?>
<form action="" method="post">
<p>E-mail: <input type="text" name="email" value="<?php echo @$_POST['email']; ?>" /></p>
<p>Password: <input type="password" name="password" /></p>
<p><input type="submit" value="Login" /></p>
</form>

</body>
</html>
