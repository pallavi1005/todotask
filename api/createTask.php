<?php
	
	
		
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		header("Access-Control-Allow-Methods: POST");
		header("Access-Control-Max-Age: 3600");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		include_once '../taskClass.php';


		$taskItems = new taskClass();

		$json_data = json_decode(file_get_contents("php://input"));

		
		$taskItems->task_name = $json_data->task_name;
		$taskItems->start_date = $json_data->start_date;
		$taskItems->due_date = $json_data->due_date;
		$taskItems->assigned_to = $json_data->assigned_to;
		$taskItems->priority = $json_data->priority;
		$taskItems->status = $json_data->status;
		$taskItems->estimated_time = $json_data->estimated_time;
		
		if($taskItems->createTask()){
			echo json_encode(
				array("message" => "Task created successfully.")
			);

		} else{
			echo json_encode(
				array("message" => "Task could not be created.")
			);
			
		}
	}
	else{
		http_response_code(406);
			echo json_encode(
				array("message" => "Not Acceptable.")
			);
	}
?>