<?php
/**
 * Process file.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload-file'])) {
	if (empty($_FILES['name']) && empty($_FILES['file'])) {
		// Store an error message.
		$error = 'No file was uploaded.';
	} else {
		if (!empty($_POST['file-name'])) {
			// Store the title name.
			$title = clean_data($_POST['file-name']);

			// Uploaded By.
			$uploadedBy = (!empty($_SESSION['full_name'])) ? clean_data($_SESSION['full_name']) : clean_data($_SESSION['username']); // Replace with SESSION data.

			// Tmp file name.
			$tmp_file_name = $_FILES['file']['tmp_name'];

			$file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

			// Store the file name.
			$file_name = "dbs_". md5(uniqid() . strtolower($_FILES['file']['name'])) .'.'. $file_extension; // add a prefix to the file name.

			// Validate file.
			if (is_image($file_name)) {
				// Target directory.
				$target_dir = IMAGE_PATH;
				
				// Where is store the file.
				$target_file = $target_dir . basename($file_name);

				// Store the file type.
				$file_type = clean_data('image/'. file_type($file_name));

				// Upload the file.
				if (!upload_file(
					$title, 
					$tmp_file_name, 
					$target_file, 
					$file_type, 
					$uploadedBy
				)) {
					// Store an error message.
					$error = "Sorry, something went wrong when trying to upload the file. ". $file_name;
				} else {
					// Store success message.
					$message = 'Uploaded successfully';
				}
				
			} elseif (is_video($file_name)) {
				// Target directory.
				$target_dir = VIDEO_PATH;

				// Where is store the file.
				$target_file = $target_dir . basename($file_name);
				
				// Store the file type.
				$file_type = clean_data('video/'. file_type($file_name));

				// Upload the file.
				if (!upload_file(
					$title, 
					$tmp_file_name, 
					$target_file, 
					$file_type, 
					$uploadedBy
				)) {
					// Store an error message.
					$error = "Sorry, something went wrong when trying to upload the file. ". $file_name;
				} else {
					// Store success message.
					$message = 'Uploaded successfully';

					// Refresh the page.
					header('Location: '. clean_data($_SERVER['PHP_SELF']));
					exit;
				}

			} elseif (is_zip($file_name)) {
				// Target directory.
				$target_dir = ZIP_PATH;

				// Where is store the file.
				$target_file = $target_dir . basename($file_name);
				
				// Store the file type.
				$file_type = clean_data('application/'. file_type($file_name));

				// Upload the file.
				if (!upload_file(
					$title, 
					$tmp_file_name, 
					$target_file, 
					$file_type, 
					$uploadedBy
				)) {
					// Store an error message.
					$error = "Sorry, something went wrong when trying to upload the file. ". $file_name;
				} else {
					// Store success message.
					$message = 'Uploaded successfully';

					// Refresh the page.
					header('Location: '. clean_data($_SERVER['PHP_SELF']));
					exit;
				}

			} else {
				// Store an error message.
				$error = "Invalid file type";
			}
		} else {
			// Store an error message.
			$error = "Please enter the file name.";
		}
	}
}