<?php

require_once 'User.php';

class Authentication
{
    public function log_in(string $user, string $password) : ?string
    {
        $dataUser = (new User()) -> users($user);
        
        if ($dataUser) {
            $storedPassword = (string)$dataUser->getPassword();

            $isHashed = str_starts_with($storedPassword, '$2y$')
                || str_starts_with($storedPassword, '$2a$')
                || str_starts_with($storedPassword, '$2b$');

            $valid = $isHashed ? password_verify($password, $storedPassword) : ($password === $storedPassword);

            if ($valid) {
                // Si estaba en claro, lo upgradeamos a hash automáticamente
                if (!$isHashed) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    (new User())->updatePasswordHash((int)$dataUser->getId(), $newHash);
                } elseif (password_needs_rehash($storedPassword, PASSWORD_DEFAULT)) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT);
                    (new User())->updatePasswordHash((int)$dataUser->getId(), $newHash);
                }

                $dataLogin['username'] = $dataUser->getUsername();
                $dataLogin['id'] = $dataUser -> getId();
                $dataLogin['rol'] = $dataUser -> getRole();
                $_SESSION['loggedIn'] = $dataLogin;
                
                return $dataLogin['rol'];
            } else {
                $_SESSION['login_error'] = "La contraseña ingresada es incorrecta.";
                return NULL;
            }
        } else{
            $_SESSION['login_error'] = "El usuario ingresado no se encontró en nuestra base de datos.";
            return NULL;
        }
    }

    public function log_out()
    {
        if (isset($_SESSION['loggedIn'])) {
            unset($_SESSION['loggedIn']);
        };
    }
}