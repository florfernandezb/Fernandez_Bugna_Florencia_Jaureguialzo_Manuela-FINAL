<?php
require_once 'DatabaseConection.php';

class User
{
    protected $id;
    protected $email;
    protected $username;
    protected $full_name;
    protected $password;
    protected $role;

    public function users(string $username): ?User
    {
        $connect = DatabaseConection::getConection();
        $query = "SELECT * FROM users WHERE username = ?";

        $PDOStatement = $connect ->prepare($query);
        $PDOStatement -> setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement -> execute([$username]);

        $result = $PDOStatement -> fetch();

        if (!$result) {
            return null;
        }
        return $result;
    }

    public function updatePasswordHash(int $id, string $hash): void
    {
        $connect = DatabaseConection::getConection();
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $PDOStatement = $connect->prepare($query);
        $PDOStatement->execute([$hash, $id]);
    }

    public function getPassword()
    {
        return $this -> password;
    }

    public function getUsername()
    {
        return $this -> username;
    }

    public function getFullName()
    {
        return $this -> full_name;
    }

    public function getRole()
    {
        return $this -> role;
    }

    public function getEmail()
    {
        return $this -> email;
    }

    public function getId()
    {
        return $this -> id;
    }    
}