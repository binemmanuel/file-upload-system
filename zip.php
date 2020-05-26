<?php
$page_title = 'Zip';

require __DIR__ . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR .  'config.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'header.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'Library.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'upload.php';

// Save as return page.
$_SESSION['return'] = $_SERVER['PHP_SELF'];

// Get all files
$files = Library::get_media('application');

$action = (string) (!empty($_GET['action'])) ? clean_data($_GET['action']) : null;

switch ($action) {
    case 'delete':
        $id = (int) (!empty($_GET['id'])) ? clean_data($_GET['id']) : null;
        $file = (string) (!empty($_GET['file'])) ? clean_data($_GET['file']) : null;
        
        // Delete a file.
        if (!delete_media($id, $file)) {
            // Store an error message.
            $error = 'Something went wrong when tring to delete a file.';
        } else {
            header('Location: '. clean_data($_SERVER['PHP_SELF']));
            exit;
        }

        break;
}

?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <?php if (!empty($error)): ?>
            <p class="alert alert-danger"><?= $error ?></p>

        <?php elseif (!empty($message)): ?>
            <p class="alert alert-success"><?= $message ?></p>

        <?php elseif (!empty($_SESSION['message'])): ?>
            <p class="alert alert-success"><?= clean_data($_SESSION['message']) ?></p>

            <?php
            // Clear message.
            unset($_SESSION['message']);
            ?>

        <?php endif ?>
        
        <?php 
        require 'file-uploader.php'
        ?>
    
        <div class="row">
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="table-dark">
                        <tr>
                            <td>File Name</td>
                            <td>File Type</td>
                            <td>Uploaded By</td>
                            <td>Uploaded On</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($files as $file): ?>
                            <?php
                            // Split data.
                            $split = explode('/', $file->type);
                            
                            $file_type = $split[0];
                            ?>
                            
                            <?php if ($file_type === 'application'): ?>
                                <tr>
                                    <td class="file-data">
                                        <?= $file->name ?>

                                        <div class="actions-container">
                                            <ul class="actions-list">
                                                <li class="action" ><a href="edit-file.php?id=<?= $file->id ?>">Edit</a></li>
                                                <li class="action"><a class="text-danger" href="?action=delete&file=<?= $file->link ?>&id=<?= $file->id ?>">Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="file-data"><?= $file->type ?></td>
                                    <td class="file-data"><?= $file->uploadedBy ?></td>
                                    <td class="file-data"><?= date('M, Y', strtotime($file->uploadedOn)) ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Main content /-->
 
<?php
require 'footer.php';
?>