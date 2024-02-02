<!doctype html>
<html>
<header>
  <link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
</header>

<body>
  <div id="conteneur">
    <h1>Les équipes de National League</h1>
    <table border="1">
      <tr>
        <td>ID</td>
        <td>Club</td>
      </tr>
      <?php
      require('ctrl.php');
      $listeEquipe = getEquipes();
      $cellule = 1;

      foreach ($listeEquipe as $equipes) {
        echo "<tr>";

        echo "<td>" . $cellule . "</td>";
        echo "<td>" . $equipes . "</td>";
        echo "</tr>";
        $cellule++;

      }


      ?>
    </table>
  </div>
</body>

</html>