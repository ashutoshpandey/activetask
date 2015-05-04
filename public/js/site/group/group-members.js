$(function(){

    loadGroupMembers(1);

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

    $("input[name='btnAddGroupMember']").click(addGroupMember);
});

function addGroupMember(){

    var data = $("#frmGroupMember").serialize();

    ajaxCall(root + '/save-group-member', 'post', data, groupMemberAdded);
}

function groupMemberAdded(result){
    loadGroupMembers(1);
}

function loadGroupMembers(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/data-all-group-members', 'get', data, groupMembersLoaded);
}

function groupMembersLoaded(groupMembers){

    $("#group-member-list").html("");

    if(groupMembers!=undefined && groupMembers.length>0){

        var taskItemsTable = getGroupMembersTable(groupMembers);

        $("#group-member-list").html('<h4>Listing group members</h4>');

        $("#group-member-list").append(taskItemsTable);

        $("#table_group_members").dataTable();

        var str = '<input type="button" name="btnRemoveGroupMembers" value="Remove group members"/>';

        $("#group-member-list").append(str);

        $(".remove_group_member").click(function(){
            var id = $(this).attr('rel');
            removeGroupMember(id);
        });

        $("input[name='btnRemoveGroupMembers']").click(removeGroupMembers);

    }
    else
        $("#group-member-list").html("<h3>No group members added</h3>");
}

function removeGroupMember(id){

    ajaxCall(root + '/remove-group-member/' + id, 'get', '', groupMemberRemoved);
}

function groupMemberRemoved(){

    loadGroupMembers(1);
}

function getGroupMembersTable(groupMembers){

    var table = '<table id="table_group_members"><thead>';

    table += '<tr>';

    table += '<td></td>';
    table += '<td>Name</td>';
    table += '<td>Email</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< groupMembers.length; i++){

        table += '<tr>';

        var groupMember = groupMembers[i];

        table += '<td><input type="checkbox" name="chkgroupmember" rel="' + groupMember.id + '"/></td>';
        table += '<td>' + groupMember.user.first_name + ' ' + groupMember.user.last_name + '</td>';
        table += '<td>' + groupMember.user.email + '</td>';
        table += '<td>';
        table += '<a target="_blank" href="' + root + '/view-task/' + groupMember.user.id + '">View</a>';
        table += '&nbsp;&nbsp; <span class="link remove_task_item" rel="' + groupMember.id + '">Remove</span>';
        table += '</td>';

        table += '</tr>';
    }

    table += '</tbody></table>';

    return table;
}

function removeGroupMembers(){

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

    loadGroupMembers(1);
}