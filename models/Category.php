<?php

class Category
{
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Category Properties
    public $id;
    public $name;
    public $created_at;

    // Constructor with DB


    public function __construct($db) {
        $this->conn = $db;
    }

    // Test Get
    public function test(){
        $query = 'SELECT * FROM categories';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Posts
    public function read() {
        // Create query
        $query = 'SELECT 
                    c.id, 
                    c.name, 
                    c.created_at
                  FROM 
                      ' . $this->table . ' c
                  ORDER BY
                      c.created_at DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }


    // Get Single Post
    public function read_single() {
        // Create query
        $query = 'SELECT 
                    c.name,
                    c.id,
                    c.created_at
                  FROM ' . $this->table . ' c
                  WHERE
                      c.id = ?
                  LIMIT 0,1';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }


    // Create Post
    public function create() {
        // Create query - into and space !
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET 
                    name = :name, 
                    created_at = :created_at';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':created_at', $this->created_at);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }


    // Update Post
    public function update() {
        // Create query - space after UPDATE
        $query = 'UPDATE ' . $this->table . '
                  SET 
                    name = :name,
                    created_at = :created_at,
                   WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->created_at = htmlspecialchars(strip_tags($this->created_at));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }


    // Delete Post
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' 
                  WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

}