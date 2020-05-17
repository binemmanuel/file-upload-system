<?php
/**
 * The class responsible to handle media files.
 * 
 * Author: Bin Emmanuel
 *
 * @link http://developers.zerabtech.com/portfolio
 *
 * @version 1.0
 */
class Library
{
	// Class properties.
	/**
	 *	@var int The file's ID from the database.
	 */
	public $id;

	/**
	 *	@var string The name of the file.
	 */
	public $name;

	/**
	 *	@var string The link to the file.
	 */
	public $link;

	/**
	 *	@var string The file's cation.
	 */
	public $caption;

	/**
	 *	@var string The file's Alt Text.
	 */
	public $alt_text;

	/**
	 *	@var string The file's Description.
	 */
	public $description;

	/**
	 *	@var string The type of file.
	 */
	public $type;

	/**
	 *	@var string The name of the person that made the upload.
	 */
	public $uploadedBy;

	/**
	 *	@var int The date the file was uploaded.
	 */
	public $uploadedOn;
	
	function __construct(int $id = null, string $name = null, string $link = null, string $caption = null, string $alt_text = null, string $description = null, string $type = null, string $uploadedBy = null, string $uploadedOn = null)
	{
		/*
		 * Store the data if they are not empty.
		 */
		if (!empty($id))
			$this->id = (int) clean_data($id);

		if (empty($name)){
			// Split the link.
			$split_URL = explode('/', $link);
			
			// Count and store.
			$count = (count($split_URL) - 1);

			// Store the file name.
			$this->name = clean_data($split_URL[$count]);
		} else {
			// Store the file name.
			$this->name = clean_data($name);
		}

		if (!empty($link))
			$this->link = clean_data($link);

		if (!empty($caption))
			$this->caption = clean_data($caption);

		if (!empty($alt_text))
			$this->alt_text = clean_data($alt_text);

		if (!empty($description))
			$this->description = clean_data($description);

		if (!empty($type))
			$this->type = clean_data($type);

		if (!empty($uploadedBy))
			$this->uploadedBy = clean_data($uploadedBy);

		if (!empty($uploadedOn))
			$this->uploadedOn = clean_data($uploadedOn);
	}

	/**
	 * This method fetches a media file by it's ID.
	 * 
	 * @param int The media's ID.
	 * @return The Media file || an error message if the media file wasn't found or there was a problem.
	 */
	public static function get_by_id(int $id = null)
	{
		// Include our connection file.
		include 'libs/conn.php';

		// Check if the media object has an ID.
		if (empty($id))
			trigger_error('<strong>Library::getById()</strong> Attempt to get a Media File object that doestn\'t have it\'s ID property set.', E_USER_ERROR);

		// Sanitize ID.
		$id = clean_data($id);

		// Prepare a statement.
		$sql = $conn->prepare('SELECT * FROM library WHERE id = ?');

		// Bind Parameter.
		$sql->bind_param('i', $id);

		// Execute.
		if ($sql->execute()) {
			// Bind result value.
			$sql->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);

			// Retrieve rows.
			if ($sql->fetch()) {
				// Return an Oject of the media file.
				return new Library($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);
			}
		}
		
		// Close Statement.
		$sql->close();

		// close connection.
		$conn->close();

