<?php
$title = "Preview File";
session_start();
include '../components/login_check.php';
$uploads_dir = 'uploads';
$file = $_GET['file'];
$file_path = "$uploads_dir/$file";
include "../components/header.php";
?>
<div class="container mb-3">
  <a href="files.php" class="btn btn-primary btn-sm my-1">&larr; Back</a>
  <object data="<?php echo $file_path ?>" type="application/pdf" width="100%" height="1080px">
    <p>File preview not available. Instead you can <a href="<?php echo $file_path ?>">click here to download the file.</a></p>
  </object>

</div>
<?php
include "../components/footer.php";
