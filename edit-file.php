<?php
$page_title = 'Edit File';

require 'libs\config.php';
// require 'libs\library.php';

// Store the files id if it's set.
$id = (int) (!empty($_GET['id'])) ? clean_data($_GET['id']) : clean_data($_POST['id']);

if (empty($id)){
    header('Location: '. clean_data($_SESSION['return']));
    exit;
}

require 'libs\library.php';
require 'upload.php';
require 'header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = (string) (!empty($_POST['action'])) ? clean_data($_POST['action']) : null;
    $file_name = (string) (!empty($_POST['file-name'])) ? clean_data($_POST['file-name']) : null;
    $link = (string) (!empty($_POST['link'])) ? clean_data($_POST['link']) : null;
    $type = (string) (!empty($_POST['type'])) ? clean_data($_POST['type']) : null;
    $description = (string) (!empty($_POST['description'])) ? clean_data($_POST['description']) : null;

    // Instantiate a Library Object.
    $file = new Library;

    // Set data.
    $file->id = $id;
    $file->name = $file_name;
    $file->link = '';
    $file->type = '';
    $file->description = $description;

    switch ($action) {
        case 'Update':
            // Make the update.
            if (!$file->update()) {
                // Store an error message.
                $error = 'Something went wrong when tring to update a file.';
            } else {
                $_SESSION['message'] = 'Updated Successfully';

                header('Location: '. $_SESSION['return']);
                exit;
            }
            
            break;

        case 'Delete':
            // Delete a file.
            if (!delete_media($id, $link)) {
                // Store an error message.
                $error = 'Something went wrong when tring to delete a file.';
            } else {
                $_SESSION['message'] = 'Delete Successfully';

                header('Location: '. $_SESSION['return']);
                exit;
            }

            break;
    }

}

// Get the file.
$file = Library::get_by_id($id);

// Split data.
$split = explode('/', $file->type);
                
$file->type = $split[0];
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php 
        require 'file-uploader.php'
        ?>
    
        <div class="row">
            <form class="col-md-5" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="hidden" name="id" value="<?= $file->id ?>" />
                <input type="hidden" name="type" value="<?= $file->type ?>" />
                <input type="hidden" name="link" value="<?= $file->link ?>" />

                <div class="input-group mb-3">
                    <input type="text" name="file-name" class="form-control" placeholder="File Name" value="<?= $file->name ?>" />
                </div>
                
                <?php if (
                    $file->type !== 'application' &&
                    $file->type !== 'video'
                ): ?>
                    <div class="input-group mb-3">
                        <input type="text" name="alt-text" class="form-control" placeholder="Alternative Text" value="<?= $file->alt_text ?>" title="This is what will be displayed if the file is not found" />
                    </div>
                <?php endif ?>

                <div class="input-group mb-3">
                    <textarea name="description" class="form-control" placeholder="Description" cols="30" rows="10"><?= $file->description ?></textarea>
                </div>

                <div class="text-right">
                    <input type="submit" class="btn btn-danger" name="action" value="Delete" />
                    <input type="submit" class="btn btn-success" name="action" value="Update" />
                </div>
            </form>
       </div>
    </div>
</section>
<!-- Main content /-->
 
<?php
require 'footer.php';
?>