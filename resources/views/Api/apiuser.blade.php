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
    @if($res->status==2)
        审核呢，等会的
    @else
        <hr>
        <button><a href="/admin/Api/token?api_id={{$res->api_id}}&key={{$res->key}}">获取token</a></button><hr>
        <button><a href="/admin/Api/ip?token=">获取IP</a></button><hr>
        <button><a href="/admin/Api/ua?token=">获取UA</a></button><hr>
        <button><a href="/admin/Api/reguser?token=">获取注册信息</a></button><hr>
    @endif
</body>
</html>
<script type="text/javascript" src="/js/jquery.js"></script>
<script>

</script>