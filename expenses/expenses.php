<?php
$title = 'Expenses';
session_start();
include '../components/login_check.php';
include '../components/dbCon.php';
include '../components/header.php';
?>

<div class="container my-3">
  <h4>Expenses</h4>
  <p>Total: <span id='total'></span> Rs</p>
  <a href="add_expense.php" class='btn btn-sm btn-primary mb-2'>Add</a>
  <table id="expensesTable" class="table-light table table-bordered table-striped w-100">
    <thead>
      <tr>
        <th>#</th>
        <th>Amount</th>
        <th>Total</th>
        <th style='min-width:100px'>Paid to/for</th>
        <th style='min-width:150px'>Remark</th>
        <th style='min-width:100px'>Added On</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * from expenses";
      $result = $db->query($sql);
      $i = 0;
      $total = 0;
      while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $total += $row['amount'];
        $i += 1;
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['amount'] . "</td>";
        echo "<td>" . $total . "</td>";
        echo "<td>" . $row['paid_to'] . "</td>";
        echo "<td>" . $row['remark'] . "</td>";
        echo "<td>" . $row['created_on'] . "</td>";
        echo "</tr>";
      }
      echo "<script>total.innerText=$total</script>";
      ?>

    </tbody>
  </table>
  <!-- for data table -->
  <script src="https://code.jquery.com/jquery-3.5.1.js"> </script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"> </script>
  <link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
  <script>
    $(document).ready(function() {
      $('#expensesTable').DataTable({
        "scrollX": true,
        "order": [],
      });
    });
  </script>
</div>
<?php include '../components/footer.php'; ?>