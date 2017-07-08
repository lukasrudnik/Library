<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Library</title>
        <link rel="stylesheet" href="css/style.css">
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
                   <a class="navbar-brand">Welcome in Library</a>
               </div>
            </div>
        </nav>
        <main>
            <section class="bookForm">    
            <form>
                <br><h3>Add new book:</h3><br><br>
                <label>
                    Title:
                    <br><br>
                    <input id="titleInput" class="form-control" type="text" placeholder="Add title" name="title">
                    <br>
                </label>
                <label>
                    Author:
                    <br><br>
                    <input id="authorInput" class="form-control" type="text" placeholder="Add author" name="author">
                    <br>
                </label>
                <label>
                    Description:
                    <br><br>
                    <input id="descriptionInput" class="form-control" type="text"
                            placeholder="Add description" name="description">
                    <br>
                </label>
                <input id="addBook" type="submit" value="Add Book" placeholder="Add book">
            </form>
            </section>
            <section class="showBooks">
            <form method="GET">
                <input id="showBooks" type="submit" value="Show books">
            </form>
            <br><h3>Books list:</h3><br><br>
            <div id="bookList">
            </div>
            </section>
        </main>
    </body>
     <footer>
    </footer>
</html>