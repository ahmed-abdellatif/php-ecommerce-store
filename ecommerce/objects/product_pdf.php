<?php
// 'product pdf' object
class ProductPdf{

	// database connection and table name
	private $conn;
	private $table_name = "product_pdfs";

	// object properties
	public $id;
	public $product_id;
	public $name;
	public $timestamp;

	// constructor
	public function __construct($db){
		$this->conn = $db;
	}

	// upload product image files
	function upload(){

		// valid file format
		$valid_formats = array("pdf");

		// upload file size limit: 3MB
		$max_file_size = 1024*3000;

		// upload directory
		$path = "../uploads/pdfs/";
		$count = 0;

		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			// Loop $_FILES to execute all files
			foreach ($_FILES['pdf_file']['name'] as $f => $name) {
				if ($_FILES['pdf_file']['error'][$f] == 4) {
					continue; // Skip file if any error found
				}

				if ($_FILES['pdf_file']['error'][$f] == 0) {
					if ($_FILES['pdf_file']['size'][$f] > $max_file_size) {
						$message[] = "$name is too large!.";
						continue; // Skip large files
					}
					elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
						$message[] = "$name is not a valid format";
						continue; // Skip invalid file formats
					}
					else{ // No error found! Move uploaded files
						if(move_uploaded_file($_FILES["pdf_file"]["tmp_name"][$f], $path.$name)){
							$count++; // Number of successfully uploaded file

							// save name to database
							$this->name = $name;

							if($this->create()){
								// successfully added to database
							}
						}
					}
				}
			}
		}
	}

	// create product pdf record
	function create(){

		// to get time-stamp for 'created' field
		$this->getTimestamp();

		// insert query
		$query = "INSERT INTO  " . $this->table_name . "
				SET product_id = ?, name = ?, created = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
		$this->name=htmlspecialchars(strip_tags($this->name));

		// bind values
		$stmt->bindParam(1, $this->product_id);
		$stmt->bindParam(2, $this->name);
		$stmt->bindParam(3, $this->timestamp);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}

	}

	// read all product pdf records
	function readAll(){

		// query to select all product pdf
		$query = "SELECT id, product_id, name
				FROM " . $this->table_name . "
				WHERE product_id = ?
				ORDER BY name ASC";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind value
		$stmt->bindParam(1, $this->product_id);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// delete the product pdf under a product id
	function delete(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind product pdf id value
		$stmt->bindParam(1, $this->id);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete by product id
	function deleteAll(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE product_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));

		// bind product pdf id value
		$stmt->bindParam(1, $this->product_id);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// used for the 'created' field when creating a product pdf
	function getTimestamp(){
		date_default_timezone_set('Asia/Manila');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
