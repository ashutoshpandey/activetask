$(function(){

    $("input[name='btncreate']").click(createTask);
});

function createTask(){

    if(isValidTask()){

        var data = $("#frmcreate").serialize();

        ajaxCall(root + '/save-task', 'post', data, taskCreated);
    }
}

function taskCreated(result){

    $("#message").html("Task created successfully");
}

function isValidTask(){
    return true;
}