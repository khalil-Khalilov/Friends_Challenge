<?php
require_once '_connect.php';

$pdo = new PDO(DSN, USER, PASS);

if (isset($_POST['submit'])) {
    if (!empty($_POST['firstname']) && !empty($_POST['lastname'])) {
        if (strlen($_POST['firstname']) <= 45 && strlen($_POST['firstname']) <= 45) {
            $firstname = htmlspecialchars(trim($_POST['firstname']));
            $lastname = htmlspecialchars(trim($_POST['lastname']));

            $reqInsert = ('INSERT INTO `friend` (firstname, lastname) VALUES (:firstname, :lastname)');

            $insertIntoReq = $pdo->prepare($reqInsert);

            $insertIntoReq->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
            $insertIntoReq->bindValue('lastname', $lastname, \PDO::PARAM_STR);

            $insertIntoReq->execute();

            echo '<h3 style="background-color:green; color:white; font-weight:bold;"> Sending data was successful 👍</h3>';
            header("Refresh:3; index.php");
        } else {
            echo  '<h3 style="background-color:red; color:white; font-weight:bold;"> Name must not exceed 45 letters</h3>';
        }
    } else {
        echo  '<h3 style="background-color:red; color:white; font-weight:bold;"> Fields must not be empty</h3>';
    }
}
?>

<?php
$reqSelect = ('SELECT * FROM `friend`');

$selectReq = $pdo->query($reqSelect);

$donnees = $selectReq->fetchAll(\PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        h3 {
            padding: 1rem;
        }

        div{
            margin-top: 1rem;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <label for="firstname">First name :</label>
        <input type="text" name="firstname" id="firstname" for="firstname" required>


        <label for="lastname">Last name :</label>
        <input type="text" name="lastname" id="lastname" for="lastname" maxlength="45" required>

        <input type="submit" value="ENTER" name="submit">
    </form>


    <div id="container">
        <?php foreach ($donnees as $donnee) { ?>
            <h2><?= $donnee['firstname'] . '  ' . $donnee['lastname'] ?></h2>
        <?php
        }
        ?>
    </div>
</body>

</html>