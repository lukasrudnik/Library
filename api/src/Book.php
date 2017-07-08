<?php
// klasa Book implementuje serializacje obiektów php przez JSON
class Book implements JsonSerializable{
    
    private $id;
    private $title;
    private $author;
    private $description;
    
// id ma -1 - ten obiekt nie jest połączony z żadnym rzędem w bazie danych (null)
    public function __construct(){
        $this->id = -1;
        $this->title = '';
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
    
/* SETERY
id nie ma setera bo jest ustawione na -1 (null) */
    function setTitle($title){
        $this->title = $title;
    }
    
    function setAuthor($author){
        $this->author = $author;
    }
    
    function setDescription($description){
        $this->description = $description;
    }
    
    
/* implementujemy poprzez jsonSerialize() co ma być zwrócone i przekazane do funkcji json_encode
zwracam tablice assocjacyjną z kluczem: id => o wartości: this->id */
    public function jsonSerialize(){ 
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ];
    }
    
    
/* funkcja statyczna bo nie ma takiego obiektu w klasie Book - Ładowaie wszystkich książek z DB */ 
    public static function loadFromDB(mysqli $connection, $id = null){ // null bo id jest auto_increment
        
        if(is_null($id)){ 
            $result = $connection->query("SELECT * FROM Books");
        }
        else{ 
            $result = $connection->query("SELECT * FROM Books WHERE id = '" . intval($id) . "'");
        }                                // intval — Get the integer value of a variable
        
        $bookList = [];
        
        if($result == true && $result->num_rows > 0){
            foreach ($result as $row){
                
                $dbBook  = new Book();
                $dbBook->id = $row['id'];
                $dbBook->title = $row['title'];
                $dbBook->author = $row['author'];
                $dbBook->description = $row['description'];
                
                $bookList [] = json_encode($dbBook);
            }
        }
        return $bookList;
    }
    
    
// ładowanie książki z DB poprzez id    
    static public function loadBookById(mysqli $connection, $id){
        
        $sql = "SELECT * FROM books WHERE id = " . $connection->real_escape_string($id);
        // usuwanie znaków specjalnych przy ładowaniu książki po jej id - zapobieganie sql injection
        
        $result = $connection->query($sql);
        if($result == true && $result->num_rows == 1){   
            $row = $result->fetch_assoc(); // wyniki trzymane w tablicy assocjacyjnej
            
            $book = new Book();
            $book->id = $row['id'];
            $book->setTitle($row['title']);
            $book->setAuthor($row['author']);
            $book->setDescription($row['description']);
            
            return $book;
        }
        else{
            return null;
        }
    }
    
    
// dodawaie książki do DB  
    public function addBookToDB(mysqli $connection){
        
        if($this->id == -1){       
            $sql = "INSERT INTO Books (title, author, description) 
                    VALUES ('{$this->title}' , '{$this->author}' , '{$this->description}')";
            
            if ($connection->query($sql)){
                $this->id = $connection->insert_id;
                // po zapisaniu obieku do DB przypisuje mu klucz główny jako id 
                return true;
            }
            else{
                return false;
            }
        }
    }
    

// aktualizacia książki    
    public function updateBook(mysqli $connection){
        
        if ($this->id != -1){          
            $sql = "UPDATE Books SET title= '{$this->title}' , author= '{$this->author}' 
                    , description= '{$this->description}' WHERE id= '{$this->id}'";
            
            if ($connection->query($sql)){
                return true;
            }
            else{
                return false;
            }
        }
    }
    
    
// usuwanie książki    
    public function deleteBook(mysqli $connection){
        
        if($this->id != -1){        
            $sql = "DELETE FROM Books WHERE id= '" . $this->id . "'";
            
            if($connection->query($sql)){
                return  true;
            }
            else{
                return false;
            }
        }
    }

}
?>