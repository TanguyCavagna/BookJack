<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">

    <title>Inscription</title>
</head>
<body>
    <?php require_once './includes/nav.php'; ?>

    <div class="mx-auto w-6/12 max-w-xs mt-24">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">Username</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" name="username" type="text" placeholder="Username">
                <p class="hidden text-red-500 text-xs italic error-msg">This username is already taken.</p>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="mail">Email</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mail" name="mail" type="email" placeholder="abc@efg.xyz">
                <p class="hidden text-red-500 text-xs italic error-msg">This email is already used.</p>
            </div>
            <div class="mb-8">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" placeholder="******************">
                <p class="hidden text-red-500 text-xs italic error-msg" id="errorPassword">The passwaord has to contain at least a capital, a lower case, a number nd 8 charcters.</p>
            </div>
            <div class="mb-10">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="verifyPassword">Verify password</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="verifyPassword" name="verifyPassword" type="password" placeholder="******************">
                <p class="hidden text-red-500 text-xs italic error-msg" id="errorDiffPassword">This password is not the same as the one above.</p>
            </div>
            <div class="mb-12">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="profile-picture">Profile picture</label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="profile-picture" name="profile-picture" type="file">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" type="submit" id="register">
                    Sign In
                </button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="./js/utilities.js"></script>
    <script src="./js/register.js"></script>
</body>
</html>