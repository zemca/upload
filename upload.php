<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container">
<?php
//var_dump($_FILES);

if ($_FILES) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = strtolower( pathinfo($targetFile, PATHINFO_EXTENSION));

    $uploadSuccess = true;

    //echo substr($_FILES['uploadedName']['type'], 0, 5) . "";
    //echo "\n";

    // kontrola chyb serveru
    if($_FILES['uploadedName']['error'] != 0){
        echo "Chyba serveru při uploadu";
        $uploadSuccess = false;
    }

    // kontrola existence
    elseif(file_exists($targetFile)){
        echo "Soubor již existuje";
        $uploadSuccess = false;
    }

    // kontrola velikosti
    elseif($_FILES['uploadedName']['size'] > 8 * 1024 * 1024){
        echo "Soubor je příliš velký";
        $uploadSuccess = false;
    }

    // kontrola typu
    elseif (substr(($_FILES['uploadedName']['type']), 0, 5) != "audio" && substr(($_FILES['uploadedName']['type']), 0, 5) != "video" && substr(($_FILES['uploadedName']['type']), 0, 5) != "image"){
        echo "Soubor není správného typu";
        $uploadSuccess = false;
    }

    // přesun souboru
    if(!$uploadSuccess){
        echo "<br>   Došlo k chybě uploadu";
    } else {
        if(move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)){
            header("Location: " . $targetFile);
            exit;
        } else {
            echo "Došlo k chybě uploadu";
        }
    }
}
?>
<div class="form-group">
<form method="post" action="" enctype="multipart/form-data"><div>
        Select image to upload:
        <input class="form-control" type="file" name="uploadedName" accept="audio/*, video/*, image/*"/>
        <input class="form-control" type="submit" value="Nahrát" name="submit"/>
    </div></form>
</div>
</body>
</html>