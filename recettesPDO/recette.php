<h1>Exercice Recettes</h1>
<p>Afficher le détail d'une recette<br></p>
<h2>Résultat</h2>

<?php
    require_once(__DIR__ . '/connexionBDD.php');
    $pageTitle = "Détail de la recette";
    $idRecipe = $_GET['id'];     

    //---------------- ------------------------------------------       
    // Execution du SQL pour récupérer les instructions de la recette
    //----------------------------------------------------------
    // On ecrit la requête SQL
    $sqlQueryInstruction = 'SELECT instructions, recipe_name FROM recipe WHERE id_recipe = :idRecipe';
    $recupInstruction = $mysqlClient->prepare($sqlQueryInstruction);

    // On execute la requête SQL    
    $recupInstruction->execute(['idRecipe' => $idRecipe]);

    // On "fetch" les données afin de pouvoir les exploiter
    $instructions = $recupInstruction->fetchAll();

    //----------------- -----------------------------------------       
    // Execution du SQL pour récupérer les ingédients de la recette
    //----------------------------------------------------------
    // On ecrit la requête SQL
    $sqlQueryIngredient = ' SELECT i.id_ingredient, i.ingredient_name, ri.quantity, i.unity, i.price, ROUND((ri.quantity * i.price),2) AS cost
        FROM recipe r
        INNER JOIN recipe_ingredient ri ON ri.id_recipe = r.id_recipe
        INNER JOIN ingredient i ON i.id_ingredient = ri.id_ingredient
        WHERE r.id_recipe = :idRecipe';        
    $recupIngredient = $mysqlClient->prepare($sqlQueryIngredient);

    // On execute la requête SQL    
    $recupIngredient->execute(['idRecipe' => $idRecipe]);

    // On "fetch" les données afin de pouvoir les exploiter
    $ingredients = $recupIngredient->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>  
        <?php
        
        //----------------- -----------------------------------------       
        // On récupère les instructions de la recette
        //----------------- -----------------------------------------       
        foreach ($instructions as $instruction) {
            echo "<h2>Instructions de la recette : ".$instruction['recipe_name']."</h2>";
            echo $instruction['instructions']."<br>";
        }
            echo 
                "<table>",        
                    "<thead>",        
                        "<tr>",
                            "<th>Ingrédient</th>",
                            "<th>Quantité</th>",
                            "<th>Unité</th>",
                            "<th>Prix unitaire</th>",
                            "<th>Coût</th>",
                        "</tr>",    
                    "</thead>",
                    "<body>"
                    ;

        //----------------- -----------------------------------------       
        // On récupère la liste des ingrédients de la recette
        //----------------- -----------------------------------------    
            foreach ($ingredients as $ingredient) {  
                $idIngredient    = $ingredient['id_ingredient'];  
                // $idRecette       = $ingredient['id_ingredient'];  
                
                echo "<tr>",                        
                        "<td>".$ingredient['ingredient_name']."</td>",
                        "<td>".$ingredient['quantity']."</td>",
                        "<td>".$ingredient['unity']."</td>",
                        "<td>".$ingredient['price']."</td>",
                        "<td>".$ingredient['cost']."</td>",
                            //----------------- ----------------------------------------- 
                            // On ajoute le bouton "Supprimer Ingrédient"             
                            //----------------- -----------------------------------------                                
                            "<td>                                        
                                <a class='btSuppIng' href='traitement.php?action=suppression&idRecipe=$idRecipe&idIngredient=$idIngredient'>Supprimer ingrédient</a>
                            </td>",                                                                        
                        "</td>",
                    "</tr>";                     
            }
            echo 
            //----------------- ----------------------------------------- 
            // On ajoute le bouton "Ajout ingredient"
            //----------------- ----------------------------------------- 
                "<td>                                        
                    <a class='btnAjoutIngredient' href='ajoutIngredient.php?action=ajoutIngredient&idRecipe=$idRecipe'>Ajouter un ingredient</a>
                </td>", 
                "</body>",
                 "</table>";             
        ?>  
        
    </body>
</html> 