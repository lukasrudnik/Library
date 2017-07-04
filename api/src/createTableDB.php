<?php

include 'connectionToDB.php';

$sql = "CREATE TABLE Books (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        author VARCHAR(255) NOT NULL,
        description VARCHAR(255) NOT NULL
        )";

$result = $connect->query($sql);
if($result === TRUE){
    echo ("Tabela Books została stworzona poprawine.");
}
else{
    ("Błąd podczas tworzenia tabeli Books!" . "<br>" . $connect->error);
}
echo "<br>";

?>