<?php
        $db = new PDO("mysql:host=localhost;dbname=mintaegyesületek2", "root", "");
        if(empty($_POST['nev']))
        {
            $errors['nev'] = 'Nev megadasa kotelezo';
        }

    if(empty($_POST['szam']))
        {
            $errors['szam'] = 'Szam megadasa kotelezo';
        }

        if (isset($_POST['nev']) && isset($_POST['szam'])){
            //Adatok kiolvasasa
            $nev = $_POST['nev'];
            $szam = $_POST['szam'];
            $egy = $_POST['egy'];
            $csat = $_POST['csat'];

            //Prepare statement
            $statement = $db->prepare("INSERT INTO tagok(tagnév, született) VALUES(:nev, :szam)");
            $statement->bindParam(':nev', $nev, PDO::PARAM_STR);
            $statement->bindParam(':szam', $szam, PDO::PARAM_STR);
            $statement->execute();

            $xy = '%'.$nev.'%';
            $statement = $db->prepare("SELECT TOP 1 tagok.idtagok FROM tagok WHERE tagok.tagnév LIKE :xy");
            $statement->bindParam(':xy', $xy, PDO::PARAM_STR);
            $statement->execute();
            $tagid=$statement;

             $statement = $db->prepare("INSERT INTO tagok_has_egyesület(egyesület_idegyesület, tagok_idtagok, csatlakozas) VALUES(:egy,:tagid, :csat)");
             $statement->bindParam(':egy', $egy, PDO::PARAM_INT);
             $statement->bindParam(':tagid', $tagid, PDO::PARAM_INT);
             $statement->bindParam(':csat', $csat, PDO::PARAM_INT);
             $statement->execute();

             


            $statement->execute();
             //Atiranyitas
            header("Location: index2222.php");
        }
        
        
        
        

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Új Tag hozzáadása</title>
</head>
<body>
    <form action="insert.php" method="post">
        <h1>Új Tag</h1>
        <p>
            <label> Név: <input type="text" name="nev" value="<?= isset($_POST['nev']) ? htmlspecialchars($_POST['nev']) : '' ?>"/> 
        </p>
        <p>
            <label> Születési dátum: <input type="text" name="szam" value="<?= isset($_POST['szam']) ? htmlspecialchars($_POST['szam']) : '' ?>"/> 
        </p>

        <p>
            <label> Egyesület id-je: <input type="text" name="egy" value="<?= isset($_POST['egy']) ? htmlspecialchars($_POST['egy']) : '' ?>"/> 
        </p>
        <p>
            <label> csatlakozás éve: <input type="text" name="csat" value="<?= isset($_POST['csat']) ? htmlspecialchars($_POST['csat']) : '' ?>"/> 
        </p>
        <input type="submit" value="Hozzáad" name="uj" />



</body>
</html>