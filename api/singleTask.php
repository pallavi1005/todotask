<?php
    header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	if($_SERVER['REQUEST_METHOD'] == "GET"){
		include_once '../taskClass.php';


		$taskItems = new taskClass();
		$taskItems->id = isset($_GET['id']) ? $_GET['id'] : die();
	  
		$taskItems->getSingleTask();

		if($taskItems->task_name != null){
			// create array
			$taskArr = array(
					"id" => $taskItems->id,
					"task_name" => $taskItems->task_name,
					"start_date" => $taskItems->start_date,
					"due_date" => $taskItems->due_date,
					"assigned_to" => $taskItems->assigned_to,
					"priority" => $taskItems->priority,
					"status" => $taskItems->status,
					"estimated_time" => $taskItems->estimated_time
				);
		  
			http_response_code(200);
			echo json_encode($taskArr);
		}
		  
		else{
			http_response_code(404);
			echo json_encode("Task not found.");
		}
	}
		else
		{
			http_response_code(406);
			echo json_encode(
				array("message" => "Not Acceptable.")
			);
		}
?>