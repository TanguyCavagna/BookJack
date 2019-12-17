<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="manifest" href="../manifest.webmanifest">

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php require_once './includes/nav.php'; ?>

    <!-- Message for successful logout -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <?php if (isset($_SESSION['loggedOut'])) : ?>
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 alert" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" /></svg>
            <p>Successfluy logged out.</p>
        </div>
    <?php unset($_SESSION['loggedOut']);
    endif; ?>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <!-- Message for successful login -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <?php if (isset($_SESSION['loggedIn'])) : ?>
        <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 alert" role="alert">
            <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z" /></svg>
            <p>Successfuly logged in.</p>
        </div>
    <?php unset($_SESSION['loggedIn']);
    endif; ?>
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

    <div id="main" class="container mx-auto mt-5">
        <?php if (!isset($_SESSION['loggedUser'])) : ?>
            <!-- Block of information -->
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->
            <div id="info-container" class="w-4/5 mx-auto p-3 lg:flex">
                <img class="lg:mr-5 md:mx-auto" src="./img/book-lover.svg" width="400px" draggable="false">

                <div id="info" class="lg:w-6/12 md:w-full flex flex-col justify-around pl-4">
                    <h2 class="text-3xl text-black text-left font-bold">Avec BookJack, vous pouvez faire un inventaire de toutes vos lectures.</h2>

                    <p class="font-normal">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ex consectetur quisquam, asperiores facere libero est magnam porro illo modi quaerat ducimus. Magnam eligendi in hic ad nobis ratione necessitatibus accusantium.</p>

                    <button id="login" class="mt-5 bg-blue-500 hover:bg-blue-400 text-white uppercase font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">Nous rejoindre !</button>
                </div>
            </div>
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->
        <?php else: ?>
            
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="./js/utilities.js"></script>
    <script src="./js/app.js"></script>
    <script src="./js/notification.js"></script>
</body>

</html>