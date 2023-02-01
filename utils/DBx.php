<?php

// SERVER CONFIGURATION
class ServerConfig
{
    public $DBName   = 'tmsdb';
    public $Server   = 'localhost';
    public $UserName = 'root';
    public $Password = '';

    public function GetConnectionString()
    {
        return new PDO('mysql:host=' . $this->Server . ';dbname=' . $this->DBName, $this->UserName, $this->Password);
    }
}

// DB HELPER CLASS
class DBx
{
    public static function ExecuteCommand($query, array $param = null): bool
    {
        $config       = new ServerConfig();
        $DBConnection = $config->GetConnectionString();
        $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $BindParam = $DBConnection->prepare($query);
        if ($param != null) {
            if ($BindParam->execute($param)) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($BindParam->execute()) {
                return true;
            } else {
                return false;
            }
        }
        $DBConnection = null;
    }

    public static function GetData($query, array $param = null): array
    {
        $config       = new ServerConfig();
        $DBConnection = $config->GetConnectionString();
        $DBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $getData = $DBConnection->prepare($query);
        if ($param != null) {
            $getData->execute($param);
        } else { $getData->execute();
        }
        $data = $getData->fetchAll();
        return $data;
        $DBConnection = null;
    }

}

// class Student{

//     public static function Insert($fname, $lname, $bday){
//         $sql = "INSERT INTO student(fname, lname, bday) VALUES (?,?,?)";
//         DBx::ExecuteCommand($sql, [$fname, $lname, $bday]);
//     }
// }
