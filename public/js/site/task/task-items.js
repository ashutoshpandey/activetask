$(function(){

    $('.assigned-to-name').hide();
    $('.assigned-to-user').hide();

    loadTaskItems(1);

    $("input[name='assigned_to']").click(function(){
        var type = $(this).val();

        if(type=='self'){
            $('.assigned-to-name').hide();
            $('.assigned-to-user').hide();
        }
        else if(type=='user'){
            $('.assigned-to-name').hide();
            $('.assigned-to-user').show();
        }
        else if(type=='name'){
            $('.assigned-to-name').show();
            $('.assigned-to-user').hide();
        }
    });

    $("input[name='btnAddTaskItem']").click(addTaskItem);
});

function addTaskItem(){

    var data = $("#frmTaskItem").serialize();

    ajaxCall(root + '/save-task-item', 'post', data, taskItemAdded);
}

function taskItemAdded(result){
    loadTaskItems(1);
}

function loadTaskItems(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/data-all-task-items', 'get', data, taskItemsLoaded);
}

function taskItemsLoaded(taskItems){

    $("#task-items-list").html("");

    if(taskItems!=undefined && taskItems.length>0){

        var taskItemsTable = getTaskItemsTable(taskItems);

        $("#task-items-list").html('<h4>Listing task items</h4>');

        $("#task-items-list").append(taskItemsTable);

        $("#table_task_items").dataTable();

        var str = '<input type="button" name="btnRemoveTaskItems" value="Remove task items"/>';

        $("#task-items-list").append(str);

        $(".remove_task_item").click(function(){
            var id = $(this).attr('rel');
            removeTaskItem(id);
        });

        $("input[name='btnRemoveTaskItems']").click(removeTaskItems);

    }
    else
        $("#task-items-list").html("<h3>No task items added</h3>");
}

function removeTaskItem(id){

    ajaxCall(root + '/remove-task-item/' + id, 'get', '', taskItemRemoved);
}

function taskItemRemoved(){

    loadTaskItems(1);
}

function getTaskItemsTable(taskItems){

    var table = '<table id="table_task_items"><thead>';

    table += '<tr>';

    table += '<td></td>';
    table += '<td>Content</td>';
    table += '<td>Start</td>';
    table += '<td>End</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< taskItems.length; i++){

        table += '<tr>';

        var taskItem = taskItems[i];

        table += '<td><input type="checkbox" name="chktaskitem" rel="' + taskItem.id + '"/></td>';
        table += '<td>' + taskItem.content + '</td>';
        table += '<td>' + taskItem.start_date + '</td>';
        table += '<td>' + taskItem.end_date + '</td>';
        table += '<td>';
        table += '<a target="_blank" href="' + root + '/view-task/' + taskItem.id + '">View</a>';
        table += '&nbsp;&nbsp; <span class="link remove_task_item" rel="' + taskItem.id + '">Remove</span>';
        table += '</td>';

        table += '</tr>';
    }

    table += '</tbody></table>';

    return table;
}

function removeTaskItems(){

    var str = 'ids=';

    $("input[name='chktaskitem']:checked").each(function(){
        var id = $(this).attr('rel');

        str = str + id + ',';
    });

    if(str.substr(str.length-1,1)==',')
        str = str.substr(0, str.length-1);

    ajaxCall(root + '/remove-task-items', 'post', str, taskItemsRemoved);
}

function taskItemsRemoved(){

    loadTaskItems(1);
}