<?php
$title = 'New Note';
session_start();
include '../components/login_check.php';
include '../components/validate.php';
include '../components/dbCon.php';

// Check if note ID is provided for updating an existing note
if (isset($_POST['note_id'])) {
    $note_id = validate($_POST['note_id']);
}

// Check if form is submitted
if (isset($_POST['title']) && isset($_POST['body'])) {
    $title = validate($_POST['title']);
    $body = validate($_POST['body']);
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('d-m-Y H:i:s');

    // Check if note ID is provided
    if (isset($note_id)) {
        // Update existing note
        $sql = "UPDATE notes SET title = '$title', body = '$body', created_on = '$curr_date' WHERE id = '$note_id'";
    } else {
        // Insert new note
        $sql = "INSERT INTO notes (title, body, trash, created_on) VALUES ('$title', '$body', '0', '$curr_date')";
    }

    $ret = $db->exec($sql);
    if (!$ret) {
        // echo $db->lastErrorMsg();
        echo 'Some error occurred in db';
    } else {
        $_SESSION['alert'] = ["success", "Note saved successfully"];
        header('Location: notes.php');
        exit;
    }
}

// Fetch note information if editing an existing note
if (isset($_GET['edit_note'])) {
    $edit_note = validate($_GET['edit_note']);
    $sql = "SELECT * FROM notes WHERE id = '$edit_note'";
    $result = $db->query($sql);
    $note = $result->fetchArray(SQLITE3_ASSOC);
    $title = $note['title'];
    $body = $note['body'];
}
include '../components/header.php';
?>

<div class="container my-3">
    <a href="notes.php" class="btn btn-success mb-3 btn-sm">Back</a>
    <h4><?php echo isset($note) ? 'Edit Note' : 'Add New Note'; ?></h4>
    <form method='POST'>
        <div class="row">
            <div class='mb-3'>
                <label for='title' class='form-label float-start'>Title </label>
                <input type='text' oninput="this.value = this.value.replace(/\b[a-z]/g, char => char.toUpperCase());" class='form-control' id='title' name='title' required value="<?php echo isset($edit_note) ? $title : ''; ?>">
            </div>
            <div class='mb-3'>
                <label for='student_class' class='form-label float-start'>Body</label>
                <textarea name="body" id="body" cols="30" rows="10" class='form-control' required><?php echo isset($body) ? $body : ''; ?></textarea>
            </div>
            <?php if (isset($note)) : ?>
                <input type="hidden" name="note_id" value="<?php echo $note['id']; ?>">
            <?php endif; ?>
            <div class="mb-3 col-12">
                <button type='submit' id='submitBtn' class='btn btn-primary mb-3' onclick="return confirm('Sure to save ?')"><?php echo isset($note) ? 'Update' : 'Save'; ?></button>
                <a href="notes.php" class="btn btn-secondary mb-3 ms-5">Cancel</a>
            </div>
        </div>
    </form>
</div>

<?php include '../components/footer.php'; ?>