		return false;
	}

	/**
	 * Return All media objects.
	 * 
	 * @return The Media files || false if there was a problem.
	 */
	public static function get_media(string $type = NULL)
	{
		// Include our connection file.
		include 'libs/conn.php';

		if (empty($type)) {
			// Prepare a statement.
			$sql = $conn->prepare('SELECT * FROM library ORDER BY id DESC');	
		} else {
			$type = '%'. $type .'%';

			// Prepare a statement.
			$sql = $conn->prepare('SELECT * FROM library WHERE type like ? ORDER BY id DESC');

			// Bind Parameter.
			$sql->bind_param('s', $type);
		}

		// Execute.
		if ($sql->execute()) {
			// Bind result value.
			$sql->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);

			// Initialize an empty array.
			$data = [];

			// Retrieve rows.
			while ($sql->fetch()) {
				// Instantiate an Object.
				$media_files = new Library($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);

				// Store an array of objects.
				array_push($data, $media_files);
			}

			// Get the total number of categories that matched the criteria.
			$totalRows = Library::getTotalRow();

			return $data;

		}

		// Close Statement.
		$sql->close();

		// close connection.
		$conn->close();

		return false;
	}

	/**
	 *  Get the total number of rows.
	 */
	public static function getTotalRow(): int
	{
		// Include our connection file.
		include 'libs/conn.php';

		// Prepare a Statement.
		$sql = $conn->prepare('SELECT COUNT(*) as totalRows FROM library');

		// Execute Query.
		if ($sql->execute()) {
			// Bind the result to a variable.
			$sql->bind_result($totalRows);

			if ($sql->fetch()) {
				return $totalRows;
			};
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$conn->close();
		
		return 0;
	}

	public static function search(string $keyword)
	{
		// Include our connection file.
		include 'libs/conn.php';

		$keyword = clean_data('%'. $keyword .'%');

		// Prepare a statement.
		$sql = $conn->prepare('SELECT * FROM library WHERE name OR link LIKE ?');

		// Bind parameter.
		$sql->bind_param('s', $keyword);

		if ($sql->execute()) {
			// Bind result.
			$sql->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);

			// Initialize an empty array.
			$data = [];
			
			while ($sql->fetch()) {
				// Instantiate an Object.
				$search = new Library($id, $name, $link, $caption, $alt_text, $description, $type, $uploadedBy, $uploadedOn);

				// Store an array of objects.
				array_push($data, $search);

			}
			
			return $data;
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$conn->close();

		return false;
		
	}

	/**
	 *	Uploads the file.
	 *	 
	 *	@param string The file name.
	 *	@param string The link to the file.
	 *	@param string The type of file.
	 *	@param string The description of the file.
	 *	@return false || true if the Library object was inserted into the database successfully.
	 */
	public function upload(): bool
	{
		// Include our connection file.
		include 'libs/conn.php';

		// Prepare a Statement.
		$sql = $conn->prepare(
			'INSERT INTO 
				library(
					name,
					link, 
					type,
					description
				)
			VALUES(?, ?, ?, ?)'
		);

		// Bind Parameters.
		$sql->bind_param(
			'ssss',
			$this->name,
			$this->link,
			$this->type,
			$this->description
		);
		
		// Execute.
		if ($sql->execute()) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$conn->close();

		// Return false by default.
		return false;
	}

	/**
	 *	Update the the current object.
	 *	
	 *	@return false || true if the object was updated successfully.
	 */
	public function update(): bool
	{
		if (empty($this->id))
			trigger_error('<strong>Library::update()</strong>: Attempt to update a Media Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Include our connection file.
		include 'libs/conn.php';

		// Prepare a Statement.
		$sql = $conn->prepare('UPDATE library SET caption = ?, altText = ?, description = ? WHERE id = ?');

		// Bind Parameters.
		$sql->bind_param('sssi', $this->caption, $this->alt_text, $this->description, $this->id);

		if ($sql->execute()) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// close connec
		
		return false;
	}

	/*
	 *	Delete the current Media file object in the database.
	 */
	public function delete()
	{
		// Include our connection file.
		include 'libs/conn.php';

		// Check if the Media's ID is given.
		if (empty($this->id))
			trigger_error('<strong>Library::delete()</strong>: Attempt to delete a Media Object file that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Prepare a Statement.
		$sql = $conn->prepare('DELETE FROM library WHERE id = ? LIMIT 1');

		// Bind parameter.
		$sql->bind_param('i', $this->id);
		
		if ($sql->execute()) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// Close Connection.
		$conn->close();

		// Return false by default.
		return false;
	}
} // End of file.