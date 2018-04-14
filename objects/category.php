<?php
// 'category' object
class Category{

	// database connection and table name
	private $conn;
	private $table_name = "categories";

	// object properties
	public $id;
	public $name;
	public $description;

	// constructor
	public function __construct($db){
		$this->conn = $db;
	}

	// delete the product
	function delete(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind record id
		$stmt->bindParam(1, $this->id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// count all categories based on search term
	public function countAll_BySearch($search_term){

		// search query
		$query = "SELECT id FROM " . $this->table_name . " WHERE name LIKE ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term=htmlspecialchars(strip_tags($search_term));
		$search_term = "%{$search_term}%";

		// bind search term
		$stmt->bindParam(1, $search_term);

		// execute query
		$stmt->execute();

		// get row count
		$num = $stmt->rowCount();

		// return row count
		return $num;
	}

	// search categories
	function search($search_term, $from_record_num, $records_per_page){

		// search query
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				WHERE name LIKE ?
				ORDER BY name ASC
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term = "%{$search_term}%";
		$search_term=htmlspecialchars(strip_tags($search_term));

		// bind  variables
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// update the category
	function update(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET name = :name, description = :description
				WHERE id = :id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind values
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// create category
	function create(){

		// to get time-stamp for 'created' field
		$this->getTimestamp();

		// insert query
		$query = "INSERT INTO " . $this->table_name . "
				SET name = ?, description = ?, created = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->description=htmlspecialchars(strip_tags($this->description));

		// bind values
		$stmt->bindParam(1, $this->name);
		$stmt->bindParam(2, $this->description);
		$stmt->bindParam(3, $this->timestamp);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// read category details
	function readOne(){

		// select single record query
		$query = "SELECT name, description
				FROM " . $this->table_name . "
				WHERE id = ?
				LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind selected record id
		$stmt->bindParam(1, $this->id);

		// execute the query
		$stmt->execute();

		// get record details
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// assign values to object properties
		$this->name = $row['name'];
		$this->description = $row['description'];
	}

	// read all available categories (with limit clause for paging)
	function readAll($from_record_num, $records_per_page){

		// query select all categories
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				ORDER BY name
				LIMIT ?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// read all categories without limit clause, used drop-down list
	function readAll_WithoutPaging(){

		// select all data
		$query = "SELECT id, name, description
				FROM " . $this->table_name . "
				ORDER BY name";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// used for paging categories
	public function countAll(){

		// query to count all data
		$query = "SELECT count(*) FROM " . $this->table_name;

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		// get row value
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		// return all data count
		return $rows[0];
	}

	// used to read category name by its ID
	function readName(){

		// select single record query
		$query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind selected record id
		$stmt->bindParam(1, $this->id);

		// execute query
		$stmt->execute();

		// read row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// set value to 'name' property
		$this->name = $row['name'];
	}

	// used for the 'created' field
	function getTimestamp(){
		date_default_timezone_set('Asia/Manila');
		$this->timestamp = date('Y-m-d H:i:s');
	}
}
?>
