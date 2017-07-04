<?php

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "Bookstore_DB";

$connect = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($connect->connect_error){
    die("Error connect to database! <br> " . $connect->connect_error);
}

//class database{
//    
//    // brak połączenia do bazy danych - metoda statyczna, uruchamiana przez self::
//    static private $connection = null; 
//    
//    // połączeie do bazy danych
//    static public function connectToDB(){
//        
//        // jeśli $connection nie jest null -> połaczenie do DB
//        if(self::$connection != null){
//            self::connectToDB;
//        }
//        else{
//            self::$connection = new msqli('localhost' , 'root' , '' , 'Bookstore_DB');
////            self::$connection->set_charset('utf8'); // domyślny zestaw znaków
//            
//            if(self::$connection->connect_error){
//                die('Error connect to database! <br>' . self::$connection);
//            }
//            return self::$connection;
//        }
//    }
//    static public function disconnectToDB(){
//        self::$connection->close();
//        self::$connection = null;
//        return true;
//    }
//     
//}

?>