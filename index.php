<?php
$title = "Event Manager";
session_start();
if (!isset($_SESSION['eventLogin'])) {
  header('Location: auth/login.php');
  exit;
}
include 'components/header.php';
?>

<div class="container my-3">
  <h4>Event Manager</h4>
  <a href="notes/notes.php" class="btn btn-outline-primary w-100 mb-3">Notes</a>
  <a href="expenses/expenses.php" class="btn btn-outline-primary w-100 mb-3">Expenses</a>
  <a href="guests/guests.php" class="btn btn-outline-primary w-100 mb-3">Guests</a>
  <a href="guests2/guests.php" class="btn btn-outline-primary w-100 mb-3">Jamat</a>
  <a href="files/files.php" class="btn btn-outline-primary w-100 mb-3">Files</a>
</div>

<?php include_once 'components/footer.php'; ?>