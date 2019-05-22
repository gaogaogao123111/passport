<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>企业   注册</h3>
    <form action="/Api/apiregadd" method="post" enctype="multipart/form-data">
    <table border="1">
        <tr>
            <td>企业名称：</td>
            <td><input type="text" id="api_name" name="api_name"></td>
        </tr>
        <tr>
            <td>法人：</td>
            <td><input type="text" id="api_home" name="api_home"></td>
        </tr>
        <tr>
            <td>税务号：</td>
            <td><input type="text" id="api_shui" name="api_shui"></td>
        </tr>
        <tr>
            <td>对应公众号：</td>
            <td><input type="text" id="api_zh" name="api_zh"></td>
        </tr>
        <tr>
            <td>执照：</td>
            <td><input type="file" id="api_zh" name="api_img"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><button class="btn">注册</button></td>
        </tr>
    </table>
    </form>
</body>
</html>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
    //     $('.btn').click(function(){
    //         var api_name =$('#api_name').val();
    //         var api_home =$('#api_home').val();
    //         var api_shui =$('#api_shui').val();
    //         var api_zh =$('#api_zh').val();
    //         $.post(
    //             '/Api/apiregadd',
    //
    //             {api_name:api_name,api_home:api_home,api_shui:api_shui,api_zh:api_zh},
    //             function(data){
    //                 if(data.error==0){
    //                     window.confirm(data.msg);
    //                     window.location="/Api/apiuser?api_name="+data['api_name'];
    //                 }else{
    //                     alert(data.msg);
    //                 }
    //             },
    //             'json'
    //         );
    // })
</script>