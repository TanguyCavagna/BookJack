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
        <?php else : ?>
            <!-- Search bar block -->
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->
            <div id="search-bar">
                <div class="bg-transparent rounded px-8 pt-6 pb-8 mb-4">
                    <div class="mb-4 flex xl:flex-row lg:flex-col md:flex-col sm:flex-col flex-col justify-between">
                        <!-- Select type of search -->
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->
                        <div class="inline-block relative xl:w-32 xl:mb-0 lg:mb-3 sm:mb-3 mb-3">
                            <select id="search-type" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                <option value="manga">Manga</option>
                                <option value="novel">Novel</option>
                                <option value="comic">Comic</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->

                        <!-- Search bar -->
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->
                        <input id="search-terms" class="shadow appearance-none border rounded xl:w-3/5 xl:mb-0 lg:mb-3 sm:mb-3 mb-3 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="search-terms" name="search-term" type="text" placeholder="Search on the web">
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->

                        <!-- Search button -->
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->
                        <button id="search" class="xl:w-30 xl:mb-0 lg:mb-3 sm:mb-3 mb-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Search
                        </button>
                        <button id="lucky-day" class="xl:w-30 xl:mb-0 lg:mb-3 sm:mb-3 mb-3 bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                            Lucky ?
                        </button>
                        <!-- ~~~~~~~~~~~~~~~~~~~~ -->
                    </div>
                </form>
            </div>
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->

            <!-- Results block -->
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->
            <div id="results" class="flex flex-wrap flex-row justify-between"></div>
            <!-- ~~~~~~~~~~~~~~~~~~~~ -->
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="./js/utilities.js"></script>
    <script src="./js/notification.js"></script>
    <script src="./js/jikan.js"></script>
    <script src="./js/app.js"></script>
</body>

</html>