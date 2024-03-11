<?php
$title = 'New Guest';
session_start();
include '../components/login_check.php';
include '../components/validate.php';
include '../components/dbCon.php';

// Check if note ID is provided for updating an existing note
if (isset($_POST['guest_id'])) {
    $guest_id = validate($_POST['guest_id']);
}

// Check if form is submitted
if (isset($_POST['address'])) {
    $name = validate($_POST['name']);
    $address = validate($_POST['address']);
    $phone = validate($_POST['phone']);
    $location = validate($_POST['location']);
    $invited = validate($_POST['invited']);
    $remark = validate($_POST['remark']);

    // Check if note ID is provided
    if (isset($guest_id)) {
        // Update existing note
        $sql = "UPDATE guests2 SET name = '$name', address = '$address', phone = '$phone', location = '$location', invited='$invited', remark = '$remark' WHERE id = '$guest_id'";
    } else {
        // Insert new note
        $sql = "INSERT INTO guests2 VALUES (NULL, '$name', '$address', '$phone','$location','$remark','No')";
    }

    $ret = $db->exec($sql);
    if (!$ret) {
        // echo $db->lastErrorMsg();
        echo 'Some error occurred in db';
    } else {
        $_SESSION['alert'] = ["success", "Guest saved successfully"];
        header('Location: guests.php');
        exit;
    }
}

// Fetch note information if editing an existing note
if (isset($_GET['edit_guest'])) {
    $edit_guest = validate($_GET['edit_guest']);
    $sql = "SELECT * FROM guests2 WHERE id = '$edit_guest'";
    $result = $db->query($sql);
    $guest = $result->fetchArray(SQLITE3_ASSOC);
    $name = $guest['name'];
    $address = $guest['address'];
    $phone = $guest['phone'];
    $location = $guest['location'];
    $remark = $guest['remark'];
}
include '../components/header.php';
?>

<div class="container my-3">
    <a href="#" onclick="window.history.back()" class=" btn btn-success mb-3 btn-sm">Back</a>
    <h4><?php echo isset($guest) ? 'Edit Guest' : 'Add New Guest'; ?> in Jamat</h4>
    <form method='POST'>
        <div class="row">
            <div class='mb-3'>
                <label for='name' class='form-label float-start'>Name </label>
                <input type='text' oninput="this.value = this.value.replace(/\b[a-z]/g, char => char.toUpperCase());" class='form-control' id='name' name='name' required value="<?php echo isset($edit_guest) ? $name : ''; ?>">
            </div>
            <div class='mb-3'>
                <label for='address' class='form-label float-start'>Address </label>
                <input type='text' oninput="this.value = this.value.replace(/\b[a-z]/g, char => char.toUpperCase());" class='form-control' id='address' name='address' value="<?php echo isset($edit_guest) ? $address : ''; ?>">
            </div>
            <div class='mb-3'>
                <label for='phone' class='form-label float-start'>Phone </label>
                <input type='text' oninput="this.value = this.value.replace(/\b[a-z]/g, char => char.toUpperCase());" class='form-control' id='phone' name='phone' value="<?php echo isset($edit_guest) ? $phone : ''; ?>">
            </div>
            <div class='mb-3'>
                <label for='location' class='form-label float-start'>Google Map Location </label>
                <input type='text' class='form-control' id='location' name='location' value="<?php echo isset($edit_guest) ? $location : ''; ?>">
            </div>
            <div class='mb-3'>
                <label for='remark' class='form-label float-start'>Invited </label>
                <select name="invited" id="invited" class='form-control'>
                    <option value="Yes">Yes</option>
                    <option selected value="No">No</option>
                </select>
                <?php if (isset($guest)) : ?>
                    <script>
                        document.getElementById('invited').value = "<?php echo $guest['invited']; ?>";
                    </script>
                <?php endif; ?>
            </div>
            <div class='mb-3'>
                <label for='remark' class='form-label float-start'>Remark </label>
                <input type='text' class='form-control' id='remark' name='remark' value="<?php echo isset($edit_guest) ? $remark : ''; ?>">
            </div>
            <?php if (isset($guest)) : ?>
                <input type="hidden" name="guest_id" value="<?php echo $guest['id']; ?>">
            <?php endif; ?>
            <div class="mb-3 col-12">
                <button type='submit' id='submitBtn' class='btn btn-primary mb-3' onclick="return confirm('Sure to save ?')"><?php echo isset($guest) ? 'Update' : 'Save'; ?></button>
                <a href="#" class="btn btn-secondary mb-3 ms-5" onclick="window.history.back()">Cancel</a>
            </div>

    </form>
</div>

<?php include '../components/footer.php'; ?>