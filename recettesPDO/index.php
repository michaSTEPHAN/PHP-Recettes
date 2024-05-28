<h1>Exercice Recettes</h1>
<p>Afficher la liste des recettes avec leur temps de réalisation.<br></p>
<h2>Résultat<br><br></h2>

<?php
    require_once(__DIR__ . '/connexionBDD.php');
    $pageTitle = "Exercice Recettes";

    //----------------------------------------------------------    
    // Execution du SQL pour récupérer la liste des recettes
    //----------------------------------------------------------
    // On ecrit la requête SQL
    $sqlQuery = 'SELECT id_recipe, recipe_name, preparation_time FROM recipe ORDER BY preparation_time DESC';
    $recipesStatement = $mysqlClient->prepare($sqlQuery);

    // On execute la requête SQL    
    $recipesStatement->execute();

    // On "fetch" les données afin de pouvoir les exploiter
    $recipes = $recipesStatement->fetchAll();
?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>  
        <?php 
            echo 
                "<table>",        
                    "<thead>",        
                        "<tr>",
                            "<th>Nom recette</th>",
                            "<th>Temps de Préparation</th>",
                        "</tr>",    
                    "</thead>",
                    "<body>"
                    ;
                            
            // On affiche à l'écran les données "fetchées"
            foreach ($recipes as $recipe) {            
                $id = $recipe["id_recipe"];
                echo "<tr>",
                        "<td><a href='recette.php?id=$id'>".$recipe['recipe_name']."</a></td>",
                        "<td>".$recipe['preparation_time']."</td>",
                        "</td>",
                    "</tr>"; 
                    
            }
            echo "</body>",
                 "</table>";             
        ?>  
        
    </body>
</html> 