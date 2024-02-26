<?php
$title = 'Login';
session_start();
if (isset($_SESSION['eventLogin'])) {
	header('Location: ../index.php');
	exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	include '../components/validate.php';
	include '../components/dbCon.php';
	$username = validate($_POST['username']);
	$password = validate($_POST['password']);
	$sql = <<<EOF
	SELECT * from users WHERE username='$username' AND password='$password' ;
	EOF;
	$ret = $db->query($sql);
	$row = $ret->fetchArray(SQLITE3_ASSOC);
	if ($row != false) {
		if ($row['username'] == $username and $row['password'] == $password) {
			$_SESSION['eventLogin'] = true;
			$_SESSION['username'] = $username;
			header('Location: ../index.php');
			exit;
		} else {
			$_SESSION['alert'] = ['danger', 'Login failed! Wrong Credentials.'];
		}
	} else {
		$_SESSION['alert'] = ['danger', 'Login failed! Wrong Credentials.'];
	}
	$db->close();
}

include '../components/header.php';
?>

<div class="text-center mt-5 w-25 container" style="min-width: 300px;">
	<div class="mt-3">
		<!-- <img src="images/user.png" alt="user" width="120"> -->
	</div>
	<form action="login.php" method="POST">
		<div class="mb-2 ">
			<label for="username" class="form-label float-start">Username</label>
			<input type="text" name="username" id="username" class="mt-3 form-control" placeholder="Enter username" required>
		</div>
		<div class="mb-3 ">
			<label for="password" class="form-label float-start">Password</label>
			<input type="password" name="password" id="password" class="my-3 form-control" placeholder="Enter password" required>
		</div>
		<button type="submit" class="btn btn-primary px-5 ">Login</button>
	</form>
</div>

<?php include '../components/footer.php'; ?>