<?php
// 'product image' object
class ProductImage{

	// database connection and table name
	private $conn;
	private $table_name = "product_images";

	// object properties
	public $id;
	public $product_id;
	public $name;
	public $timestamp;

	// constructor
	public function __construct($db){
		$this->conn = $db;
	}

	// read the first product image related to a product
	function readFirst(){

		// select query
		$query = "SELECT id, product_id, name
				FROM " . $this->table_name . "
				WHERE product_id = ?
				ORDER BY name DESC
				LIMIT 0, 1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind prodcut id variable
		$stmt->bindParam(1, $this->product_id);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// upload product image files
	function upload(){

		// specify valid image types / formats
		$valid_formats = array("jpg", "png");

		// specify maximum file size of file to be uploaded
		$max_file_size = 1024*3000; // 3MB

		// directory where the files will be uploaded
		$path = "../uploads/images/";

		// count or number of files
		$count = 0;

		// if files were posted
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){

			// Loop $_FILES to execute all files
			foreach ($_FILES['files']['name'] as $f => $name){

				if ($_FILES['files']['error'][$f] == 4) {
					continue; // Skip file if any error found
				}

				if ($_FILES['files']['error'][$f] == 0) {
					if ($_FILES['files']['size'][$f] > $max_file_size) {
						$message[] = "$name is too large!.";
						continue; // Skip large files
					}
					elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
						$message[] = "$name is not a valid format";
						continue; // Skip invalid file formats
					}

					// No error found! Move uploaded files
					else{
						if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)){
							$count++; // Number of successfully uploaded file

							// save name to database
							$this->name = $name;

							if($this->create()){
								// successfully added to databaes
							}
						}
					}
				}
			}
		}
	}

	// create product image
	function create(){

		// to get time-stamp for 'created' field
		$this->getTimestamp();

		// query to insert new product image record
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

	// read all product image related to a product
	function readAll(){

		// select query
		$query = "SELECT id, product_id, name
				FROM " . $this->table_name . "
				WHERE product_id = ?
				ORDER BY name ASC";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));

		// bind prodcut id variable
		$stmt->bindParam(1, $this->product_id);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// delete the product image
	function delete(){

		// delete product image query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind product image id variable
		$stmt->bindParam(1, $this->id);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the product image
	function deleteAll(){

		// delete product image query
		$query = "DELETE FROM " . $this->table_name . " WHERE product_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));

		// bind product image id variable
		$stmt->bindParam(1, $this->product_id);

		// execute query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// used for the 'created' field when creating a product image
	function getTimestamp(){
		date_default_timezone_set('Asia/Manila');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
