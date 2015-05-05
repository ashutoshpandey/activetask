$(function(){

    $("input[name='btnlogin']").click(checkLogin);
});

function checkLogin(){

    if(isValidForm()){

        $('.message').html('Checking');

        var data = $("#frmlogin").serialize();


        ajaxCall(root + '/is-valid-user', 'post', data, loginResult);
    }
}

function loginResult(result){

    if(result=='valid')
        window.location.replace(root + '/user-section');
    else if(result=='wrong')
        $('.message').html('Invalid email or password');
}

function isValidForm(){
    return true;
}