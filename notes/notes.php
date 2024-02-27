<?php
$title = 'Notes';
session_start();
include '../components/login_check.php';
include '../components/validate.php';
include '../components/dbCon.php';
//trash student
if (isset($_GET['trash_note'])) {
  $trash_note = validate($_GET['trash_note']);
  $sql = "UPDATE notes SET trash = 1 WHERE id = '$trash_note'";
  $result = $db->exec($sql);
  if (!$result) {
    // echo $db->lastErrorMsg();
  } else {
    $_SESSION['alert'] = ["success", "Note trashed successfully"];
    header('Location: notes.php');
    exit;
  }
}
//restore student
if (isset($_GET['restore_note'])) {
  $restore_note = validate($_GET['restore_note']);
  $sql = "UPDATE notes SET trash = 0 WHERE id = '$restore_note'";
  $result = $db->exec($sql);
  if (!$result) {
    // echo $db->lastErrorMsg();
  } else {
    $_SESSION['alert'] = ["success", "Note restored successfully"];
    header('Location: notes.php');
    exit;
  }
}
//delete permanetly
if (isset($_GET['deleteNote'])) {
  $delete_note = validate($_GET['deleteNote']);
  $sql = "DELETE FROM notes WHERE id = '$delete_note'";
  $result = $db->exec($sql);
  if (!$result) {
    // echo $db->lastErrorMsg();
  } else {
    $_SESSION['alert'] = ["success", "Note deleted successfully"];
    header('Location: notes.php');
    exit;
  }
}
include '../components/header.php';
?>

<div class="container my-3">
  <h4><a href="notes.php"> All Notes </a></h4>
  <a href="note.php" class='btn btn-sm btn-primary'>New Note</a>
  <br><br>
  <?php
  $sql = <<<EOF
  SELECT * from notes WHERE trash = 0;
  EOF;
  $result = $db->query($sql);
  $i = 0;
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $i += 1;
    $id = $row['id'];
    $title = $row['title'];
    $body = $row['body'];
    $created_on = $row['created_on'];
    echo "
      <b> $i. $title</b>
      <p style='white-space: pre-wrap;'>$body</p>
      <a href='note.php?edit_note=$id'><i class='bi bi-pencil-square'></i></a>
      <a href='notes.php?trash_note=$id' class='ms-5' onclick=\"return confirm('Sure to trash ?')\"><i class='bi bi-trash3-fill text-danger'></i></a>
      <hr>
    ";
  }
  ?>

  <h4 class='text-danger'>Trashed Notes</h4>
  <?php
  $sql = <<<EOF
  SELECT * from notes WHERE trash = 1;
  EOF;
  $result = $db->query($sql);
  $i = 0;
  while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $i += 1;
    $id = $row['id'];
    $title = $row['title'];
    $body = $row['body'];
    $created_on = $row['created_on'];
    echo "
      <b> $i. $title</b>
      <p> Created On: $created_on </p>
      <p style='white-space: pre-wrap;'>$body</p>
      <a href='notes.php?restore_note=$id' class='' onclick=\"return confirm('Sure to restore ?')\">Restore</a>
      <a href='notes.php?deleteNote=$id' class='text-danger ms-3' onclick=\"return confirm('Sure to delete permanently ?')\">Delete Permanently</a>
      <hr>
    ";
  }
  ?>
</div>
<?php include '../components/footer.php'; ?>