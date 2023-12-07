<?php



class Database_Queries
{

    public $connection; //Connection Object

    public $query; //Query String

    public $query_count = 0; //Query Count

    public $error;

    //Default Constructor 

    public function __consrtuct()
    {
    }

    //Database Connection

    public function Connect()
    {
        $this->connection = new mysqli("localhost", "root", "", "websocket");
    }


    // Escape string for safe database use
    public function real_escape_string($string)
    {
        $this->Connect();
        return $this->connection->real_escape_string($string);
    }



    //Query Handling

    public function Query($query)
    {

        $this->Connect();

        //Execute query
        if ($this->connection->query($query)) {
            return true; //Returns TRUE on successful execution
        } else {
            return false; //Returns FALSE on unsuccessful execution
        }
    }
    //Retrive Data
    public function RetriveSingle($query)
    {

        $this->Connect();

        //Executing query
        $res = $this->connection->query($query);

        //Fetching data
        $data = $res->fetch_assoc();

        //Return data
        return $data;
    }
    //Retrive Array
    public function RetriveArray($query)
    {

        $this->Connect();

        //Executing query
        $res = $this->connection->query($query);

        //Response
        $response = array();

        //Fetching data
        while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
            // while($data=$res->fetch_all(MYSQLI_ASSOC)){
            array_push($response, $data);
        }

        //Return data
        return $response;
    }
    //Count Rows
    public function CountRows($query)
    {
        $this->Connect();
        //Executing query
        $res = $this->connection->query($query);
        //Fetching data
        $data = $res->num_rows;
        //Return data
        return $data;
    }
    //Count Rows
    public function CheckUnique($value, $column, $table)
    {
        $this->Connect();
        //query
        $query = "SELECT * FROM `" . $table . "` WHERE `" . $column . "`='" . $value . "' ";
        //Executing query
        $res = $this->connection->query($query);
        //Fetching data
        if (!$res->num_rows) {
            return true;
        } else {
            return false;
        }
    }
}



?>