<?php
$title = "Change Password";
session_start();
include '../components/login_check.php';
include '../components/dbCon.php';
include '../components/validate.php';
if (isset($_POST['pwd1'])) {
  $pwd1 = validate($_POST['pwd1']);
  $pwd2 = validate($_POST['pwd2']);
  //to change password without login, uncomment below line and set your username
  // $username = "user";
  //to change password without login, comment below line
  $username = $_SESSION['username'];
  // date_default_timezone_set('Asia/Kolkata');
  // $curr_date = date('Y-m-d H:i:s');
  if (($pwd1 != $pwd2) or $pwd1 == "") {
    $_SESSION['alert'] = ["danger", "Error! Both passwords not matched"];
  } else {
    $sql = <<<EOF
    UPDATE users set password = '$pwd1' where username='$username';
    EOF;
    $ret = $db->exec($sql);
    if ($ret) {
      unset($_SESSION['eventLogin']);
      $_SESSION['alert'] = ["success", "Password changed successfully!"];
      header('Location: login.php');
      exit;
    } else {
      // echo "ERROR: $sql <br> ";
    }
  }
  $db->close();
}
include '../components/header.php';
?>
<center>
  <h4 class="mt-3">Change Password</h4>
  <form method="POST" class="my-5" style="width: 220px" action="change_password.php">
    <div class=" mb-3">
      <input minlength="6" required placeholder="Enter new password" type="password" class="form-control" id="pwd1" name="pwd1">
    </div>
    <div class="mb-3">
      <input minlength="6" required placeholder="Enter new password again" type="password" class="form-control" id="pwd2" name="pwd2">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</center>