var root;
var months = Array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');

function ajaxCall(url, type, data, callback){

    if(data!=null){
        $.ajax({
            url: url,
            type: type,
            data: data,
            success: function(result){

                if(callback!=null)
                    callback(result);
            }
        });
    }
    else{
        $.ajax({
            url: url,
            type: type,
            success: function(result){

                if(callback!=null)
                    callback(result);
            }
        });
    }
}

function jsonCall(url, type, data, callback){

    if(data!=null){
        $.ajax({
            url: url,
            type: type,
            data: data,
            dataType: 'json',
            success: function(result){

                if(callback!=null)
                    callback(result);
            }
        });
    }
    else{
        $.ajax({
            url: url,
            type: type,
            dataType: 'json',
            success: function(result){

                if(callback!=null)
                    callback(result);
            }
        });
    }
}

function checkSessionTimeout(data){

    return data.indexOf('session_out')>-1;
}

function convertDateFormat(str){

    return moment(str).format('D-MMM-YYYY h:mm a');
}