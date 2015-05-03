$(function(){

    loadTasks(1);
});

function loadTasks(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/data-all-tasks', 'get', data, tasksLoaded);
}

function tasksLoaded(tasks){

    $("#productlist").html("");

    if(tasks!=undefined && tasks.length>0){

        var productTable = getTaskTable(tasks);

        $("#tasklist").html('<h4>Listing your tasks</h4>');

        $("#tasklist").append(productTable);

        $("#table_tasks").dataTable();

        var str = '<input type="button" name="btnRemoveTasks" value="Remove tasks"/>';

        $("#similarproductlist").append(str);

        $(".remove_task").click(function(){
            var id = $(this).attr('rel');
            removeTask(id);
        });

        $("input[name='btnRemoveTasks']").click(removeTasks);

    }
    else
        $("#tasklist").html("<h3 class='noproducts'>No products available</h3>");
}

function removeTask(id){

    ajaxCall(root + '/remove-task/' + id, 'get', '', taskRemoved);
}

function taskRemoved(){

    loadTasks(1);
}

function getTaskTable(tasks){

    var table = '<table id="table_tasks"><thead>';

    table += '<tr>';

    table += '<td></td>';
    table += '<td>Name</td>';
    table += '<td>Type</td>';
    table += '<td>Description</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< tasks.length; i++){

        table += '<tr>';

        var task = tasks[i];

        table += '<td><input type="checkbox" name="chktask" rel="' + task.id + '"/></td>';
        table += '<td>' + task.name + '</td>';
        table += '<td>' + task.task_type + '</td>';
        table += '<td>' + task.description + '</td>';
        table += '<td><a target="_blank" href="' + root + '/view-task/' + task.id + '">View</a> &nbsp;&nbsp; <span class="link remove_task" rel="' + task.id + '">Remove</span></td>';

        table += '</tr>';
    }

    table += '</tbody></table>';

    return table;
}

function removeTasks(){

    var str = 'ids=';

    $("input[name='chktask']:checked").each(function(){
        var id = $(this).attr('rel');

        str = str + id + ',';
    });

    if(str.substr(str.length-1,1)==',')
        str = str.substr(0, str.length-1);

    ajaxCall(root + '/remove-tasks', 'post', str, tasksRemoved);
}

function tasksRemoved(){

    loadTasks(1);
}