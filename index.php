<?php
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Library page</title>
<!--        Link do bibliotekij jQuery z interfejsem AJAX-->
<!--        <link rel="stylesheet" href="css/style.css">-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="js/application.js"></script>
    </head>
    <body>
        <nav>
        </nav>
        <main>
           <section>
            <form>
                <h3>Add book:</h3>
                <label>
                    Title:
                    <br>
                    <input id="addTitle" type="text" placeholder="title" name="title">
                    <br>
                </label>
                <label>
                    Author:
                    <br>
                    <input id="addAuthor" type="text" placeholder="author" name="author">
                    <br>
                </label>
                <label>
                    Describe:
                    <br>
                    <input id="addDescription" type="text" placeholder="description" name="description">
                    <br>
                </label>
                <input id="addBook" type="submit" value="Add Book" placeholder="addBook">
            </form>
            </section>
            <section>
            <form method="GET">
                <input id="showBooks" type="submit" value="Show Books">
            </form>
            <h3>Book lists:</h3>
            <div id="bookList">       
            </div>
            </section>
        </main>
        <footer>
        </footer>
    </body>
</html>
