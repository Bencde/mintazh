
<?php
        $db = new PDO("mysql:host=localhost;dbname=mintaegyesületek2", "root", "");

    $keres='';
    if(isset($_POST['nev']))
        {
            $keres=$_POST['nev'];
        }
        $keresbovitett= '%'.$keres.'%';

    $rendezes = isset($_GET['rendezes']) ? $_GET['rendezes'] :'EgyNev';

    $select = "SELECT 
        e.egyesületnev AS EgyNev,
        e.alapitaseve AS Alapitas,
        t.tagnév AS AlapitoNev,
        COUNT(j.tagok_idtagok) AS TagSzam,
        e.tagdij
    From egyesület e
    LEFT JOIN tagok t ON e.alapittagok_idtagok = t.idtagok
    LEFT JOIN tagok_has_egyesület j ON j.egyesület_idegyesület = e.idegyesület 
    WHERE e.egyesületnev LIKE :keresbovitett
    GROUP BY j.egyesület_idegyesület
    ORDER BY $rendezes ASC";

    $statement = $db->prepare($select);
    $statement->bindParam(':keresbovitett', $keresbovitett, PDO::PARAM_STR);
    $statement->execute();
    $result= $statement;

    $select2 = "SELECT egyesületnev FROM egyesület";
    $statement = $db->prepare($select2);
    $statement->execute();
    $result2 = $statement->fetchAll(PDO::FETCH_COLUMN);
    $egynevList = json_encode($result2);



?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" type = "text/css" href="minta2.css">
    <title>egyesületek2</title>
</head>
<body>
    <p><?php print_r($_GET); ?></p>
    <p><?php print_r($_POST); ?></p>
    <h1> Telefonkönyv </h1> 
    <p> valami, móvalamimás </p>
    <form method = "post">
        <label for ="nev">Név:</label>
        <input id="nev" type="text" name="nev" value="<?= isset($_POST['nev']) ? htmlspecialchars($_POST['nev']) : '' ?>"/>      
        <input type = submit value = "Keres">
    </form>
    </br>
    
    <table>
        <tr> 
            <th> <a href="?rendezes=Egynev">Név</a></th>
            <th> <a href="?rendezes=Alapitas">Alapítás Éve</a></th>
            <th> <a href="?rendezes=AlapitoNev">Alapító</a></th>
            <th> <a href="?rendezes=TagSzam">Tagok száma</a></th>
            <th> <a href="?rendezes=tagdij">Tagság díj</a></th>
            

            <?php while($row=$result -> fetchObject()):?>
                <tr>
                    <td><?=$row-> EgyNev ?></td>
                    <td><?=$row-> Alapitas ?></td>
                    <td><?=$row-> AlapitoNev ?></td>
                    <td><?=$row-> TagSzam ?></td>
                    <td><?=$row-> tagdij ?></td>
                </tr>
                <?php endwhile ?>
        
        </tr>

    </table>    

    <p>
           <a href="insert.php">Új elem beszúrása</a>
    </p>
        
    <script>
       window.onload = function() {
            var egyNevs = <?php echo $egyNevList; ?>;
            alert(egyNevs.join("\n"));
        };
    </script>


</body>
</html>