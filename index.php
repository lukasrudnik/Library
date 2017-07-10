<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Library</title>
        <script src="js/jquery-3.2.1.js"></script>
        <script src="js/app.js"></script>
        <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" 
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-inverse bg-primary">
           <div class="container-fluid">
               <div class="navbar-header navbar-left">
                   <a class="navbar-brand">Welcome in Library !</a>
               </div>
            </div>
        </nav>
        <main>
        <div class="container">
        <div class="jumbotron"> 
            <section class="bookFormSection">    
            <form>
                <h2>Add new book:</h2><br><br>
                <label>
                    Title:<br><br>
                    <input id="inputTitle" class="form-control" type="text" placeholder="Add title"
                    name="title"><br>
                </label>
                <label>
                    Author:<br><br>
                    <input id="inputAuthor" class="form-control" type="text" placeholder="Add author" name="author"><br>
                </label>
                <label>
                    Description:<br><br>
                    <input id="inputDescription" class="form-control" type="text"
                    placeholder="Add description" name="description"><br>
                </label><br>
                <input id="addBook" type="submit" class="btn btn-success" 
                       value="Add Book & Refresh the form" placeholder="Add book"><br><br>
            </form>
            </section>
            <section class="showBooksSection">
            <!-- Pokazywanie książek poprzez rofmularz 'GET' -->
            <form method="GET">
            <input id="showBooks" type="submit" class="btn btn-primary" value="Show books">
            </form>
            <br><h2>Books list:</h2><br><br>
            <div id="bookList"></div>
            <!-- Tutaj wyświetla się lista książek po kliknięciu przycisku -->
            </section>
        </div>
        </div>
        </main>
    </body>
    <footer>
    </footer>  
</html>