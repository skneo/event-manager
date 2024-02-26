<?php
$title = "Files";
session_start();
include '../components/login_check.php';
include '../components/validate.php';
$uploads_dir = 'uploads';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
  $target_dir = "$uploads_dir/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $newFileName = $target_dir . validate($_POST['file_name']) . ".$file_type";
  //check file type
  if ($file_type == 'htm' or $file_type == 'html' or $file_type == 'php' or $file_type == 'asp' or $file_type == 'aspx' or $file_type == 'jsp' or $file_type == 'htaccess') {
    $_SESSION['alert'] = ['danger', 'Sorry, this file type not allowed, upload it by making zip file.'];
  }
  // Check if file already exists
  else if (file_exists($newFileName)) {
    $_SESSION['alert'] = ['danger', 'file of this name already exists, please change file name then try to upload'];
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFileName)) {
      $filename = htmlspecialchars(basename($_FILES["fileToUpload"]["name"]));
      $_SESSION['alert'] = ['success', "The file " . validate($_POST['file_name']) . " has been uploaded"];
    } else {
      $_SESSION['alert'] = ['success', 'Sorry, there was an error uploading your file.'];
    }
  }
}
if (isset($_POST['delete'])) {
  $fileName = $_POST['delete'];
  $file = "$uploads_dir/$fileName";
  if (file_exists($file)) {
    unlink($file);
    $_SESSION['alert'] = ['success', 'File deleted'];
  }
}
include '../components/header.php';
?>
<center>
  <div class="container mt-2 ">
    <form action="files.php" method="post" enctype="multipart/form-data">
      <h4>Select file to upload</h4>
      <input class="form-control my-3" style="width: 300px;" type="file" name="fileToUpload" id="fileToUpload">
      <input type="text" name='file_name' class='form-control mb-3' minlength="4" style="width: 300px;" required placeholder='enter file name'>
      <input class="btn btn-primary" onclick="loader()" type="submit" style="width: 300px;" value="Upload File" name="submit">
    </form>
    <div class="d-flex justify-content-center my-3 d-none" id="pageLoader">
      <div class="spinner-border" role="status">
        <span class="sr-only"></span>
      </div>
    </div>
  </div>
</center>
<hr>
<script>
  var loader = function() {
    document.getElementById('pageLoader').classList.remove('d-none');
  }
</script>
<h4 class="text-center"><a href="files.php">All Files</a> </h4>
<div class="container my-3">
  <table id="table_id" class="table-light table table-striped table-bordered w-100">
    <thead>
      <tr>
        <th>#</th>
        <th>File Name</th>
        <th>Size </th>
        <th>Uploaded On</th>
        <th style='min-width:300px'>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      date_default_timezone_set('Asia/Kolkata');
      $sn = 1;
      if (!is_dir("$uploads_dir")) {
        mkdir("$uploads_dir");
        file_put_contents("$uploads_dir/index.php", "");
      }
      if ($handle = opendir("$uploads_dir/")) {
        while (($file = readdir($handle)) != false) {
          if ($file != "." && $file != "..") {
            if ($file == "index.php")
              continue;
            $ctime = filectime("$uploads_dir/$file");
            $dateTime = date("Y-m-d H:i:s", $ctime);
            $filedownload = rawurlencode($file);
            $size = round(filesize("$uploads_dir/" . $file) / (1024));
            $current_site = $_SERVER['SERVER_NAME'];
            echo "<tr>
                                    <td>$sn</td>
                                    <td><a href=\"$uploads_dir/$filedownload\">$file</a></td>
                                    <td>$size kb</td>
                                    <td>$dateTime</td>
                                    <td>
                                        <div class='mt-2 d-flex'>  
                                            <div>
                                                <a href=\"preview_file.php?file=$filedownload\" class='btn-sm btn btn-success'>View</a>
                                                <a href=\"$uploads_dir/$filedownload\" download class='btn-sm btn btn-primary mx-1'>Download</a>
                                                <a href=\"fileqrcode.php?qr_url=http://$current_site/$uploads_dir/$filedownload\" class='btn-sm btn btn-info'>QR Code</a>
                                            </div>
                                            <div class='float-start'>
                                                <form method='post' class='mx-2' action='files.php'>
                                                    <button onclick=\"return confirm('Sure to delete $file ?')\" type='submit' class='btn-sm btn btn-danger' name='delete' value=\"$file\">Delete</button>
                                                </form> 
                                            </div>
                                        </div
                                    </td>
                                </tr>";
            $sn = $sn + 1;
          }
        }
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
      $('#table_id').DataTable({
        "scrollX": true,
        "order": [
          [3, "asc"]
        ],
      });
    });
  </script>
</div>

<?php include '../components/footer.php'; ?>