<?php

require_once 'User.php';

class Authentication
{
    public function log_in(string $user, string $password): ?string
    {
        $dataUser = (new User())->users($user);

        if ($dataUser) {

            $storedPassword = $dataUser->getPassword();

            if (password_verify($password, $storedPassword) || $password === $storedPassword) {

                if (!password_verify($password, $storedPassword)) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    (new User())->updatePasswordHash((int)$dataUser->getId(), $newHash);
                }

                $_SESSION['loggedIn'] = [
                    'id' => $dataUser->getId(),
                    'username' => $dataUser->getUsername(),
                    'rol' => $dataUser->getRole()
                ];

                return $dataUser->getRole();

            } else {
                $_SESSION['login_error'] = "La contraseña ingresada es incorrecta.";
                return null;
            }

        } else {
            $_SESSION['login_error'] = "El usuario ingresado no se encontró en nuestra base de datos.";
            return null;
        }
    }

    public function log_out(): void
    {
        unset($_SESSION['loggedIn']);
    }
}