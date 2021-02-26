var f = document.forms[0];
f.addEventListener('submit',function(event){
    event.preventDefault();
    var inputs = f.getElementsByTagName("input");
    var str = "";
    for(var i=0;i<inputs.length;i++){
        if(inputs[i].getAttribute("name") == null){
            continue;
        }
        var k = inputs[i].getAttribute("name");
        var v = inputs[i].value
        str += k + v + "&"
    }
    new_str = str.substring(0,str.length-1);
    //1
    var xhr = new XMLHttpRequest();
    //2
    xhr.onreadystatechange = function(){
        if(xhr.readyState == 4 && xhr.status == 200){
            var json_str = xhr.responseText;
            var data = JSON.parse(json_str);
            if(data.error==0){
                alert('登录成功');
            }else{
                alert('登录失败');
            }
        }
    }
    //3
    xhr.open('POST','login.php');
    //4发送
    xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
    xhr.send(new_str);

})