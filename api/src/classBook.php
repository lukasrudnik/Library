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
    
    
    // implementujemy co ma być zwrócone i przekazane do funkcji json_encode
    public function jsonSerialize(){
        
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'description' => $this->description
        ];
        // zwraca tablice assocjacyjną z np.: kluczem id=> (o wartości) $this->id 
    }
    
    
    // funkcja statyczna bo nie ma takiego obiektu w klasie Book
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
                $book->id = $row['id'];
                $book->title = $row['title'];
                $book->author = $row['author'];
                $book->description = $row['description'];   
                
                $bookList[] = json_encode($book);
                // json_encode() zwraca wartość JSON - przy przekazaniu obiektu do funkcji jsonSerialize
            }
        }
        return $bookList;
    }
    
    
    // ładowanie książki z bazy danych poprzez id
    static public function loadById(mysqli $connection, $id){
        
        $sql = "SELECT * FROM Books WHERE ID = "; // . $connection ->real_escape_string($id);
        
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
    
    
    // dodawaie książki do bazy danych 
    public function addBook(mysqli $connection){
        
        if($this->id == -1){
            $sql = "INSRER INTO Books (title, author, description) VALUES 
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

    
    // aktualizacia książki
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
    
    
    // usuwanie książki
    public function deleteBook(mysqli $connection){
        
        if($this->id != -1){
            $sql = "DELETE FROM Books WHERE id = " . $this->id;
            
            $result = $connection->$query($sql);    
            if($result == true){
            }
            return false;
        }
    }
    
}

?>