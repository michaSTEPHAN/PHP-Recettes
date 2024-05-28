<h1>Exercice Recettes</h1>
<p>Ajouter un ingrédient à une recette<br></p>
<h2>Résultat</h2>

<?php
    require_once(__DIR__ . '/connexionBDD.php');
    $pageTitle = "Détail de la recette";
    $idRecipe = $_GET['idRecipe'];     
    echo "Modification de la recette : idRecipe = ".$idRecipe."<br>";
    
    //----------------- -----------------------------------------       
    // Execution du SQL pour récupérer tous les ingédients 
    //   qui ne sont PAS dans la recette passée en param
    //----------------------------------------------------------
    $sqlQueryListeIngredient = 'SELECT *
        FROM ingredient i
        WHERE i.id_ingredient NOT IN (
        SELECT distinct i2.id_ingredient 
        FROM ingredient i2
        INNER JOIN recipe_ingredient ri ON ri.id_ingredient = i2.id_ingredient
        WHERE id_recipe = :idRecipe)
        ORDER BY i.ingredient_name';
    $recupIngredient = $mysqlClient->prepare($sqlQueryListeIngredient);

    $recupIngredient->execute(['idRecipe' => $idRecipe]);
    $ingredients = $recupIngredient->fetchAll();

    // On récupère les données de la table ingredient
    $listeIngredients = [];
    foreach ($ingredients as $ingredient) {
        $listeIngredients[] = $ingredient;
    }    
    
?>   

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>  
        <div class="container">
            <div class="addIngredient">
                <form class="addIng" action="traitement.php?action=addIngredient&idRecipe=<?=$_GET['idRecipe']?>" method="POST" enctype="multipart/form-data"> 
                    <p>
                        <label class="label">
                            id Ingrédient :
                            <select class="ldIngredient" name="id_ingredient" value="<?= $listeIngredients['id_ingredient']; ?>" >
                                <?php foreach ($listeIngredients as $listeIngredients) {
                                    echo "<option value='{$listeIngredients['id_ingredient']}'>{$listeIngredients['ingredient_name']}</option>";
                                } ?>
                            </select>
                        </label>
                    </p>
                    <p>
                        <label class="Label">
                            Quantité :
                            <input class="quantity" type="number" name="quantity" min="0" step="any">
                        </label>
                    </p>            
                    <p>
                        <input class="btnAjoutIngredientRecette" type="submit" name="submit" value="Ajouter l'ingrédient à la recette">
                    </p>
                </form>
            </div>
        </div>
    </body>
</html>