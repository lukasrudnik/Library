<?php
// klasa Book implementuje serializacje obiektów php przez JSON
class Book implements JsonSerializable{
    
    private $id;
    private $title;
    private $author;
    private $description;
    
    public function __construct(){ 
        
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
    
    /* SETERY
     id nie ma setera bo jest ustawione na -1 (null) */  
    function setAuthor($author){
        $this->author = $author;
    }
    
    function setTitle($title){
        $this->title = $title;
    }
        
    function setDescription($description){
        $this->description = $description;
    }
    
    
    // implementujemy poprzez jsonSerialize() co ma być zwrócone i przekazane do funkcji json_encode
    public function jsonSerialize(){      
        
        // Zwracam tablice assocjacyjną z kluczem: id => o wartości: this->id 
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ]; 
    }
    
    
    /* funkcja statyczna bo nie ma takiego obiektu w klasie Book
     Ładowaie wszystkich książek z DB */
    public static function loadFromDB(mysqli $connection){
        
        $sql = "SELECT * FROM Books";
        
        $bookList = [];
      
        $result = $connection->query($sql); 
        if($result == true && $result->num_rows > 0){
            foreach ($result as $row){
                
                $book = new Book();
                $book->id = $row['id'];
                $book->title = $row['title'];
                $book->author = $row['author'];
                $book->description = $row['description'];   
                
                $bookList[] = $book;     
            }
        }
        return $bookList;
    }
    
    
    // Ładowanie książki z DB poprzez id
    static public function loadById(mysqli $connection, $id){
        
        $sql = "SELECT * FROM Books WHERE id = $id";
        
        $result = $connection->$query($sql);    
        if($result == true && $result->num_rows == 1){
            $row = $result->fetch_assoc();
            
            $book = new Book();
            $book->id = $row['id'];
            $book->title = $row['title'];
            $book->author = $row['author'];
            $book->description = $row['description'];
            
            return $book;   
        }
        return null;     
    }

    
    // Dodawaie książki do DB
    public function addBook(mysqli $connection){
        
        if($this->id == -1){
            $sql = "INSERT INTO Books (title, author, description) VALUES 
            ('{$this->tittle}' , '{$this->author}' , '{$this->description}')";
            
            $result = $connection->$query($sql);    
            if($result == true){
                $this->id = $connection->insert_id; 
                // po zapisaniu obieku do DB przypisuje mu klucz główny jako id     
                return true;
            }
            return false;
        }   
    }

    
    // Aktualizacia książki
    public function updateBook(mysli $connection){
        
        if($this->id != 1){
            $sql = "UPDATE Books SET title='{$this->title}' , author='{$this->author}' , 
            description='{$this->description}' WHERE id='{$this->id}'";
            
            $result = $connection->$query($sql);    
            if($result == true){
                return true;
            }
            return false;
        }
    }
    
    
    // Usuwanie książki
    public function deleteBook(mysqli $connection){
        
        if($this->id != -1){
            $sql = "DELETE FROM Books WHERE id = {$this->id}";
            
            $result = $connection->$query($sql);    
            if($result == true){
                $this->id = -1;
            }
            return false;
        }
    }
    
}
?>