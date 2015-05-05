$(function(){

    loadRequests(1);
});

function loadRequests(page){

    var data = 'page=1&count=20';

    jsonCall(root + '/data-new-member-requests', 'get', data, requestsLoaded);
}

function requestsLoaded(data){

    $("#requestlist").html("");

    if(data.requests!=undefined && data.requests.length>0){

        var requestTable = getRequestTable(data.requests, data.request_by);

        $("#requestlist").html('<h4>Listing new requests</h4>');

        $("#requestlist").append(requestTable);

        $("#table_requests").dataTable();

        var str = '<input type="button" name="btnAcceptRequests" value="Accept requests"/> &nbsp;&nbsp;';
        str = str + '<input type="button" name="btnRemoveRequests" value="Remove requests"/>';

        $("#requestlist").append(str);

        $(".remove_request").click(function(){
            var id = $(this).attr('rel');
            removeRequest(id);
        });

        $(".accept_request").click(function(){
            var id = $(this).attr('rel');
            acceptRequest(id);
        });

        $(".remove_request").click(function(){
            var id = $(this).attr('rel');
            denyRequest(id);
        });

        $("input[name='btnRemoveRequests']").click(removeRequests);

    }
    else
        $("#requestlist").html("<h3 class='noproducts'>No requests created</h3>");
}

function removeRequest(id){

    ajaxCall(root + '/remove-request/' + id, 'get', '', requestRemoved);
}
function acceptRequest(id){

    ajaxCall(root + '/accept-request/' + id, 'get', '', requestAccepted);
}
function denyRequest(id){

    ajaxCall(root + '/deny-request/' + id, 'get', '', requestDenied);
}

function requestRemoved(){
    loadRequests(1);
}
function requestAccepted(){
    loadRequests(1);
}
function requestDenied(){
    loadRequests(1);
}

function getRequestTable(requests, user){

    var table = '<table id="table_requests"><thead>';

    table += '<tr>';

    table += '<td></td>';
    table += '<td>Requested by</td>';
    table += '<td>Group</td>';
    table += '<td>Action</td>';

    table += '</tr>';

    table += '</thead><tbody>';

    for(var i=0; i< requests.length; i++){

        table += '<tr>';

        var request = requests[i];

        table += '<td><input type="checkbox" name="chkrequest" rel="' + request.id + '"/></td>';
        table += '<td>' + user.first_name + '</td>';
        table += '<td>' + request.userGroup.name + '</td>';
        table += '<td>' + request.description + '</td>';
        table += '<td>';
        table += '<span class="link view_person" rel="' + request.id + '">Request By</span>';
        table += '&nbsp;&nbsp; <span class="link accept_request" rel="' + request.id + '">Accept</span>';
        table += '&nbsp;&nbsp; <span class="link deny_request" rel="' + request.id + '">Deny</span>';
        table += '</td>';

        table += '</tr>';
    }

    table += '</tbody></table>';

    return table;
}

function removeRequests(){

    var str = 'ids=';

    $("input[name='chkrequest']:checked").each(function(){
        var id = $(this).attr('rel');

        str = str + id + ',';
    });

    if(str.substr(str.length-1,1)==',')
        str = str.substr(0, str.length-1);

    ajaxCall(root + '/remove-requests', 'post', str, requestsRemoved);
}

function requestsRemoved(){

    loadRequests(1);
}