<?php
require_once "includes/classes/Constants.php";
class Account
{
    private PDO $conn;
    private array $errorArray = [];

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:dbname=netflix;host=localhost", "root", "dabok1977");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function register(string $fn, string $ln, string $un,string $em, string $em2 , string $pw, string $pw2): bool
    {
        $this->validateFirstName($fn);
        $this->validateLastName($ln);
        $this->validateUserName($un);
        $this->validateEmail($em, $em2);
        $this->validatePassword($pw, $pw2);

        if (empty($this->errorArray)) {
            return $this->insertUserDetails($fn, $ln, $un, $em, $pw);
        }

        $this->errorArray[] = Constants::$loginFailed;
        return false;
    }

    public function login(string $un, string $pw): bool
    {
        $user = $this->selectUserByUserName($un);

        if (($user['username'] === $un) && password_verify($pw, $user['password'])) {
            return true;
        }
        $this->errorArray[] = Constants::$loginFailed;
        return false;
    }

    private function selectUserByUserName(string $un)
    {
        $sql = "SELECT * FROM nf_user WHERE username = :un";
        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':un', $un, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() == 1) {
            $user = $statement->fetch();
            $statement->closeCursor();

            return $user;
        }
        return false;
    }

    public function insertUserDetails(string $fn, string $ln, string $un, string $em, string $pw): bool
    {
        $passwordHash = password_hash($pw, PASSWORD_DEFAULT);
        $sql = 'INSERT INTO nf_user(firstName, lastName, userName, email, password) VALUES (:firstName, :lastName, :userName, :email, :password)';

        $statement = $this->conn->prepare($sql);
        $statement->bindValue(':firstName', $fn, PDO::PARAM_STR);
        $statement->bindValue(':lastName', $ln, PDO::PARAM_STR);
        $statement->bindValue(':userName', $un, PDO::PARAM_STR);
        $statement->bindValue(':email', $em, PDO::PARAM_STR);
        $statement->bindValue(':password', $passwordHash, PDO::PARAM_STR);

        return $statement->execute();
    }

    private function validateFirstName(string $fn): void
    {
        if (strlen($fn) < 2 || strlen($fn) > 25) {
            $this->errorArray[] = Constants::$firstNameCharacters;
        }
    }

    private function validateLastName(string $ln): void
    {
        if (strlen($ln) < 2 || strlen($ln) > 25) {
            $this->errorArray[] = Constants::$lastNameCharacters;
        }
    }

    private function validateUserName(string $un): void
    {
        if (strlen($un) < 2 || strlen($un) > 25) {
            $this->errorArray[] = Constants::$userNameCharacters;
            return;
        }
        $sql = "SELECT * FROM nf_user WHERE username = :un";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':un', $un, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() != 0) {
            $this->errorArray[] = Constants::$userNameTaken;
        }
    }

    private function validateEmail(string $em, string $em2): void
    {
        if ($em != $em2) {
            $this->errorArray[] = Constants::$emailDontMatch;
            return;
        }

        if (!filter_var($em, FILTER_VALIDATE_EMAIL)) {
            $this->errorArray[] = Constants::$emailInvalid;
            return;
        }

        $sql = "SELECT * FROM nf_user WHERE email = :em";
        $statement = $this->conn->prepare($sql);
        $statement->bindParam(':em', $em, PDO::PARAM_STR);
        $statement->execute();

        if ($statement->rowCount() != 0) {
            $this->errorArray[] = Constants::$emailTaken;
        }
    }

    private function validatePassword(string $pw, string $pw2): void
    {
        if ($pw != $pw2) {
            $this->errorArray[] = Constants::$passwordDontMatch;
            return;
        }

        if (strlen($pw) < 5 || strlen($pw) > 25) {
            $this->errorArray[] = Constants::$passwordCharacters;
            return;
        }
    }

    public function getError(string $error): bool|string
    {
        if (in_array($error, $this->errorArray)) {
            return '<span class="errorMessage">' .$error. '</span>';
        }
        return false;
    }

    public function getUserValue(string $input): void
    {
        if (isset($_POST[$input])) {
            echo $_POST[$input];
        }
    }
}