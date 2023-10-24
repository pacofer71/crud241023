<?php

namespace App\Db;

use App\Utils\{Perfil, Provincias};
use \PDO;
use \PDOException;

class Usuario extends Conexion
{
    private int $id;
    private string $nombre;
    private string $apellidos;
    private string $email;
    private string $provincia;
    private Perfil $perfil;

    public function __construct()
    {
        parent::__construct();
    }

    //----------------------- CRUD -----------------------------------------------------------------------------
    public  function create()
    {
        $q = "insert into usuarios(nombre, apellidos, email, provincia, perfil) values(:n, :a, :e, :p, :perfil)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia,
                ':perfil' => $this->perfil->name
            ]);
        } catch (PDOException $ex) {
            die("Error al insertar datos: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    public static function read(): array
    {
        parent::setConexion();
        $q = "select * from usuarios order by id desc";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver valores: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function update($id)
    {
        $q = "update usuarios set nombre=:n, apellidos=:a, provincia=:p, perfil=:perfil, email=:e where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':a' => $this->apellidos,
                ':e' => $this->email,
                ':p' => $this->provincia,
                ':perfil' => $this->perfil->name,
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar datos: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    public function delete()
    {
        $q = "delete from usuarios where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':i' => $this->id]);
        } catch (PDOException $ex) {
            die("Error al borrar el usuario: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    public static function findUser($id)
    {
        parent::setConexion();
        $q = "select * from usuarios where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([':i' => $id]);
        } catch (PDOException $ex) {
            die("Error al borrar el usuario: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    //----------------------- OTROS METODOS ----------------------
    public static function datosPrueba(int $num)
    {
        if (self::hayValores()) return;

        $faker = \Faker\Factory::create('es_ES');
        for ($i = 0; $i < $num; $i++) {
            $nombre = $faker->firstName();
            $apellidos = $faker->lastName() . " " . $faker->lastName();
            $email = $faker->unique()->email();
            $provincia = $faker->randomElement(Provincias::$listadoProv);
            $perfil = $faker->randomElement([Perfil::Admin, Perfil::User]);
            (new Usuario)->setNombre($nombre)
                ->setApellidos($apellidos)
                ->setEmail($email)
                ->setPerfil($perfil)
                ->setProvincia($provincia)
                ->create();
        }
    }

    private static function hayValores(): bool
    {
        parent::setConexion();
        $q = "select id from usuarios";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay valores: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public static function existeEmail(string $email, ?int $id = null): bool
    {
        parent::setConexion();
        $q = ($id == null) ? "select id from usuarios where email=:e" : "select id from usuarios where email=:e AND id !=:i";       
        $op = ($id == null) ? [':e' => $email] : [':e' => $email, ':i' => $id];
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute($op);
        } catch (PDOException $ex) {
            die("Error al comprobar email: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount(); //0
    }

    //_______________________ setters ____________________________

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of provincia
     *
     * @return  self
     */
    public function setProvincia(string $provincia): self
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Set the value of perfil
     *
     * @return  self
     */
    public function setPerfil(Perfil $perfil): self
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * Set the value of apellidos
     *
     * @return  self
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }
}
