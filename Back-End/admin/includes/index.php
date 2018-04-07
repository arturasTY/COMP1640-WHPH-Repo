<?php
/*
require_once "../includes/access.php";

if (!userIsLoggedIn('ce1')){
    include "../login_form.php";
    exit();
}

if (!userHasRole('Content Editor')){
    $error = "You do not have permission to access this page";
    include "../access_denied.php";
    exit();
}


include "../includes/db_config.php"; //database connection file

if(isset($_GET['addrecipe'])) {
   $pagetitle = 'New Recipe';
   $action = 'addform';
   $name = '';
   $img = '';
   $ing = '';
   $meth = '';
   $authorid = '';
   $id = '';
   $button = 'Add Recipe';

   // INSERT AUTHORS INTO ARRAY
   try { 
        $result = $db_connection->query('SELECT author_id, first_name FROM authors');
   }
   catch(PDOException $e) {
        $output = "Error occured when adding author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   foreach ($result as $row) {
        $authors[] = array('id' => $row['author_id'], 'name' => $row['first_name']);
   }
   // INSERT AUTHORS INTO ARRAY

   // INSERT CATEGORIES INTO ARRAY
   try {
        $result = $db_connection->query('SELECT category_id, category_name FROM category');
   }
   catch(PDOException $e) {
        $output = "Error occured when adding author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   foreach ($result as $row) {
        $categories[] = array('id' => $row['category_id'], 'name' => $row['category_name'], 'selected' => FALSE);
   }
   // INSERT CATEGORIES INTO ARRAY

   //DISPLAY ADD RECIPE FORM
   include 'formj.php';
   exit();

}*/




if(isset($_GET['addform'])) { //insert
   
    }

    try {
        $sql = "INSERT INTO Grp_Ideas SET IdeasText = :name, Comments = :ingredient";
        $s = $db_connection->prepare($sql);
        $s->bindValue(':name', $_POST['Title']);
        $s->bindValue(':ingredient', $_POST['Description']);
     
        $s->execute();
        
       

        
    } catch (PDOException $e) {
        $output = "Something went wrong, please try again" . $e->getMessage();
            echo "your shutup";
        //include "error.html.php";
        exit();
    }
       


 /*   if(isset($_POST['categories'])) {

        try {
            $sql = "INSERT INTO recipe_cat SET recipeid = :recipeid, categoryid = :categoryid";
            $s = $db_connection->prepare($sql);

            foreach ($_POST['categories'] as $categoryid) {
                $s->bindValue(':recipeid', $recipeid);
                $s->bindValue(':categoryid', $categoryid);
                $s->execute();
            }
        }
        catch (PDOException $e) {
            $output = "Error occured when inserting joke into selected category, please try again" . $e->getMessage();
            include "error.html.php";
            exit();
        }
    }
        header('Location: .');
        exit();
    }

if(isset($_POST['edit']) and $_POST['edit'] == 'Edit') {

    try {
        $sql = "SELECT recipe_id, recipe_name, recipe_ingredient, recipe_method, recipe_image, authorid FROM recipes WHERE recipe_id = :id";
        $s = $db_connection->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = "Error occures while retrieving recipes from database, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
    }

    $row = $s->fetch();

    $pagetitle = 'Edit Recipe';
    $action = 'editform';
    $name = $row['recipe_name'];
    $img = $row['recipe_image'];
    $ing = $row['recipe_ingredient'];
    $meth = $row['recipe_method'];
    $authorid = $row['authorid'];
    $id = $row['recipe_id'];
    $button = 'Update Recipe';


    //LIST OF AUTHORS
    try {
        $result = $db_connection->query('SELECT author_id, first_name FROM authors');
    }
    catch(PDOException $e) {
        $output = "Error occured when adding author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   foreach ($result as $row) {
        $authors[] = array('id' => $row['author_id'], 'name' => $row['first_name']);
   }

   //LIST OF CATEGORIES WHICH HAVE THIS JOKE
   try {
        $sql = 'SELECT categoryid FROM recipe_cat WHERE recipeid = :id ';
        $s = $db_connection->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
   }
   catch(PDOException $e) {
        $output = "Error occured when adding author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   foreach ($s as $row) {
        $selectedCategories[] = $row['categoryid'];
   }


   //LIST OF CATEGORIES
   try {
        $result = $db_connection->query('SELECT category_id, category_name FROM category');
   }
   catch(PDOException $e) {
        $output = "Error occured when adding author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   foreach ($result as $row) {
        $categories[] = array('id' => $row['category_id'], 'name' => $row['category_name'],
        'selected' => in_array($row['category_id'], $selectedCategories));
   }

   //INCLUDE POPULATED EDIT FORM
   include 'formj.php';
   exit();
}


if(isset($_GET['editform'])) {

    if($_POST['author'] == '') {
        $output = "You must choose an Author, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
    }

    try {
        $sql = 'UPDATE recipes SET recipe_name = :name, recipe_ingredient = :ingredient, recipe_method = :method, recipe_image = :recipeimg, authorid = :author WHERE recipe_id = :id';
        $s = $db_connection->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->bindValue(':name', $_POST['recipe_name']);
        $s->bindValue(':ingredient', $_POST['recipe_ingredients']);
        $s->bindValue(':method', $_POST['recipe_method']);
        $s->bindValue(':recipeimg', $_POST['recipe_image']);
        $s->bindValue(':author', $_POST['author']);
        $s->execute();
    }
    catch(PDOException $e) {
        $output = "Error occured when submiting edited joke, please try again" . $e->getMessage();
        include "error.html.php";
        exit();
   }

   }

    if(isset($_POST['delete']) and $_POST['delete'] == 'Delete') { //delete
        $id = $_POST['id'];
        include "confirm.php";
        exit();
    }

    if(isset($_POST['delete']) and $_POST['delete'] == 'Yes') {

    try {
        $sql = "DELETE FROM recipes WHERE recipe_id = :id";
        $s = $db_connection->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
        
    } catch (PDOException $e) {
        $output = "Something went wrong, please try again" . $e->getMessage();
        //include "error.html.php";
        exit();
    }
        header('Location: .'); //Redirecting back to jokes template
        exit();
    }

    try {
        $sql = "SELECT recipes.recipe_id, recipe_name, recipe_ingredient, recipe_method, first_name, email FROM recipes
        INNER JOIN authors ON authorid = author_id"; // select
        $result = $db_connection->query($sql);

    } catch (PDOException $e) {
        $output = "Something went wrong, please try again" . $e->getMessage();
        //include "error.html.php";
        exit();
    }

foreach($result as $row){ //savig results from the query into array
    $recipes[] = array (
        'id' => $row['recipe_id'], 
        'recipename' => $row['recipe_name'],
        'recipeing' => $row['recipe_ingredient'], 
        'recipemeth' => $row['recipe_method'],
        'name' => $row['first_name'],
        'email' => $row['email']);
}

include "recipes.php";
*/
?>