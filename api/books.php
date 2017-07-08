<?php
/*
dirname(__FILE__) — zwraca scieżkę pliku 
intval - pobiera wartość całkowitą zmiennej
json_encode() zwraca wartość JSON - przekazaną wcześniej przez jsonSerialize
*/

/* Dołączanie dodatkowych plików 
Nie działa z  __DIR__ - jest szybsze i nowsze */
$dirname = dirname(__FILE__);

include($dirname . '/src/connectionToDB.php');
include($dirname . '/src/Book.php');
//$connect = database::connectDB();


// Zwraca JSON w PHP
header('Content-Type: application/json');


/* Funckja switch do dodawania, pobierania, edycji i usuwania książek w DB
GET – używany do uzyskiwania danych z DB */
switch($_SERVER['REQUEST_METHOD']){     
    case('GET'): 
        
        if(isset($_GET['id']) && intval($_GET['id']) > 0){ 
            // Pobieram pojedynczą książkę po jej ID
            $books = Book:: loadFromDB($connect, $_GET['id']);
        }
        else{
            // Lub pobieram wszystkie książki
            $books = Book::loadFromDB($connect);
        } 
        echo json_encode($books);
        break;
        
// POST – używany do wysyłania informacji z formularzy do DB        
    case('POST'):
        
        if(!isset($_POST['_method'])){
            
            // Sprawdzenie danych przesłanych POST i oczyszczenie ich ze znaków specjalnych
            if(isset($_POST['title']) && strlen($_POST['title']) > 0 &&
               isset($_POST['author']) && strlen($_POST['author']) > 0 &&
               isset($_POST['description']) && strlen($_POST['description']) > 0){
                             
                if(!empty($_POST['title']) . $connect->real_escape_string($_POST['title']) && 
                   !empty($_POST['author']) . $connect->real_escape_string($_POST['author']) &&
                   !empty($_POST['description']) . $connect->real_escape_string($_POST['description'])){
                     
                    // Zapisywanie nowej książki w DB z danych przesłanych formularzem POST
                    $book = new Book();
                    $book->setAuthor($_POST['author']);
                    $book->setTitle($_POST['title']);
                    $book->setDescription($_POST['description']);
                    $book->addBookToDB($connect);            
                    json_encode($book);
                }
            }                         
        }
        
        // Usuwanie książki poprzez metodę: ($_POST['_method'] == 'DELETE')
        elseif($_POST['_method'] == 'DELETE'){
            
            /* Łapię książkę po jej ID i usuwam
            Usuwa książkę po przesłanym ID przez formularz $_POST['id']) - samo $id nie działa! */
            $book = Book::loadBookById($connect, $_POST['id']); 
            
            if($book->deleteBook($connect)){
                $result = "Book deleted";
            }
            else{
                $result = "Failed!";
            }
            echo json_encode($result);
        }
        break;
        
// PUT – używany do zmiany informacji (update)        
    case('PUT'):
        
        parse_str(file_get_contents('php://input'), $put_vars);
       
        if(isset($put_vars['id']) &&
           (isset($put_vars['updateAuthor']) && strlen($put_vars['updateAuthor']) > 0) ||
           (isset($put_vars['updateDescription']) && strlen($put_vars['updateDescription']) > 0) ||
           (isset($put_vars['updateTitle']) && strlen($put_vars['updateTitle']) > 0)){
           
//            if(!empty($put_vars['updateTitle']) . 
//               $connect->real_escape_string($put_vars['updateTitle']) && 
//               !empty($put_vars['updateAuthor']) . 
//               $connect->real_escape_string($put_vars['updateAuthor']) &&
//               !empty($put_vars['updateDescription']) .
//               $connect->real_escape_string($put_vars['updateDescription'])){
            
                // Dane przesłane formulrzem metodą PUT
                $id = $put_vars['id'];
                $updateAuthor = $put_vars['updateAuthor'];
                $updateDescription = $put_vars['updateDescription'];
                $updateTitle = $put_vars['updateTitle'];

                // Łapię książkę po jej ID i podmieniam dane przesłane formularzem PUT na tej książce
                $book = Book::loadBookById($connect, $id);
                $book->setAuthor($updateAuthor);
                $book->setDescription($updateDescription);
                $book->setTitle($updateTitle);
                $book->updateBook($connect);
                echo json_encode($book);
//            }
        }
        break;
        
// DELETE – używany do usuwania danych.      
    case('DELETE'):
        
        parse_str(file_get_contents('php://input'), $put_vars);
        
        // Łapię książkę po jej ID i usuwam ją
        $id = $put_vars['id'];
        $book = Book::loadBookById($connect, $id);
        
        if($book->deleteBook($connect)){
            $result = "Book deleted";
        }
        else{
            $result = "Failed!";
        }
        echo json_encode($result);
        break;
}
?>