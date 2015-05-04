$(function(){

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