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
<h1>审核</h1>
<table border="1">
        <tr>
            <td>ID</td>
            <td>企业</td>
            <td>执照</td>
            <td>法人</td>
            <td>税务号</td>
            <td>对应公众号</td>
            <td>是否审核？</td>
        </tr>
    @foreach($info as $k=>$info)
        <tr id="{{$info['api_id']}}">
            <td >{{$info['api_id']}}</td>
            <td>{{$info['api_name']}}</td>
            <td><img src="http://passport.1809.com/api_img/{{$info['api_img']}}"></td>
            <td>{{$info['api_home']}}</td>
            <td>{{$info['api_shui']}}</td>
            <td>{{$info['api_zh']}}</td>
            @if($info['status']==1)
                <td>已审核</td>
            @else
                <td>
                    <button class="btn">审核</button>
                    <button><a href="/admin/Api/del/?api_id={{$info['api_id']}}">撤回</a></button>
                </td>
            @endif
        </tr>
    @endforeach
</table>
</body>
</html>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>
    $(function(){
        $('.btn').click(function(){
            var _this = $(this);
            var id = _this.parents('tr').attr('id');
            $.post(
                '/admin/Api/gocheck',
                {id:id},
                function(data){
                    alert(data.msg);
                    history.go(0);
                },
                'json'
            );
        })
    })
</script>
