<?php
var_dump($_POST);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Compte</title>
</head>

<body>
  <main>
    <form action="moncompte.php" method="POST">
      <div class="form-item">
        <label for="title">Donnez un nom à cette adresse :</label>
        <input type="text" name="title" id="title" placeholder="ex : Appartement perso" required>
      </div>
      <div class="form-item">
        <label for="country">Pays :</label>
        <input type="text" name="country" id="country" placeholder="ex : France" required>
      </div>
      <div class="form-item">
        <label for="town">Ville :</label>
        <input type="text" name="town" id="town" placeholder="ex : Marseille" required>
      </div>
      <div class="form-item">
        <label for="street">Rue :</label>
        <input type="text" name="street" id="street" placeholder="ex : Rue d'Hozier" required>
      </div>
      <div class="form-item">
        <label for="infos">Infos supplémentaires :</label>
        <input type="text" name="infos" id="infos" placeholder="ex : Appartement 8">
      </div>
      <div class="form-item">
        <label for="number">Numéro de rue :</label>
        <input type="number" name="number" id="number" spellcheck="true" required>
      </div>
      <input type="submit" value="Ajouter l'adresse" name="add_new_adress">
    </form>
  </main>
</body>

</html>