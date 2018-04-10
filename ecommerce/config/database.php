
<?php
// used to get mysql database connection
class Database{
	private $host = "localhost";
	private $db_name = "tora";
	private $username = "root";
	private $password = "root";
	public $conn;

	// get the database connection
	public function getConnection(){

		$this->conn = null;

		try{
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
		}catch(PDOException $exception){
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}
}
?>
