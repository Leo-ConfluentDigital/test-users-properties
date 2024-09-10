<?php

namespace App\controllers;

use App\class\User;

class UserController
{

    /**
     * @var User[]
     */
    private array $users;
    private array $blacklist;

    public function __construct($blacklist,...$users, )
    {
        $this->users = $users;
        $this->blacklist = $blacklist;
    }

    public function testValidUsersName(): ?array
    {
        $errors = [];
        foreach ($this->users as $user) {
            if (empty($user->getName())) {
                $errors[] = $user;
                continue;
            }
            // if name contains less than 3 characters
            if (strlen($user->getName()) < 3) {
                $errors[] = $user;
                continue;
            }
        }
        return empty($errors) ? null : $errors;
    }

    public function testValidUsersLastName(): ?array
    {
        $errors = [];
        foreach ($this->users as $user) {
            if (empty($user->getLastName())) {
                $errors[] = $user;
                continue;
            }
            // if last name contains less than 3 characters
            if (strlen($user->getLastName()) < 3) {
                $errors[] = $user;
                continue;
            }
        }
        return empty($errors) ? null : $errors;
    }

    public function testValidUsersEmail(): ?array
    {
        $errors = [];
        foreach ($this->users as $user) {
            if (empty($user->getEmail())) {
                $errors[] = $user;
                continue;
            }

            // if invalid email
            if(!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)){
                $errors[] = $user;
                continue;
            }
            // if email contains more than 2 @
            if(substr_count($user->getEmail(), '@') > 1){
                $errors[] = $user;
                continue;
            }

            // if DNS doesn't exist
            list($userMail, $domain) = explode('@', $user->getEmail());
            if (!checkdnsrr($domain)) {
                $errors[] = $user;
                continue;
            }

            // regex more strict
            $regex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
            if (!preg_match($regex, $user->getEmail())) {
                $errors[] = $user;
                continue;
            }

            // if email contains name or last name with 1 or 2 characters
            $name = preg_quote($user->getName(), '/'); // Escape any special characters
            $lastName = preg_quote($user->getLastName(), '/'); // Escape any special characters
            $email = $user->getEmail();

            if (preg_match("/\b($name|$lastName).{1,2}\b/i", $email)) {
                $errors[] = $user;
                continue;
            }

            // test blacklist
            if (in_array($user->getEmail(), $this->blacklist['email'])) {
                $errors[] = $user;
                continue;
            }
        }
        return empty($errors) ? null : $errors;
    }

    public function testValidUsersPhone(): ?array
    {
        $errors = [];
        foreach ($this->users as $user) {
            if (empty($user->getPhone())) {
                $errors[] = $user;
                continue;
            }
            // if phone contains less than 9 numbers
            if(preg_match('/^[0-9]{9}$/', $user->getPhone())){
                $errors[] = $user;
                continue;
            }
            // if phone contains same number
            if(preg_match('/(.)\1{8,}/', $user->getPhone())){
                $errors[] = $user;
                continue;
            }
            // if number contains 3 or more consecutive numbers
            if(preg_match('/(\d)\1{2,}/', $user->getPhone())){
                $errors[] = $user;
                continue;
            }
            // if number start with +
            if(preg_match('/^\+/', $user->getPhone())){
                $sedondChar = substr($user->getPhone(), 1, 1);
                $thirdChar = substr($user->getPhone(), 2, 1);

                // if foutage de gueule
                if ($sedondChar == 0 || $thirdChar == 0) {
                    $errors[] = $user;
                    continue;
                }

                // if phone start with +33 (France)
                if ($sedondChar == 3 || $thirdChar == 3) {
                    // if phone don't contain 9 numbers
                    if (strlen($user->getPhone()) != 12) {
                        $errors[] = $user;
                        continue;
                    }
                }

                // if phone start with +32 (Espagne)
                if ($sedondChar == 2 || $thirdChar == 2) {
                    // if phone don't contain 9 numbers
                    if (strlen($user->getPhone()) != 11) {
                        $errors[] = $user;
                        continue;
                    }
                }
            }

            // test blacklist
            if (in_array($user->getPhone(), $this->blacklist['phone'])) {
                $errors[] = $user;
                continue;
            }
        }
        return empty($errors) ? null : $errors;
    }
}