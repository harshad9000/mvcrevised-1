<?php

class Model_Core_Adapter
{
	public $config = [
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'dbname' => 'newmvc-parmar-harshad',
	];

	protected $connect = null;

	public function connect()
	{
		if ($this->connect != null) {
			return $this->connect;
		}
		else{
			$connect = mysqli_connect(
				$this->config['host'],
				$this->config['username'],
				$this->config['password'],
				$this->config['dbname']
			);
			$this->connect = $connect;
			return $connect;
		}
	}

	public function fetchAll($query)
	{
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if ($result->num_rows == 0) {
			return false;
		}
		return $result->fetch_all(MYSQLI_ASSOC);
	}

	public function fetchRow($query)
	{
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if (!$result->num_rows == 0) {
			return $result->fetch_assoc(); 
		}
		return null;
	}

	public function insert($query){
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if ($result) {
			return $connect->insert_id;
		}
			return false;
	}

	public function update($query)
	{
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if ($result) {
			return true;
		}
		return false;
	}

	public function delete($query)
	{
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if ($result) {
			return true;
		}
		return false;
	}

	public function fetchOne($query)
	{
		$connect = $this->connect();
		$result = mysqli_query($connect,$query);
		if ($result->num_rows == 0) {
			return null;
		}
		$row = $result->fetch_array();
		if ($row) {
			return (array_key_exists(0,$row)) ? $row[0] : null;
		}
	}
}

?>