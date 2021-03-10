<?php
require_once('dbConnect.php');

/** taskClass
 *  @author: Pallavi
 *  @date: 07/03/2021
 *  @description: Action process class to implement todo task CRUD operation via API
 *  @variables:
 *  @version: 1.0
 */
 
    class taskClass{

        // db Connection variable
        private $conn;

        // Columns
        public $id;
        public $task_name;
        public $start_date;
        public $due_date;
        public $assigned_to;
        public $priority;
		public $status;
        public $estimated_time;
		
		/** Db connection constructor 
		 * @author Pallavi
		 * @description This constructor for DB connection object
		 * @param 
		 */	
		 
        public function __construct(){
			$connectObj = new dbConnectClass();
            $this->conn = $connectObj->connect;
        }

        /** getAllTask
		 * @author Pallavi
		 * @description This function get all task and return result set 
		 * @param 
		 */	
	 
        public function getAllTask(){
            $sqlQuery = "SELECT id, task_name, start_date, due_date, assigned_to, priority,status,estimated_time FROM task";
            $result = $this->conn->query($sqlQuery);
            return $result;
        }

        /** createTask
		 * @author Pallavi
		 * @description This function is used to create task based on JSON data 
		 * @param 
		 */	
        public function createTask(){
			
			$task_name = $this->conn->real_escape_string($this->task_name);
			$start_date = $this->conn->real_escape_string($this->start_date);
			$due_date = $this->conn->real_escape_string($this->due_date);
			$assigned_to = $this->conn->real_escape_string($this->assigned_to);
			$priority = $this->conn->real_escape_string($this->priority);
			$status = $this->conn->real_escape_string($this->status);
			$estimated_time = $this->conn->real_escape_string($this->estimated_time);

			$query = $this->conn->prepare("INSERT INTO task (task_name,start_date,due_date,assigned_to,priority,status,estimated_time) VALUES (?,?,?,?,?,?,?)");
			$query->bind_param("ssssssi", $task_name, $start_date, $due_date, $assigned_to, $priority, $status, $estimated_time);
  
            if($query->execute()){
               return true;
            }
            return false;
        }
		
		/** getTaskSummary
		 * @author Pallavi
		 * @description This function is used get summary of task based on Status 
		 * @param 
		 */	
        public function getTaskSummary(){
            $sql = 'SELECT count(id) as taskcount,status FROM `task` group by status';
			$result  = $this->conn->query($sql);
			return $result;
        } 
		
        /** getSingleTask
		 * @author Pallavi
		 * @description This function is used get one task record based on task Id
		 * @param 
		 */
        public function getSingleTask(){
            $sql = 'SELECT * FROM task where id ='.$this->id.' limit 1';
			$result  = $this->conn->query($sql);
			$allRows = $result->fetch_array(MYSQLI_ASSOC);

            $this->task_name = $allRows['task_name'];
            $this->start_date = $allRows['start_date'];
            $this->due_date = $allRows['due_date'];
            $this->assigned_to = $allRows['assigned_to'];
            $this->priority = $allRows['priority'];
			$this->status = $allRows['status'];
            $this->estimated_time = $allRows['estimated_time'];
			$this->id = $allRows['id'];
        }        

        /** updateTask
		 * @author Pallavi
		 * @description This function is used update task based on Json data
		 * @param 
		 */
        public function updateTask(){
			$task_name = $this->conn->real_escape_string($this->task_name);
			$start_date = $this->conn->real_escape_string($this->start_date);
			$due_date = $this->conn->real_escape_string($this->due_date);
			$assigned_to = $this->conn->real_escape_string($this->assigned_to);
			$priority = $this->conn->real_escape_string($this->priority);
			$status = $this->conn->real_escape_string($this->status);
			$estimated_time = $this->conn->real_escape_string($this->estimated_time);
			$id = $this->conn->real_escape_string($this->id);
		
			$query = $this->conn->prepare("UPDATE task SET task_name=?, start_date=?,due_date=?, assigned_to=?,priority=?,status=?,estimated_time=? WHERE id=?");
			$query->bind_param("ssssssii", $task_name, $start_date, $due_date, $assigned_to, $priority, $status, $estimated_time, $id);
			$query->execute(); 	   

			
			if($query->execute()){
			   return true;
			}
			return false;
		}

        /** deleteTask
		 * @author Pallavi
		 * @description This function is used to delete tasl based on task Id
		 * @param 
		 */
        function deleteTask(){
			
			$id = $this->conn->real_escape_string($this->id);
		
			$query = $this->conn->prepare("DELETE FROM task WHERE id=?");
			$query->bind_param("i", $id);
			$query->execute(); 	   

			
			if($query->execute()){
			   return true;
			}
			return false;
        }

    }
?>