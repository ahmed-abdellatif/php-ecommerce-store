<?php
// 'user' object
class User{

    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
	public $id;
	public $firstname;
	public $lastname;
	public $email;
	public $contact_number;
	public $address;
	public $password;
	public $access_level;
	public $access_code;
	public $status;
	public $created;
    public $modified;

	// constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // used in change password feature
    // user is already logged in
    function changePassword(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password = :password
				WHERE
					id = :id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind the values from the form
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}
    
	// used in forgot password feature
	function updatePassword(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					password = :password
				WHERE
					access_code = :access_code";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind the values from the form
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);
		$stmt->bindParam(':access_code', $this->access_code);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// check if given access_code exist in the database
	function accessCodeExists(){

		// query to check if access_code exists
		$query = "SELECT id
				FROM " . $this->table_name . "
				WHERE access_code = ?
				LIMIT 0,1";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind given access_code value
		$stmt->bindParam(1, $this->access_code);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if access_code exists
		if($num>0){

			// return true because access_code exists in the database
			return true;
		}

		// return false if access_code does not exist in the database
		return false;

	}

	// used in forgot password feature
	function updateAccessCode(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					access_code = :access_code
				WHERE
					email = :email";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));
		$this->email=htmlspecialchars(strip_tags($this->email));

		// bind the values from the form
		$stmt->bindParam(':access_code', $this->access_code);
		$stmt->bindParam(':email', $this->email);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// used in email verification feature
	function updateStatusByAccessCode(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					status = :status
				WHERE
					access_code = :access_code";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->status=htmlspecialchars(strip_tags($this->status));
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));

