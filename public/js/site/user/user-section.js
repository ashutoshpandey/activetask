$(function(){

    loadMemberRequests(1);
});

function loadMemberRequests(page){

    jsonCall(root + '/count-member-requests', 'get', null, memberRequestsLoaded);
}

function memberRequestsLoaded(count){

    $("#requests").html("");

    if(count!=undefined && count>0){

        if(count==1)
            $("#requests").html("<h4><a href='" + root + "/new-member-requests'>" + count + ' new member request</a></h4>');
        else
            $("#requests").html('<h4>' + count + ' new member requests</h4>');
    }
    else
        $("#requests").html("").hide();
}
