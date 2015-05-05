$(function(){

    loadGroupMembers(1);

    $("input[name='btnFind']").click(findGroupMember);
});

function findGroupMember(){

    var email = $("input[name='email']").val();
    var data = 'email=' + email;

    jsonCall(root + '/find-group-member-by-email', 'get', data, findResult);
}

function findResult(result){

    if(result.found=='yes'){

        if(result.user.status=='active'){
            var str = "Name = " + result.user.first_name + " " + result.user.last_name + "<br/>";
            str = str + "Location = " + result.user.country + "<br/>";
            str = str + "<span class='link lnkaddmember' rel='" + result.user.id + "'>Add</span>";

            $('.findResult').html(str);

            $('.lnkaddmember').click(function(){
                var id = $(this).attr('rel');
                var data = 'id=' + id;

                jsonCall(root + '/save-group-member', 'get', data, groupMemberAdded);
            });
        }
        else
            $('.findResult').html('The user is not active');
    }
    else{
        $('.findResult').html('No member found');
    }
}

function groupMemberAdded(result){
    loadGroupMembers(1);
}

function loadGroupMembers(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/all-group-members', 'get', data, groupMembersLoaded);
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
    table += '<td>Country</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< groupMembers.length; i++){

        table += '<tr>';

        var groupMember = groupMembers[i];

        table += '<td><input type="checkbox" name="chkgroupmember" rel="' + groupMember.id + '"/></td>';
        table += '<td>' + groupMember.user.first_name + ' ' + groupMember.user.last_name + '</td>';
        table += '<td>' + groupMember.user.email + '</td>';
        table += '<td>' + groupMember.user.country + '</td>';
        table += '<td>';
        table += '<a target="_blank" href="' + root + '/view-task/' + groupMember.user.id + '">View</a>';
        table += '&nbsp;&nbsp; <span class="link remove_group_member" rel="' + groupMember.id + '">Remove</span>';
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