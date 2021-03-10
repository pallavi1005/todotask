<?php
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: DELETE");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	if($_SERVER['REQUEST_METHOD'] == "DELETE"){
		include_once '../taskClass.php';


		$taskItems = new taskClass();
		
		$json_data = json_decode(file_get_contents("php://input"));
		
		$taskItems->id = $json_data->id;
		
		if($taskItems->deleteTask()){
			echo json_encode("Task deleted.");
		} else{
			echo json_encode("Task could not be deleted");
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