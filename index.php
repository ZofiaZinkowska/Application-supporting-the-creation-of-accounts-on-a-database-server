<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="pl" >
<head>
    <!-- kodowanie znaków, możemy używać polskich znaków -->
    <meta charset="UTF-8" />
    <!-- tytuł strony -->
    <title> Aplikacja do zakładania kont na serwerze baz danych </title>
    <!-- importuje czcionkę, którą chce użyć -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&family=Zen+Kaku+Gothic+Antique:wght@300&display=swap" rel="stylesheet">

    <!-- dodaje plik css.css -->
    <link rel="stylesheet" href="css.css" />
</head>
<body>
    <div id="container">
        <nav>
            <a class="menu" href="index.php">Strona główna</a>
			<a class="menu" href="login.php">Login</a>
			<a class="menu" href="register.php">Register</a>
        </nav>
        
	        <article>
				<h1>Aplikacja do zakładania kont na serwerze baz danych</h1>
                <p>
                Projekt ma na celu rozwiązanie problemu przestarzałego oprogramowania systemu wspomagającego zakładanie
kont na serwerze baz danych. Pomysł na aplikacje powstał podczas rozmowy z dr inż. Bartoszem Reichelem
oraz brakiem nowoczesnej koncepcji do rozwiązania problemu. Przedsięwzięcie dąży do wypełnienia brakujących
potrzeb w systemie na Wydziale FTiMS. 
                </p>
			</article>
        <section>
			<?php
			include '../projektIO/dump.php';

            ?>
		</section>
        <footer>
        </footer>
    </div>
</body>
</html>