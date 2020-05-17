<?php
/**
 * Sanitize data.
 * 
 * @param anything
 * @return string A clean data.
 */
function clean_data($data): string
{
    return $data = htmlspecialchars(trim($data));
}

/**
 * The function for checking file type if it's an image.
 * 
 * @param string The File name.
 * 
 * @return bool Returns false || true if the file is an image.
 */
function is_image(string $file_name): bool
{
	// Store the target directory and target file.
	$target_file = basename($file_name);

	// Store the image types we want.
	$valid_file_type = ['jpeg', 'jpg', 'png', 'gif'];

	// Store file type.
	$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	// Check the file type.
	if (in_array($file_type, $valid_file_type) === true) {
		return true;
	}

	return false;
}

/**
 * The function for checking file type it's a video.
 * 
 * @param string The File name.
 * 
 * @return bool Returns false || true if the file is a video.
 */
function is_video(string $file_name): bool
{
	// Store the target directory and target file.
	$target_file = basename($file_name);

	// Store the image types we want.
	$valid_file_type = ['avi', 'mkv', 'wmv', '3gp', 'mp3', 'mp4'];

	// Store file type.
	$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	// Check the file type.
	if (in_array($file_type, $valid_file_type) === true) {
		return true;
	}

	return false;
}

/**
 * The function for checking file type it's a zip file.
 * 
 * @param string The File name.
 * 
 * @return bool Returns false || true if the file is a zip file.
 */
function is_zip(string $file_name): bool
{
	// Store the target directory and target file.
	$target_file = basename($file_name);

	// Store the image types we want.
	$valid_file_type = ['zip'];

	// Store file type.
	$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	// Check the file type.
	if (in_array($file_type, $valid_file_type) === true) {
		return true;
	}

	return false;
}

/**
 * The function for checking file type it's an audio.
 * 
 * @param string The File name.
 * 
 * @return bool Returns false || true if the file is a audio.
 */
function is_audio(string $file_name): bool
{
	// Store the target directory and target file.
	$target_file = basename($file_name);

	// Store the image types we want.
	$valid_file_type = ['mp3'];

	// Store file type.
	$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	// Check the file type.
	if (in_array($file_type, $valid_file_type) === true) {
		return true;
	}

	return false;
}

/**
 * The function the creates a file URl
 */
function create_file_URL($target_file)
{
	$split = explode('.', $target_file);

	$target_file = $split[0] . '.' . $split[1];
	$target_file = clean_data($target_file);

	// Store the link.
	return $target_file;
}

/**
 * The function that gets file type of a given file.
 * 
 * @param string The File name.
 * 
 * @return string Returns the file type.
 */
function file_type(string $file_name): string
{
	// Store the target directory and target file.
	$target_file = basename($file_name);

	// Store file type.
	$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

	// Return the file type.
	return $file_type;
}

/**
 * The function that gets file type of a given file.
 * 
 * @param string The File name.
 * 
 * @return string Returns the file type.
 */
function upload_file(
	string $title,
	string $tmp_file_name, 
	string $target_file, 
	string $file_type, 
	string $uploaded_by
): bool
{
	// Instantiate an Object.
	$library = new Library(
		$id = NULL, 
		$title,
		$target_file, 
		$caption = NULL, 
		$altText = NULL, 
		$description = NULL, 
		$file_type,
		$uploaded_by, 
		$uploaded_on = NULL
	);

	// echo '..'.$target_file;

	// Upload file if there are no errors
	// Then store file data.
	if (move_uploaded_file($tmp_file_name, $target_file) && $library->upload() === true) {
		return true;
	}

	return false;
}

/**
 * Deletes a file.
 * 
 * @param int The id of the file.
 * @param string The file name
 * @return bool
 */
function delete_media(int $id, string $file_name): bool
{
	if (file_exists($file_name)) {
		// Delete the file.
		if (unlink($file_name)) {
			// Instantiate an Object.
			$media = new Library($id);

			// Delete File.
			if ($media->delete() !== false) {
				return true;
			}
		}
	}

	return false;
}