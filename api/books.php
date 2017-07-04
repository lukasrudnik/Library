<?php
/*
$dir - wyświetla pliki
dirname — zwraca scieżkę pliku 
intval - pobiera wartość całkowitą zmiennej
*/

$dir = dirname(__FILE__);
include($dir . '/src/classBook.php');
include($dir . '/src/connectionToDB.php');

// zwraca JSON w PHP
header('Content-Type: application/json');

// funckja switch do dodawania, pobierania, edycji i usuwania książek w DB
switch($_SERVER['REQUEST_METHOD']){
        case($_GET): 
        // GET – używany do uzyskiwania danych - przy wartośći inval > od 0
        if(isset($_GET['id']) && intval($_GET['id']) > 0){
            // pobieram pojedynczą książkę po jej ID
            $book = Book::loadFromDB($connect, $_GET['id']);
        }
        else{
            // pobieram wszystkie książki
            $book = Book::loadFromDB($connect);     
        }
        echo json_encode($book);
        break;
}


?>