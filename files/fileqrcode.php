<?php
$title = "QR Code";
session_start();
include '../components/login_check.php';
include '../components/header.php';
?>
<center>
  <div class="container my-3">
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['qr_url'])) {
      $qr_url = $_GET['qr_url'];
      $qr_url1 = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr_url);
    }
    echo "<b>Scan QR Code for</b> <a href='$qr_url'>$qr_url</a><br>";
    ?>

    <br>
    <img src="<?php echo $qr_url1 ?>" alt="qr_code">
  </div>

</center>
<?php
include '../components/footer.php';
