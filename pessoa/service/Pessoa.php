<?php

class Pessoa {

    private $id = null;
    private $nome = null;
    private $idade = null;

    public function setId(int $value) :void
    {
        $this->id = $value;
    }

    public function getId() :int
    {
        return $this->id;
    }

    public function setNome(string $value) :void
    {
        $this->nome = $value;
    }

    public function getNome() :string
    {
        return $this->nome;
    }

    public function setIdade(int $value) :void
    {
        $this->idade = $value;
    }

    public function getIdade() :int
    {
        return $this->idade;
    }

    private function connection() :\PDO
    {
        return new \PDO("mysql:host=localhost;dbname=sistemacrud", "root", "");
    }

    private function validate_id() :bool
    {
        $id = $this->getId();
        return is_int($id) && $id > 0;
    }

    private function validate_nome() :bool
    {
        $nome = $this->getNome();
        return is_string($nome) && strlen($nome) > 0 && strlen($nome) < 256;
    }

    private function validate_idade() :bool
    {
        $idade = $this->getIdade();
        return is_int($idade) && $idade >= 0;
    }

    public function create() :int
    {
        $con = $this->connection();
        $nome = $this->getNome();
        $idade = $this->getIdade();
        if ($con !== null && $this->validate_nome() && $this->validate_idade()) {
            $stmt = $con->prepare("INSERT INTO pessoa VALUES (NULL, :nome, :idade)");
            $stmt->bindValue(":nome", $nome, \PDO::PARAM_STR);
            $stmt->bindValue(":idade", $idade, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $con->lastInsertId();
            }
        }
        return 0;
    }

    public function update() :bool
    {
        $con = $this->connection();
        $id = $this->getId();
        $nome = $this->getNome();
        $idade = $this->getIdade();
        if ($con !== null && $this->validate_id() && $this->validate_nome() && $this->validate_idade()) {
            $stmt = $con->prepare("UPDATE pessoa SET nome = :nome, idade = :idade WHERE id = :id");
            $stmt->bindValue(":nome", $nome, \PDO::PARAM_STR);
            $stmt->bindValue(":idade", $idade, \PDO::PARAM_INT);
            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            return $stmt->execute();
        }
        return false;
    }

    public function show() :array
    {
        $con = $this->connection();
        $id = $this->getId();
        if ($con !== null) {
            if ($this->validate_id()) {
                $stmt = $con->prepare("SELECT * FROM pessoa WHERE id = :id");
                $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
                if ($stmt->execute() && $stmt->rowCount() == 1) {
                    return $stmt->fetch(\PDO::FETCH_ASSOC);
                }
            } else {
                $stmt = $con->prepare("SELECT * FROM pessoa");
                if ($stmt->execute() && $stmt->rowCount() > 0) {
                    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
                }
            }
        }
        return [];
    }

    public function delete() :bool
    {
        $con = $this->connection();
        $id = $this->getId();
        if ($con !== null && $this->validate_id()) {
            $stmt = $con->prepare("DELETE FROM pessoa WHERE id = :id");
            $stmt->bindValue(":id", $id, \PDO::PARAM_INT);
            return $stmt->execute();
        }
        return false;
    }

}