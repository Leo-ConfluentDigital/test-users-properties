<?php

namespace App;

require_once __DIR__ . '/vendor/autoload.php';

use App\class\User;
use App\controllers\UserController;

/*$user = new User("John", "Doe", "john16^gmail.com", "000000000");*/

$blacklist = json_decode(file_get_contents(__DIR__.'/blacklist.json'), true);

$user = new User("John", "Doe", "john12@gmail.com", "+33640848933");
$controller = new UserController($blacklist, $user);

echo "--------------------------------------\n";
echo "TESTING VALID USERS NAME\n";
$result = $controller->testValidUsersName();
if (!empty($result)) {
    foreach ($result as $user) {
        echo "User with name: {$user->getName()} is invalid\n";
    }
}

echo "TESTING VALID USERS LAST NAME\n";
$result = $controller->testValidUsersLastName();
if (!empty($result)) {
    foreach ($result as $user) {
        echo "User with last name: {$user->getLastName()} is invalid\n";
    }
}

echo "TESTING VALID USERS EMAIL\n";
$result = $controller->testValidUsersEmail();
if (!empty($result)) {
    foreach ($result as $user) {
        echo "User with email: {$user->getEmail()} is invalid\n";
    }
}

echo "TESTING VALID USERS PHONE\n";
$result = $controller->testValidUsersPhone();
if (!empty($result)) {
    foreach ($result as $user) {
        echo "User with phone: {$user->getPhone()} is invalid\n";
    }
}
echo "--------------------------------------\n";