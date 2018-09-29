<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>select</title>

</head>
<body>
<form action="insert" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <p>
        <input type="text" name="username" placeholder="username">
    </p>
    <p>
        <input type="password" name="password" placeholder="password">
    </p>
    <input type="submit" value="注册">
</form>
</body>
</html>
