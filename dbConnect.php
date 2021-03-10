<?php

/** dbConnectClass
 *  @author: Pallavi
 *  @date: 1/02/2021
 *  @description: Generic class for database connection
 *  @variables:
 *  @version: 1.0
 */
class dbConnectClass{
	private $host = "localhost";
	private $user = "root";
	private $pass = "rootadmin";
	private $db_name = "todo";

	public $connect;

	/** __construct
	 * @author Pallavi
	 * @description constructor
	 * @param None
	 */
	public function __construct(){
		try{
			$this->connect = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
			if(mysqli_connect_error()){
			   die('connection error('.mysqli_connect_errno().')' . mysqli_connect_error());
			}
		}

		catch(Exception $e){
			echo $e->getMessage();
		}
	}
}