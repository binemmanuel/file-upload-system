<?php
require 'libs\config.php';
require 'libs\library.php';

$page_title = 'Library';

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

require 'upload.php';
require 'header.php';

// Save as return page.
$_SESSION['return'] = $_SERVER['PHP_SELF'];

// Get all files
$files = Library::get_media();

?>
<!-- <pre>
    <?= print_r($_GET, true) ?>
</pre> -->


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="container">
            <?php if (!empty($error)): ?>
                <p class="alert alert-danger"><?= $error ?></p>

            <?php elseif (!empty($message)): ?>
                <p class="alert alert-success"><?= $message ?></p>

            <?php endif ?>
        </div>

        <?php 
        require 'file-uploader.php'
        ?>

        <div class="row">
            <?php foreach ($files as $file): ?>
                <?php
                // Split data.
                $split = explode('/', $file->type);
                
                $file_type = $split[0];
                ?>
                
                <?php if ($file_type === 'image'): ?>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box file-data">
                            <div class="inner">
                                <img src="<?= $file->link ?>" alt="<?= $file->name ?>" style="width: 100%; height: 275px" /> 
                            </div>

                            <div class="inner">
                                <strong>File Name: </strong> <?= $file->name ?>

                                <div class="actions-container">
                                    <ul class="actions-list">
                                        <li class="action" ><a href="edit-file.php?id=<?= $file->id ?>">Edit</a></li>
                                        <li class="action"><a class="text-danger" href="?action=delete&file=<?= $file->link ?>&id=<?= $file->id ?>">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- small box /-->
                    </div>
                <?php elseif ($file_type === 'video'): ?>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box file-data">
                            <div class="inner">
                                <video src="<?= $file->link ?>" style="width: 100%; height: 272px" controls></video>    
                            </div>

                            <div class="inner">
                                <strong>File Name: </strong> <?= $file->name ?>

                                <div class="actions-container">
                                    <ul class="actions-list">
                                        <li class="action" ><a href="edit-file.php?id=<?= $file->id ?>">Edit</a></li>
                                        <li class="action"><a class="text-danger" href="?action=delete&file=<?= $file->link ?>&id=<?= $file->id ?>">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- small box /-->
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<!-- Main content /-->
 
<?php
require 'footer.php';
?>