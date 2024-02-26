<?php
$title = 'Add Expense';
session_start();
include '../components/login_check.php';
include '../components/validate.php';
include '../components/dbCon.php';

// Check if form is submitted
if (isset($_POST['amount'])) {
  $amount = validate($_POST['amount']);
  $paid_to = validate($_POST['paid_to']);
  $remark = validate($_POST['remark']);
  date_default_timezone_set('Asia/Kolkata');
  $curr_date = date('d-m-Y');
  $sql = "INSERT INTO expenses VALUES (NULL, '$amount', '$paid_to', '$remark', '$curr_date')";
  $ret = $db->exec($sql);
  if (!$ret) {
    // echo $db->lastErrorMsg();
    echo 'Some error occurred in db';
  } else {
    $_SESSION['alert'] = ["success", "Expense saved successfully"];
    header('Location: expenses.php');
    exit;
  }
}
include '../components/header.php';
?>

<div class="container my-3">
  <a href="#" onclick="window.history.back()" class=" btn btn-success mb-3 btn-sm">Back</a>
  <h4>Add new expense</h4>
  <form method='POST'>
    <div class="row">
      <div class='mb-3'>
        <label for='title' class='form-label float-start'>Amount </label>
        <input type='number' class='form-control' name='amount' required>
      </div>
      <div class='mb-3'>
        <label for='paid_to' class='form-label float-start'>Paid to/for </label>
        <input type='text' class='form-control' name='paid_to' required>
      </div>
      <div class='mb-3'>
        <label for='remark' class='form-label float-start'>Remark </label>
        <input type='text' class='form-control' name='remark' required>
      </div>

      <div class="mb-3 col-12">
        <button type='submit' class='btn btn-primary mb-3' onclick="return confirm('Sure to save ?')">Save</button>
        <a href="#" class="btn btn-secondary mb-3 ms-5" onclick="window.history.back()">Cancel</a>
      </div>
    </div>
  </form>
</div>

<?php include '../components/footer.php'; ?>