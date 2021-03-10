<?php
     header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	
	if($_SERVER['REQUEST_METHOD'] == "GET"){

		include_once '../taskClass.php';


		$taskItems = new taskClass();
		$rowData = $taskItems->getTaskSummary();
		$statusCount = $rowData->num_rows;
		
	  
		
		if($statusCount > 0){
			$dataArr = $rowData->fetch_all(MYSQLI_ASSOC);
			$taskSummaryArr = [];
			foreach($dataArr as $row)
			{
				$key = str_replace("-","",$row['status']);
				$taskSummaryArr[$key] = $row['taskcount'];
			}
		 
			http_response_code(200);
			echo json_encode($taskSummaryArr);
	  
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