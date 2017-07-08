<?php
include 'connectionToDB.php';

//dodawanie elemtów do tabeli:
$sql = "INSERT INTO Books(title, author, description) VALUES('Tytul0' , 'Autor0' , 'Opis0')";

if ($connect->query($sql) === TRUE){
    echo("Wartości zostały dodane <br>");
}
else{
    echo("Błąd: " . $sql . "<br>" . $connect->error);
}

//Niszczymy połączenie:
$connect->close(); $connect = null;
?>