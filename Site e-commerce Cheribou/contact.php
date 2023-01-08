<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <link href="./include/contact.css" rel="stylesheet">
    <?php require("./include/header.php"); ?>
</head>
<body>
    <div class="contactez-nous">
        <h2>Contactez-nous</h2>
        <form action="./include/traitFormContact.php" method="post">
            <div>
                <label for="nom">Votre nom</label>
                <input type="text" id="nom" name="nom" placeholder="Martin" required>
            </div>
            <div>
                <label for="email">Votre e-mail</label>
                <input type="email" id="email" name="email" placeholder="monadresse@mail.com" required>
            </div>
            <div>
                <label for="sujet">Quel est le sujet de votre message ?</label>
                <select name="sujet" id="sujet" required>
                    <option value="" disabled selected hidden>Choisissez le sujet de votre message</option>
                    <option value="probleme-compte">Probl&egraveme avec mon compte</option>
                    <option value="question-produit">Question &agrave propos d&#039un produit</option>
                    <option value="suivi-commande">Suivi de ma commande</option>
                    <option value="autre">Autre...</option>
                </select>
            </div>
            <div>
                <label for="message">Votre message</label>
                <textarea id="message" name="message" placeholder="Bonjour, je vous contacte car...." required></textarea>
            </div>
            <div>
                <button type="submit" name="val"> Envoyer mon message </button>
                <?php
                echo "<p><b>Message bien envoye</b></p>";
                ?>
            </div>
        </form></body></html>