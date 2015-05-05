$(function(){

    loadGroups(1);

    $("input[name='btncreate']").click(createGroup);
});

function createGroup(){

    if(isValidGroup()){

        var data = $("#frmcreate").serialize();

        ajaxCall(root + '/save-group', 'post', data, groupCreated);
    }
}

function groupCreated(result){

    $("#message").html("Group created successfully");
}

function isValidGroup(){
    return true;
}

function loadGroups(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/data-all-groups', 'get', data, groupsLoaded);
}

function groupsLoaded(groups){

    $("#group-list").html("");

    if(groups!=undefined && groups.length>0){

        var groupTable = getGroupsTable(groups);

        $("#group-list").html('<h4>Listing your groups</h4>');

        $("#group-list").append(groupTable);

        $("#table_groups").dataTable();

        var str = '<input type="button" name="btnRemoveGroups" value="Remove Groups"/>';

        $("#group-list").append(str);

        $(".remove_group").click(function(){
            var id = $(this).attr('rel');
            removeGroup(id);
        });

        $("input[name='btnRemoveGroups']").click(removeGroups);

    }
    else
        $("#group-list").html("<h3 class='noproducts'>No groups created</h3>");
}

function removeGroup(id){

    ajaxCall(root + '/remove-group/' + id, 'get', '', groupRemoved);
}

function groupRemoved(){

    loadGroups(1);
}

function getGroupsTable(groups){

    var table = '<table id="table_groups"><thead>';

    table += '<tr>';

    table += '<td></td>';
    table += '<td>Name</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< groups.length; i++){

        table += '<tr>';

        var group = groups[i];

        table += '<td><input type="checkbox" name="chkgroup" rel="' + group.id + '"/></td>';
        table += '<td>' + group.name + '</td>';
        table += '<td><a target="_blank" href="' + root + '/group-members/' + group.id + '">Members</a> &nbsp;&nbsp; <span class="link remove_group" rel="' + group.id + '">Remove</span></td>';
        table += '</td>';

        table += '</tr>';
    }

    table += '</tbody></table>';

    return table;
}

function removeGroups(){

    var str = 'ids=';

    $("input[name='chkgroup']:checked").each(function(){
        var id = $(this).attr('rel');

        str = str + id + ',';
    });

    if(str.substr(str.length-1,1)==',')
        str = str.substr(0, str.length-1);

    ajaxCall(root + '/remove-groups', 'post', str, groupsRemoved);
}

function groupsRemoved(){

    loadGroups(1);
}