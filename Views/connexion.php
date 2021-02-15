<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
</head>

<body>
  <main>
    <h1>Connexion</h1>
    <form action="connexion.php" method="post">
      <div class="form-item">
        <label for="email">Votre mail :</label>
        <input type="email" name="email" id="email" placeholder="Votre mail ici" required spellcheck="true">
      </div>
      <div class="form-item">
        <label for="password">Votre mot de passe :</label>
        <input type="password" name="password" id="password" placeholder="Votre mot de passe ici" required>
      </div>
      <input type="submit" name="log" value="Me connecter !">
    </form>
  </main>
</body>

</html>