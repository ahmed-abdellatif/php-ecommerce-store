<?php
// 'cart_item' object
class CartItem{

	// database connection and table name
	private $conn;
	private $table_name = "cart_items";

	// object properties
	public $id;
	public $product_id;
	public $quantity;
	public $variation_id;
	public $variation_name;
	public $user_id;
	public $created;

	// constructor
	public function __construct($db){
		$this->conn = $db;

	}

	// delete the product
	function delete(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE product_id = ? AND user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->product_id);
		$stmt->bindParam(2, $this->user_id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the product
	function deleteAllByUser(){

		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind record id
		$stmt->bindParam(1, $this->user_id);

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

		// bind search term
		$search_term = "%{$search_term}%";
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

		// bind  variables
		$search_term = "%{$search_term}%";
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// update the cart_item
	function update(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET quantity = :quantity
				WHERE user_id = :user_id AND product_id = :product_id";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(':quantity', $this->quantity);
		$stmt->bindParam(':user_id', $this->user_id);
		$stmt->bindParam(':product_id', $this->product_id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// update user id
	function updateUserId(){

		// update query
		$query = "UPDATE " . $this->table_name . "
				SET user_id = ?
				WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// bind values
		$stmt->bindParam(1, $this->user_id);
		$stmt->bindParam(2, $_SESSION['user_id']);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// create cart_item
	function create(){

		$created=$this->getTimestamp();

		// insert query
		$query = "INSERT INTO " . $this->table_name . "
					SET product_id=:product_id, quantity=:quantity, price=:price,
						user_id=:user_id, variation_id=:variation_id, variation_name=:variation_name, created=:created";

		// prepare query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->product_id=htmlspecialchars(strip_tags($this->product_id));
		$this->quantity=htmlspecialchars(strip_tags($this->quantity));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->user_id=htmlspecialchars(strip_tags($this->user_id));
		$this->variation_id=htmlspecialchars(strip_tags($this->variation_id));
		$this->variation_name=htmlspecialchars(strip_tags($this->variation_name));

		// bind values
		$stmt->bindParam(":product_id", $this->product_id);
		$stmt->bindParam(":quantity", $this->quantity);
		$stmt->bindParam(":price", $this->price);
		$stmt->bindParam(":user_id", $this->user_id);
		$stmt->bindParam(":variation_id", $this->variation_id);
		$stmt->bindParam(":variation_name", $this->variation_name);
		$stmt->bindParam(":created", $this->timestamp);

		// execute query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// read cart_item details
	function readOne(){

		// select single record query
		$query = "SELECT name, description
				FROM " . $this->table_name . "
				WHERE id = ?
				LIMIT 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

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

	// read all cart items without limit clause, used drop-down list
	function readAll_WithoutPaging(){

		// select all data
		$query="SELECT p.id, p.name, ci.price, ci.variation_id, ci.variation_name, ci.quantity, ci.quantity * ci.price AS subtotal
			FROM " . $this->table_name . " ci
				LEFT JOIN products p
					ON ci.product_id = p.id
			WHERE user_id = :user_id";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(':user_id', $this->user_id);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	public function checkIfExists(){

		// query to count all data
		$query = "SELECT quantity FROM " . $this->table_name . " WHERE user_id = ? and product_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->user_id);
		$stmt->bindParam(2, $this->product_id);

		// execute query
		$stmt->execute();

		// get row value
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// set quantity
		$this->quantity=$row['quantity'];

		// return all data count
		return $stmt->rowCount();
	}

	// used for paging categories
	public function countAll(){

		// query to count all data
		$query = "SELECT count(*) FROM " . $this->table_name . " WHERE user_id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind values
		$stmt->bindParam(1, $this->user_id);

		// execute query
		$stmt->execute();

		// get row value
		$rows = $stmt->fetch(PDO::FETCH_NUM);

		// return all data count
		return $rows[0];
	}

	// used to read cart_item name by its ID
	function readName(){

		// select single record query
		$query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

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
