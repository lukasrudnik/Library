<?php

// klasa Book implementuje serializacje obiektów php przez JSON
class Book implements JsonSerializable{
    
    private $id;
    private $title;
    private $author;
    private $description;
    
    public function __construct{ 
        
        // id ma -1 - ten obiekt nie jest połączony z żadnym rzędem w bazie danych (null)
        $this->title = '';
        $this->id = -1; 
        $this->author = '';
        $this->description = '';
    }
    
    // GETERY
    
     function getId(){
        return $this->id;
    }
    
    function getTitle(){
        return $this->title;
    }
    
    function getAuthor(){
        return $this->author;
    }
    
    function getDescription(){
        return $this->description;
    }
    
    // SETERY
    // id nie ma setera bo jest ustawione na -1 (null)
     
    function setTitle($title){
        $this->title = $title;
    }
    
    function setAuthor($author){
        $this->author = $author;
    }
    
    function setDescription($description){
        $this->description = $description;
    }
 
    // funkcja statyczna bo nie ma takiego obiektu w klacie Book
    public static function loadFromDB(mysqli $connection, $id){
        
        if(is_null($id)){     
            $result = $connection->query("SELECT * FROM Books");
        }
        else{
            $result = $connection->query("SELECT * FROM Books WHERE id=" . intval($id));
            // intval pobiera wartość całkowitą zmiennej
        }
        
        $bookList = [];
        
        if($result == true && $result->num_rows > 0){
            foreach ($result as $row){            
                $book = new Book();
                $book = id->row['id'];
                $book = title->row['title'];
                $book = $author->row['author'];
                $book = $description->row['description'];   
                
                $bookList[] = json_encode($book);
                // json_encode() zwraca wartość JSON
            }
        }
        return $bookList;
    }
  
    
    
}

?>