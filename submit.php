<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>submit file</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
</head>

<body>
    <?php
        $uploadfile = $_FILES['uploadfile'];
        $uploadfilepath = __DIR__ . DIRECTORY_SEPARATOR . "source" . DIRECTORY_SEPARATOR . $uploadfile['name'];  
        move_uploaded_file($uploadfile['tmp_name'], $uploadfilepath);

    ?>

</body>

</html>