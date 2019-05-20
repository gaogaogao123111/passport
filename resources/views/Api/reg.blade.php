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
<form action="/Api/apiregadd" method="post">
    <h3>api   注册</h3>
    <table border="1">
        <tr>
            <td>企业名称：</td>
            <td><input type="text" name="api_name"></td>
        </tr>
        <tr>
            <td>法人：</td>
            <td><input type="text" name="api_home"></td>
        </tr>
        <tr>
            <td>税务号：</td>
            <td><input type="text" name="api_shui"></td>
        </tr>
        <tr>
            <td>对应公众号：</td>
            <td><input type="text" name="api_zh"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit" value="注册"></td>
        </tr>
    </table>
</form>
</body>
</html>