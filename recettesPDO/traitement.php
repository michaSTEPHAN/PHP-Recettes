<?php
    require_once(__DIR__ . '/connexionBDD.php');
    $action = $_GET['action'];   

    switch($action) {
        case "suppression" :

            // On récupère les variables passées en paramètres
            $idRecette      = isset($_GET["idRecipe"]) ? $_GET["idRecipe"] : null;
            $idIngredient   = isset($_GET["idIngredient"]) ? $_GET["idIngredient"] : null;
            
            //----------------------------------------------------------    
            // Execution du SQL pour supprimer 1 ingrédient de la recette
            //----------------------------------------------------------    
            $sqlDelIngredient   = 'DELETE FROM recipe_ingredient WHERE id_recipe = :idRecette AND id_ingredient = :idIngredient';
            $recupInstruction = $mysqlClient->prepare($sqlDelIngredient);
            $recupInstruction->execute(array('idRecette' => $idRecette, 'idIngredient' => $idIngredient));

            header("Location: index.php");        
            break;
    
        case "addIngredient" :

            $index = $_GET['idRecipe'];

            if (isset($_POST["submit"])) {
                $quantity       = filter_var($_POST["quantity"], FILTER_SANITIZE_NUMBER_INT);
                $idIngredient   = filter_var($_POST["id_ingredient"], FILTER_SANITIZE_NUMBER_INT);
                
                //----------------------------------------------------------    
                // Execution du SQL pour ajouter 1 ingrédient dans 1 recette
                //---------------------------------------------------------- 
                $sql = "INSERT INTO recipe_ingredient (quantity, id_ingredient, id_recipe)
                        VALUES (:quantity, :idIngredient, :idRecipe)";
                $ingredientFormStatement = $mysqlClient->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
                $ingredientFormStatement->execute([
                    "quantity" => $quantity,
                    "idIngredient" => $idIngredient,
                    "idRecipe" => $index
                ]);

                header("Location: index.php");    
                break;
            }              
        }
?>