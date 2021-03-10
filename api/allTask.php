	<?php
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
	  
		include_once '../taskClass.php';
		
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			
			$taskItems = new taskClass();

			$result = $taskItems->getAllTask();
			$taskCount = $result->num_rows;


			if($taskCount > 0){
				
				$allTaskArr = array();
				$allTaskArr["body"] = array();
				$allTaskArr["taskCount"] = $taskCount;
				$dataArr = $result->fetch_all(MYSQLI_ASSOC);

				foreach ($dataArr as $row) {
					$taskArr = array(
						"id" => $row['id'],
						"task_name" => $row['task_name'],
						"start_date" => date("d/m/Y", strtotime($row['start_date'])),
						"due_date" => date("d/m/Y", strtotime($row['due_date'])),
						"assigned_to" => $row['assigned_to'],
						"priority" => $row['priority'],
						"status" => $row['status'],
						"estimated_time" => $row['estimated_time']
					);

					array_push($allTaskArr["body"], $taskArr);
				}
				echo json_encode($allTaskArr);
			}

			else{
				http_response_code(404);
				echo json_encode(
					array("message" => "No task found. Please create new task.")
				);
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