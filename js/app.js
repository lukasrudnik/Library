$(function(){
/* event.preventDefault() - domyślna akcja zdarzenia nie zostanie uruchomiona.
append(newElement) – wstaw nowy element na koniec dzieci już istniejącego elementu. 
.parent pobierze element nadrzędny każdego elementu w bieżącym zestawie dopasowanych elementów.

Funkcja wyświetlania książek z DB metodą GET (odbieranie danych), połączenie z Books.php
W function(result) trzymana jest tablica z książkami. Obiekt JavaScript wyciąga je z tablicy.
Nowa klasa 'singleBook' jest dodana do diva 'bookDiv', który wyświetla tytuł książki.
Łapię diva po id='bookList' z index.php i wstawiam go append(bookDiv), który ma dodną klasę 'singleBook. Teraz też będzie wyświetlał rozwinięcie pojedynczej książki */
    function loadAllBooks(){
        $.ajax({
            url: 'api/Books.php',
            type: 'GET',
            dataType: 'json',
            success: function(result){                 
                for(var i = 0; i < result.length; i++){          
                    var book = JSON.parse(result[i]);        
                    var bookDiv = $('<div>'); 
                    bookDiv.addClass('singleBook'); 
                    bookDiv.html('<h3 data-id="' + book.id + '">' + book.title + '</h3><div class="description"></div></div>');
                    $('#bookList').append(bookDiv); 
                }
            },
            error: function(){
                console.log('Failed!');
            } // komunikat o błędzie wyświetlania książek
        });
    }
    
    
    /* metoda reload() jest używana do ponownego ładowania bieżącej strony 
    działa tak samo jak przycisk przeładowania w przeglądarce.
    łapię diva po id='bookList' */
    function reload(){
        $('#bookList').html('');
        loadAllBooks();
    }
    
    
    // łapię przycisk o id="showBooks i dodaje funkcje kliknięcia i wyświetlenia #bookList
    $('#showBooks').on('click', function(event){
        $('#bookList').html('');
        event.preventDefault(); 
        loadAllBooks();
    });

    
    /* funkcja dodająca nowe książki do DB 
    łapię przycisk po id='addBook' i po kliknięciu dodje domyślną akcje 
    .on click dodaje tylko jedną książkę */
    $('#addBook').on('click', function(event){
        event.preventDefault();
        
        // łapię dane z formularza po ich id
        var addTitle = $('#inputTitle').val();
        var addAuthor = $('#inputAuthor').val();
        var addDescription = $('#inputDescription').val();
        
        // wwsadzenie do tablicy ajaksowej danych wpisanych w formularzu 
        var AjaxToSend = {};
        AjaxToSend.title = addTitle;
        AjaxToSend.author = addAuthor;
        AjaxToSend.description = addDescription;
        
        /* wysłanie danych POSTEM przez ajax do Books.php */
        $.ajax({
            url: 'api/Books.php',
            type: 'POST',
            data: AjaxToSend, // data wysyłana przez ajax
            dataType: 'json',
            success: function(){
                console.log('Book added');
                reload(); // alert o dodaniu książki i przeładowanie strony funkcją reload()
            },
            error: function(){
                console.log('Failed added book!'); // lub komunikat o błędzie dodania 
            },
            complete: function(){
            }
        });
    });

    
    /* Edycja i usuwanie rozwiniętej pojedynczej książki. Łapię diva po id='bookList' z index.php 
    I dodaję klasę 'singleBook' dodaną wcześniej do diva 'bookDiv'. 
    I dodaję funkcję rozwinięcia po kliknięciu */  
     $('#bookList').on('click', '.singleBook', function showForm(){
         event.preventDefault();
         var book = {};
         book.id = $(this).find('h3').data('id');
         var bookInfo = $(this).find('.description');
                   
         /* odbieranie danych GET z Books.php z danymi książki, dane wyśwetlane są w formularzu jako placecholder */    
         $.ajax({
             url: 'api/Books.php',
             type: 'GET',
             data: {id: book.id}, // data wysyłana przez ajax
             dataType: 'json',
                    
             // formularz do zmiany edycji danych książek z odebranymi danymi z GET
             success: function (result){
                 var resultParase = JSON.parse(result);
                 
                 // wyświetlanie autora i opisu książki po rozwinięciu 
                 var Form = 'Author: ' + resultParase.author + '<br>'
                 + 'Description: ' + resultParase.description + '<br><br>'
                 + '<div id = "updateForm"><form>'
                 
                 // dane formularza do zmiany
                 + '<label>Change Title: <input id="updateTitle" type="text" name="updateTitle" placeholder="' + resultParase.title + '"></label><br>'
                 
                 + '<label>Change Author: <input id ="updateAuthor" type="text" name="updateAuthor" placeholder="' + resultParase.author + '"></label><br>'
                 
                 + '<lab>Change Description: <input id="updateDescription" type="text" name="updateDescription" placeholder="' + resultParase.description + '"></label><br>'
                 
                 + '<label><input id="updateSubmit" type="submit" name="updateSubmit" value="Change values"></label>'  
                 + '<label><input id="deleteBook" type="submit" value="Delete this Book"></label>'
                 + '</form></div>';   
                 bookInfo.html(Form); // (rozwala się formularz jak domknę tego <lab> w 116 linii!)
            },
            error: function(err){
                console.log('Error!');
                console.log(err);
                // lub powiadomienie o błędzie zmiany danych
            },
            complete: function(){
            } // zkończenie funkcji

        });
    });
    
    // wpisywanie danych do formularza  
    $('#bookList').on('click', '#updateForm', function(event){
        event.stopPropagation();
    });

    // odebranie danch z formularza po kliknięciu "submit" i parent() - znajduje rodzica elementu,
    $('#bookList').on('click', '#updateSubmit', function(event){
        event.stopPropagation();
        event.preventDefault();
        var book = {};
        
        // pobieranie rodziców zmienianego elementu 
        book.id = $(this).parent().parent().parent().parent().parent().parent().find('h3').data('id');
        book.updateAuthor = $('#updateAuthor').val();
        book.updateTitle = $('#updateTitle').val();
        book.updateDescription = $('#updateDescription').val();
         
        // wysłanie ajaxem formularza PUT do Books.php ze zmianami danych
        $.ajax({
            url: 'api/Books.php',
            type: 'PUT',
            data: { // data wysyłana przez ajax
                id: book.id,
                updateAuthor: book.updateAuthor,
                updateTitle: book.updateTitle,
                updateDescription: book.updateDescription
            },
            
            dataType: 'json',
            success: function(result){ 
                
                var LabelToChange = $("h3[data-id='" + result.id + "']");
                
                LabelToChange.html(result.title);
                var changeName = 'Autor: ' + result.author + '<br>'
                               + 'Opis: ' + result.description + '<br>';
                
                $(LabelToChange).parent().find('.description').html(changeName);
            },
            error: function(err){
                console.log('Error!');
                console.log(err);
                // lub powiadomienie o błędzie zmiany danych
            },
            complete: function(){
            } // zkończenie funkcji
        });
    });
    
    
    // usuwanie książki złapanej po id='bookList' z index.php (id diva) 
    $('#bookList').on('click', '#deleteBook', function(event){
        event.stopPropagation();
        event.preventDefault();

        // pobieranie rodziców usuwanego elementu 
        var BookToDel = $(this).parent().parent().parent().parent().parent().parent().find('h3').data('id');
        
        // wysałanie ajaxem formularza (POST _method DELETE) do Books.php z skasowaniem książki
        $.ajax({
            url: 'api/Books.php',
            type: 'POST',
            data: {id: BookToDel, _method: 'DELETE'}, // data wysyłana przez ajax
            dataType: 'json',
            success: function(result){
                alert(result); // wyświetlenie allertu o usunięciu książki 
                reload(); // przeładowanie strony 
            },
            error: function(err){
                console.log('Error!');
                // lub powiadomienie o błędzie zmiany danych
            },
            complete: function(){
            } // zkończenie funkcji
        });
    });
}); 