<div class="col-md-12 border border-dark p-3 mb-5 rounded" id="add-new-modal" style="display: none;">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="input-group input-group-sm">
            <input class="form-control" style="background: none; border: none;" type="file" name="file" aria-label="Search">
            
            <div class="input-group-append">
                <input type="submit" class="btn btn-success" name="upload-file" />
            </div>
        </div>
        <div class="input-group input-group p-2 mb-3">
            <input class="form-control" autocomplete="off" type="text" name="file-name" placeholder="File Name" aria-label="File Name">
            
        </div>
    </form>
</div>