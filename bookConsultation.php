<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>ModFitBathrooms</title>
		<script
			src="https://kit.fontawesome.com/64d17730cf.js"
			crossorigin="anonymous"
		></script>
		<link rel="icon" href="img/favicon.png" type="image/png" />
		<link rel="stylesheet" href="css/google.css" />
		<link rel="stylesheet" href="css/main.css" />
		<!-- css do lightboxa -->
		<link href="css/lightboxStyle.css" rel="stylesheet" />
		<!-- css do lightboxa -->
		<!-- font -->
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
			rel="stylesheet"
		/>
		<!-- font -->
	</head>
	<body>
		<nav class="nav">
			<div class="wrapper">
				<div class="nav__logo">
					<i class="fa-solid fa-toolbox nav__logo-img"></i>
					<a href="index.html" class="nav__item">ModFitBathrooms</a>
				</div>
				<div class="nav__links">
					<a href="gallery.html" class="nav__links__item">Gallery</a>
					<a href="portfolio.html" class="nav__links__item">Portfolio</a>
					<a href="aboutus.html" class="nav__links__item">About Us</a>
					<a href="contact.html" class="nav__links__item">Contact</a>
				</div>
				<i class="fa-solid fa-bars burger" onclick="void(0)"></i>

				<ul class="nav__links__mobile">
					<i class="fa-solid fa-xmark close" onclick="void(0)"></i>
					<li>
						<a href="gallery.html" class="nav__links__mobile-item">Gallery</a>
					</li>
					<li>
						<a href="portfolio.html" class="nav__links__mobile-item"
							>Portfolio</a
						>
					</li>
					<li>
						<a href="aboutus.html" class="nav__links__mobile-item">About Us</a>
					</li>
					<li>
						<a href="contact.html" class="nav__links__mobile-item">Contact</a>
					</li>
				</ul>
			</div>
		</nav>

		<header class="portfolio-contact">
			<div class="shadow"></div>
			<div class="wrapper">
				<div class="portfolio-contact__text">
					<h2 id="h2" style="font-size: 4rem; line-height: 1.5">
					<p>Request</p>
					</h2>
				</div>
			</div>
		</header>
		<main class="main">
			<section class="bookConsultation">
			<div class="wrapper">
			
			<?php
// Wyłączenie wyświetlania błędów na stronie
ini_set('display_errors', '0'); 
ini_set('log_errors', '1');

// Wczytanie PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Pobranie danych z formularza i zabezpieczenie przed XSS
    $name = htmlspecialchars($_POST['name']);
    $phone = htmlspecialchars($_POST['phone']);
    $text = htmlspecialchars($_POST['text']);
    $number = 1;

    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Phone:</strong> $phone</p>";
    echo "<p><strong>Message:</strong></p><p>$text</p>";

    // Obsługa plików
    $uploadFolder = 'test/'; // Katalog docelowy
    $filesUploaded = [];

    if (isset($_FILES['files']) && !empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
            $fileName = $_FILES['files']['name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            // Sprawdź błędy
            if ($fileError === UPLOAD_ERR_OK) {
                $fileDestination = $uploadFolder . basename($fileName);

                if (move_uploaded_file($tmpName, $fileDestination)) {
                    echo "<p><strong>File no.</strong> $number successfully uploaded</p>";
                    $number++;
                    $filesUploaded[] = $fileDestination;
                } else {
                    echo "<p>Error moving the file: <strong>$fileName</strong></p>";
                }
            }
        }
      
       
    } else {
		echo "";
        echo "<p><strong>No files uploaded, or file size too large.</strong></p>";
        echo "<p style='font-size:2rem'><strong>Max 3 photos</strong></p>";
        echo "<a href='index.html' class='mainCall__btn'><i class='fa-solid fa-house'></i>&nbsp;Home Page</a>";
		exit();
    }

    // Konfiguracja PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Ustawienia serwera SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.wp.pl'; // Serwer SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'stokrutka112@wp.pl'; // Twój adres e-mail
        $mail->Password = 'nysjiw-nemhiw-8nocrU'; // Hasło do e-maila
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Ustawienia odbiorcy i nadawcy
        $mail->setFrom('stokrutka112@wp.pl', 'PAGE_POST'); // Adres nadawcy
        $mail->addAddress('modfitbathrooms@gmail.com', 'Jakub Fedyna'); // Adres odbiorcy

        // Treść e-maila
        $mail->isHTML(true);
        $mail->Subject = 'New Request';
        $mail->Body = "
            <html>
            <head>
            <title>New Request</title>
            </head>
            <body>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Message:</strong></p>
            <p>$text</p>
            </body>
            </html>
        ";

        // Dodanie załączników
        foreach ($filesUploaded as $filePath) {
            $mail->addAttachment($filePath);
        }

        // Wyślij e-mail
        $mail->send();
        echo "<p><strong>Request sent successfully</strong></p>";
		echo "<a href='index.html' class='mainCall__btn'><i class='fa-solid fa-house'></i>&nbsp;Home Page</a>";
    } catch (Exception $e) {
        echo "<p><strong>Failed to send request:</strong> {$mail->ErrorInfo}</p>";
    }
} else {
    // Jeśli dostęp bezpośredni, przekieruj z powrotem do formularza
    header("Location: form.html");
    exit();
}
?>

			
			</div>
			</section>
		</main>
		<footer class="footer">
			<div class="wrapper">
				<div class="footer__up">
					<a href="tel:+44123456789" class="footer__tel" onclick="void(0)"
						><i class="fa-solid fa-mobile-screen-button shake"></i>&nbsp;+44 123
						456 789</a
					>

					<a href="tel:+44123456789" class="footer__mail" onclick="void(0)"
						><i class="fa-solid fa-at"></i>&nbsp;modfitbathrooms@gmail.com</a
					>

					<p>Professional renovation you can trust.</p>
				</div>
				<div class="footer__down">
					<p>© 2024 ModFitBathrooms - All Rights Reserved</p>
				</div>
			</div>
		</footer>

		<script
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAGM5Lf6ssnP98R1OWYpLORdwTdVimrEG4&libraries=places&callback=initMap"
			async
			defer
		></script>
		<script src="./js/google.js" defer></script>
		<script src="./js/lightbox-jquery.js"></script>
		<script src="./js/main.js"></script>
	</body>
</html>
<!--  -->
