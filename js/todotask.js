var baseUrl = 'http://127.0.0.1';

$(document).ready( function () {

    loadTask();
	$('#alertMsg').html('');

});


function loadTask(){
	$.ajax({
        url : baseUrl+'/TodoProj/api/allTask.php',
        type : 'GET',
        dataType : 'json',
        success : function(data) {
            bindtoDatatable(data.body);
			loadTaskSummary();
        },
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
			var errorMsg='';
			if(xhr.responseJSON)
				 errorMsg = xhr.responseJSON.message;
			else 
				errorMsg = xhr.responseText;
			
			
			$('#alertMsg').html(alertMessage(errorMsg,'alert-danger'));
			$(".alert").delay(4000).fadeOut();
			
		}
    });
}


function loadTaskSummary(){
	
	$("#NewStatus").text("0");
	$("#progressStatus").text("0");
	$("#holdStatus").text("0");
	$("#CompleteStatus").text("0");
	
	$.ajax({
        url : baseUrl+'/TodoProj/api/summaryTask.php',
        type : 'GET',
        dataType : 'json',
        success : function(data) {
			if(data.New)
				$("#NewStatus").text(data.New);
			if(data.InProgress)
				$("#progressStatus").text(data.InProgress);
			if(data.Onhold)
				$("#holdStatus").text(data.Onhold);
			if(data.Complete)
				$("#CompleteStatus").text(data.Complete);
        },
		error: function(xhr, resp, text) {
			console.log(xhr, resp, text);
		}
    });
}

function taskFormSubmit(formData){
	$('#alertMsg').html('');
	
	var formdataArr =  $(formData).serializeArray() ; 

	var jsonData = {};
	$(formdataArr ).each(function(index, obj){
		jsonData[obj.name] = obj.value;
	});
	
	var apiUrl = '';
	if(jsonData['id'])
		apiUrl = '/TodoProj/api/updateTask.php';
	else
		apiUrl = '/TodoProj/api/createTask.php';
 
		$.ajax({
			url: baseUrl+apiUrl, 
			type : "POST", 
			dataType : 'json', 
			data : JSON.stringify(jsonData), 
			success : function(data) {
				loadTask();
				$('#myTaskModal').modal('hide');
				$('#alertMsg').html(alertMessage(data.message,'alert-success'));
				$(".alert").delay(4000).fadeOut();
				
			},
			error: function(xhr, resp, text) {
				var errorMsg = xhr.responseJSON.message;
				console.log(xhr, resp, text);
				$('#myTaskModal').modal('hide');
				$('#alertMsg').html(alertMessage(errorMsg,'alert-danger'));
				$(".alert").delay(4000).fadeOut();
			}
            });
			return false;

}

function bindtoDatatable(data) {

        var table = $('#taskTableID').dataTable({

			"processing": true,
			 "destroy": true,
			"pageLength": 10,
            "bAutoWidth" : false,
			"aaData" : data,
            "columns" : [ 
			{"data" : "id"},
			{"data" : "task_name"},
			{"data" : "priority"},
			{"data" : "status"},
			{"data" : "start_date"},
			{"data" : "due_date"},
			{"data" : "assigned_to"},
			{"data" : "estimated_time"},
			{"data": "id",
			 "render":function (data, type, row) {
                    return '<a href="javascript:;" class="task_edit" onclick = editTask('+data+');>Edit</a> / <a href="javascript:;" class="task_remove" onclick = deleteTask('+data+');>Delete</a>';
				}
			}
			]
			
			
        })
    }
	function editTask(data) {
		if(data)
		{
			$.ajax({
				url : baseUrl+'/TodoProj/api/singleTask.php/?id='+data,
				type : 'GET',
				dataType : 'json',
				success : function(data) {
					$('#myTaskModal').modal('show'); 
					$('#taskid').val(data.id);
					$('#task_name').val(data.task_name);
					$('#tskPriority').val(data.priority);
					$('#tskStatus').val(data.status);
					$('#start_date').val(data.start_date);
					$('#due_date').val(data.due_date);
					$('#assigned_to').val(data.assigned_to);
					$('#estimated_time').val(data.estimated_time);
					
				},
				error: function(xhr, resp, text) {
					var errorMsg = xhr.responseJSON.message;
					console.log(xhr, resp, text);
					$('#alertMsg').html(alertMessage(errorMsg,'alert-danger'));
					$(".alert").delay(4000).fadeOut();
				}
			});
		}
	
		return false;
	}
	
	function deleteTask(data) {
		if(confirm("Are you sure?"))
		{
			$.ajax({
				url : baseUrl+'/TodoProj/api/deleteTask.php',
				type : 'DELETE',
				dataType : 'json',
				data: '{"id": '+data+'}',
				success : function(data) {
					loadTask();
				},
				error: function(xhr, resp, text) {
					console.log(xhr, resp, text);
				}
			});
		}
		else
		{
			//do nothing
		}
		return false;
	}
	
	function alertMessage(alertMsg, alertType ){
	
		return '<div class="alert '+alertType+'" role="alert" >'+alertMsg+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'
	
	}
