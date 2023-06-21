<?php
class Database {

    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'dbblog';
    private $connection;

    public function createdb(){
        //chek connection
        try {
            $this->connection = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();die;
        }
        //create database
        try{
            $sql = "CREATE DATABASE dbblog";
            $this->connection->exec($sql);
            echo "Database created successfully";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    }
    public function createtbl(){
        //chek connection
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();die;
        }

        //create user table
        try{
            $sql = "CREATE TABLE usertbl(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                fullname TEXT(30) NOT NULL,
                ncode BIGINT(30) NOT NULL UNIQUE,
                phone BIGINT(70) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                is_active BOOLEAN NOT NULL,
                registerTime TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

        //create posts table
        try{
            $sql = "CREATE TABLE posts(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `title` VARCHAR(100) NOT NULL,
                `desc` TEXT NOT NULL ,
                `user_id` INT NOT NULL ,
                `image` INT NOT NULL ,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES usertbl(id)
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

        //create score table
        try{
            $sql = "CREATE TABLE score(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `post_id` INT NOT NULL ,
                `user_id` INT NOT NULL ,
                `score` INT(10) NOT NULL ,
                FOREIGN KEY (user_id) REFERENCES usertbl(id),
                FOREIGN KEY (post_id) REFERENCES posts(id)
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

        //create comment table
        try{
            $sql = "CREATE TABLE comment(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `post_id` INT NOT NULL ,
                `user_id` INT NOT NULL ,
                `comment` TEXT NOT NULL ,
                FOREIGN KEY (user_id) REFERENCES usertbl(id),
                FOREIGN KEY (post_id) REFERENCES posts(id)
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

        //create tags table
        try{
            $sql = "CREATE TABLE tags(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `post_id` INT NOT NULL ,
                `tag_name` VARCHAR(100) NOT NULL,
                FOREIGN KEY (post_id) REFERENCES posts(id)
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

         //create categories table
         try{
            $sql = "CREATE TABLE categories(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `parent_id` INT NOT NULL DEFAULT '0' ,
                `title` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP 
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }

         //create category post table
         try{
            $sql = "CREATE TABLE category_post(
                id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
                `category_id` INT NOT NULL ,
                `post_id` INT NOT NULL ,
                FOREIGN KEY (category_id) REFERENCES categories(id),
                FOREIGN KEY (post_id) REFERENCES posts(id)
            )";    
            $this->connection->exec($sql);
            echo "Table created successfully.";
        } catch(PDOException $e){
            die("ERROR: Could not able to execute $sql. " . $e->getMessage());
        }
    }
}

?>
