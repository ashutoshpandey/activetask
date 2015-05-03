$(function(){

    $("input[name='btnregister']").click(saveUser);
});

function saveUser(){

    if(isValidUser()){

        var data = $("#frmregister").serialize();

        ajaxCall(root + '/save-user', 'post', data, userSaved);
    }
}

function userSaved(result){

    if(result=='created')
        window.location.replace(root + '/registered');
}

function isValidUser(){
    return true;
}