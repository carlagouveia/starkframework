<?php

namespace Stark\Framework\Database;

class Manager
{
    protected $db;

    public function __construct(Connection $connection)
    {
        $this->setConnection($connection);
    }

    public function setConnection(Connection $connection)
    {
        $this->db = $connection->getConnection();
    }

    public function getConnection()
    {
        return $this->db;
    }

    public function create($table, $fields)
    {
        foreach ($fields as $column => $field) {
            $columns[] = $column;
            $placeholders[] = ":$column";
        }

        $columns = implode(', ', $columns);
        $placeholders = implode(', ', $placeholders);

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $statement = $this->db->prepare($query);
        $statement->execute($fields);
    }

    public function update($table, $id, $fields)
    {
        foreach ($fields as $column => $field) {
            $set[] = "$column=:$column";
        }

        $set = implode(', ', $set);

        $query = "UPDATE $table SET $set WHERE id = :id";
        $fields['id'] = $id;
        $statement = $this->db->prepare($query);
        $statement->execute($fields);
    }

    public function delete($table, $id)
    {
        $query = "DELETE FROM $table WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function find($table, $id, $columns = '*')
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT $columns FROM $table WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    public function findAll($table, $columns = '*')
    {
        if (is_array($columns)) {
            $columns = implode(', ', $columns);
        }

        $query = "SELECT $columns FROM $table";

        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function exec($query)
    {
        $statement = $this->db->prepare($query);
        $statement->execute();
    }

    public function query($query, $vars = null)
    {
        $statement = $this->db->prepare($query);
        $statement->execute($vars);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function singleQuery($query, $vars = null)
    {
        $statement = $this->db->prepare($query);
        $statement->execute($vars);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
}