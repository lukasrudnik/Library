<?php
/*
dirname — zwraca scieżkę pliku 
intval - pobiera wartość całkowitą zmiennej
json_encode() zwraca wartość JSON - przekazaną wcześniej przez jsonSerialize
*/

// Dołączanie dodatkowych plików 
$dir = dirname(__FILE__);
include(__DIR__ . '/src/classBook.php');
include(__DIR__ . '/src/connectionToDB.php');

// Zwraca JSON w PHP
header('Content-Type: application/json');


// Funckja switch do dodawania, pobierania, edycji i usuwania książek w DB
switch($_SERVER['REQUEST_METHOD']){  
        
    // GET – używany do uzyskiwania danych z DB
    case('GET'):     
        if(isset($_GET['id']) && ($_GET['id']) > 0){
            // Pobieram pojedynczą książkę po jej ID
            $book = Book::loadById($connect, $_GET['id']);
            echo json_encode($book);
        }
        else{
            // Lub pobieram wszystkie książki
            $bookList = Book::loadFromDB($connect);     
            echo json_encode($bookList);
        }
        break;
        
    // POST – używany do wysyłania informacji z formularzy do DB
    case('POST'):
        if(isset($_POST['title']) && strlen($_POST['title']) > 0 &&
           isset($_POST['author']) && strlen($_POST['author']) > 0 &&
           isset($_POST['description']) && strlen($_POST['description']) > 0){
            
//            if(!empty($_POST['title']) . $connect->real_escape_string($title) && 
//               !empty($_POST['author']) . $connect->real_escape_string($author) &&
//               !empty($_POST['description']) . $connect->real_escape_string($description)){
               
                $newBook = new Book();
                $newBook->setAuthor($_POST['author']);
                $newBook->setTitle($_POST['title']);
                $newBook->setDescription($_POST['description']);
            
//            }
        }
        
        if($newBook->addBook($connect)){
            echo 'Book add to database' . json_encode($newBook);
        }
        else {
            echo 'Filed, try again!';
        }
        break;
     
    // PUT – używany do zmiany informacji (update)
    case('PUT'):
        parse_str(file_get_contents('php://input'), $put_vars);
    
        if(isset($put_vars['id']) &&
           (isset($put_vars['updateAuthor']) && strlen($put_vars['updateAuthor']) > 0) ||
           (isset($put_vars['updateTitle']) && strlen($put_vars['updateTitle']) > 0) ||
           (isset($put_vars['updateDescription']) && strlen($put_vars['updateDescription']) > 0)){
            
            if(!empty($_POST['title']) . $connect->real_escape_string($title) && 
               !empty($_POST['author']) . $connect->real_escape_string($author) &&
               !empty($_POST['description']) . $connect->real_escape_string($description)){
              
                $id = $put_vars['id'];
                $updateAuthor = $put_vars['updateAuthor'];
                $updateDescription = $put_vars['updateDescription'];
                $updateTitle = $put_vars['updateTitle'];
            
                $book = Book::loadById($connect, $id);
                $book->setAuthor($updateAuthor);
                $book->setTitle($updateTitle);
                $book->setDescription($updateDescription);
                $book->updateBook($connect);
                echo json_encode($book);
            }
        }
        break;
        
    // DELETE – używany do usuwania danych.
    case('DELETE'):
        parse_str(file_get_contents('php://input'), $put_vars);
        
        $id = $put_vars['id'];
        $book = Book::loadById($connect, $id);
        if($book->deleteBook($connect)){
            $result = "Book deleted";
        }
        else{
            $result = "Filed, try again!";
        }
        echo json_encode($result);
        break;
        
}
?>