		// bind the values from the form
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':access_code', $this->access_code);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// check if given email exist in the database
	function emailExists(){

		// query to check if email exists
		$query = "SELECT id, firstname, lastname, access_level, password, status
				FROM " . $this->table_name . "
				WHERE email = ?
				LIMIT 0,1";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->email=htmlspecialchars(strip_tags($this->email));

		// bind given email value
		$stmt->bindParam(1, $this->email);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// if email exists, assign values to object properties for easy access and use for php sessions
		if($num>0){

			// get record details / values
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			// assign values to object properties
			$this->id = $row['id'];
			$this->firstname = $row['firstname'];
			$this->lastname = $row['lastname'];
			$this->access_level = $row['access_level'];
			$this->password = $row['password'];
			$this->status = $row['status'];

			// return true because email exists in the database
			return true;
		}

		// return false if email does not exist in the database
		return false;
	}

    // create new user record
    function create(){

        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					contact_number = :contact_number,
					address = :address,
					password = :password,
					access_level = :access_level,
					access_code = :access_code,
					status = :status,
					created = :created";

		// prepare the query
        $stmt = $this->conn->prepare($query);

		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
		$this->address=htmlspecialchars(strip_tags($this->address));
		$this->password=htmlspecialchars(strip_tags($this->password));
		$this->access_level=htmlspecialchars(strip_tags($this->access_level));
		$this->access_code=htmlspecialchars(strip_tags($this->access_code));
		$this->status=htmlspecialchars(strip_tags($this->status));

		// bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_number', $this->contact_number);
		$stmt->bindParam(':address', $this->address);

		// hash the password before saving to database
		$password_hash = password_hash($this->password, PASSWORD_BCRYPT);
		$stmt->bindParam(':password', $password_hash);

		$stmt->bindParam(':access_level', $this->access_level);
		$stmt->bindParam(':access_code', $this->access_code);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':created', $this->created);

		// execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
			$this->showError($stmt);
            return false;
        }

    }

	// used for paging user search results
	public function countAll_BySearch($search_term){

		// query to search user
		$query = "SELECT id FROM " . $this->table_name . " WHERE email LIKE ?";

		// prepare the query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term = "%{$search_term}%";
		$search_term=htmlspecialchars(strip_tags($search_term));

		// bind the values, $search_term is from the user search box
		$stmt->bindParam(1, $search_term);

		// execute the query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// return row count
		return $num;
	}

	// used for searching users
	function search($search_term, $from_record_num, $records_per_page){

		// query to search user
		$query = "SELECT id, firstname, lastname, email, contact_number, access_level, created
				FROM " . $this->table_name . "
				WHERE email LIKE ?
				ORDER BY email ASC
				LIMIT ?, ?";

		// prepare the query statement
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$search_term = "%{$search_term}%";
		$search_term=htmlspecialchars(strip_tags($search_term));

		// bind the values, $search_term is from the user search box
		$stmt->bindParam(1, $search_term);
		$stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

		// execute the query
		$stmt->execute();

		// return the retrieved rows
		return $stmt;
	}

	// update a user record
	public function update(){

		// update query
		$query = "UPDATE
					" . $this->table_name . "
				SET
					firstname = :firstname,
					lastname = :lastname,
					email = :email,
					contact_number = :contact_number,
					address = :address,
					access_level = :access_level
				WHERE
					id = :id";

		// prepare the query
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->firstname=htmlspecialchars(strip_tags($this->firstname));
		$this->lastname=htmlspecialchars(strip_tags($this->lastname));
		$this->email=htmlspecialchars(strip_tags($this->email));
		$this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
		$this->address=htmlspecialchars(strip_tags($this->address));
		$this->access_level=htmlspecialchars(strip_tags($this->access_level));

		// bind the values from the form
		$stmt->bindParam(':firstname', $this->firstname);
		$stmt->bindParam(':lastname', $this->lastname);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':contact_number', $this->contact_number);
		$stmt->bindParam(':address', $this->address);
		$stmt->bindParam(':access_level', $this->access_level);

		// unique ID of record to be edited
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// read details of a single user based on given ID
	function readOne(){

		// query to read single record
		$query = "SELECT firstname, lastname, email, contact_number, address, access_level, password
				FROM " . $this->table_name . "
				WHERE id = ?
				LIMIT 0,1";

		// prepare query
		$stmt = $this->conn->prepare( $query );

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind id value
		$stmt->bindParam(1, $this->id);

		// execute query
		$stmt->execute();

		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		// assign the values to object properties, for easy access
		$this->firstname = $row['firstname'];
		$this->lastname = $row['lastname'];
		$this->email = $row['email'];
		$this->contact_number = $row['contact_number'];
		$this->address = $row['address'];
		$this->access_level = $row['access_level'];
		$this->password = $row['password'];
	}

	// read all user rows from the database
	function readAll_NoPaging(){

		// query to read all users
		$query = "SELECT id, firstname, lastname, email, contact_number, access_level, created
				FROM " . $this->table_name . "
				ORDER BY created DESC";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// read all user records
	function readAll($from_record_num, $records_per_page){

		// query to read all user records, with limit clause for pagination
		$query = "SELECT
					id,
					firstname,
					lastname,
					email,
					contact_number,
					access_level,
					created
				FROM
					" . $this->table_name . "
				ORDER BY
					id DESC
				LIMIT
					?, ?";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// bind limit clause variables
		$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
		$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

		// execute query
		$stmt->execute();

		// return values
		return $stmt;
	}

	// used for paging products
	public function countAll(){

		// query to select all user records
		$query = "SELECT id FROM " . $this->table_name . "";

		// prepare query statement
		$stmt = $this->conn->prepare( $query );

		// execute query
		$stmt->execute();

		// get number of rows
		$num = $stmt->rowCount();

		// return row count
		return $num;
	}

	// delete the user record
	function delete(){

		// delete user query
		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

		// prepare query statement
		$stmt = $this->conn->prepare($query);

		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind user id to delete
		$stmt->bindParam(1, $this->id);

		// execute the query
		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	public function showError($stmt){
		echo "<pre>";
			print_r($stmt->errorInfo());
		echo "</pre>";
	}

}
?>
