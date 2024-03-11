<?php
$title = 'Guests';
session_start();
include '../components/login_check.php';
include '../components/dbCon.php';
include '../components/validate.php';
//mark invited
if (isset($_GET['inviteGuest'])) {
  $inviteGuest = validate($_GET['inviteGuest']);
  $sql = "UPDATE guests2 SET invited = 'Yes' WHERE id = '$inviteGuest'";
  $result = $db->exec($sql);
  if (!$result) {
    // echo $db->lastErrorMsg();
  } else {
    $inviteGuest = validate($_GET['inviteGuest']);
    $sql = "SELECT * FROM guests2 WHERE id = '$inviteGuest'";
    $result = $db->query($sql);
    $guest = $result->fetchArray(SQLITE3_ASSOC);
    $_SESSION['alert'] = ["success", $guest['name'] . " marked invited successfully"];
    header('Location: guests.php');
    exit;
  }
}
include '../components/header.php';
?>

<div class="container my-3">
  <h4>All Guests</h4>
  <a href="guest.php" class='btn btn-sm btn-primary mb-2'>Add</a>
  <table id="guestTable" class="table-light table table-bordered table-striped w-100">
    <thead>
      <tr>
        <th>#</th>
        <!-- freeze to left -->
        <th style='position:sticky; left:0'>Name</th>
        <th style='min-width:150px'>Address</th>
        <th>Phone</th>
        <th style='min-width:100px'>Remark</th>
        <th>Invited</th>
        <th style='min-width:100px'>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * from guests2";
      $result = $db->query($sql);
      $i = 0;
      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $i += 1;
        $class = '';
        if ($row['invited'] == 'Yes')
          $class = 'text-success';
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td class='$class'>" . $row['name'] . "</td>";
        echo "<td><a class='text-black' target='_blank' href='" . $row['location'] . "'><i class='bi bi-geo-alt'></i> " . $row['address'] . "</a></td>";
        echo "<td>" . $row['phone'] . "</td>";
        echo "<td>" . $row['remark'] . "</td>";
        echo "<td>" . $row['invited'] . "</td>";
        echo "<td><a class='btn btn-sm btn-primary' onclick=\"return confirm('Sure to mark invited ?')\" href='guests.php?inviteGuest=" . $row['id'] . "'>Invite</a>";
        echo "<a class='btn btn-sm btn-primary ms-3' href='guest.php?edit_guest=" . $row['id'] . "'>Edit</a></td>";
        echo "</tr>";
      }
      ?>

    </tbody>
  </table>
  <!-- for data table -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"> </script>
  <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
  <script>
    $(document).ready(function() {
      $('#guestTable').DataTable({
        "scrollX": true,
        "order": [],
      });
    });
  </script>
  <style>
    td:nth-child(2) {
      position: sticky;
      left: 0;
    }
  </style>
</div>
<?php include '../components/footer.php'; ?>