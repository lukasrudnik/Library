<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "Bookstore_DB";

$connect = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($connect->connect_error){
    die("Error connect to database! <br> " . $connect->connect_error);
}

/*
// połączenie do DB poprzez klasę - nie bardzo daiała z dodawaniem tabeli przez narzędzie... :(
class database{
    
    // brak połączenia do DB - metoda statyczna, uruchamiana przez self::
    static private $connection = null; 
    
    // funkcja połączeia do DB
    static public function connectDB(){
        
        // jeśli $connection nie jest null - to połaczenie do DB
        if(!is_null(self::$connection)){
            return self::$connection;
        }
        else{
            self::$connection = new msqli('localhost' , 'root' , '' , 'Bookstore_DB');
            // domyślny zestaw znaków
            self::$connection->set_charset('utf8'); 
            
            // wyświetlanie komunikatu błędu połączenia do DB i zrywanie połączenia
            if(self::$connection->connect_error){
                die('Error connect to database! <br>' . self::$connection->connect_error);
            }
            return self::$connection;
        }
    }
    
    // metoda statyczna zamykająca połączenie do DB 
    static public function disconnectDB(){
        self::$connection->close();
        self::$connection = null;
        return true;
    }    
}
*/
?>