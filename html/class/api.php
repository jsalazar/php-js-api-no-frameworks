<?php
class API {

    // DB Connection
    private $conn;

    // private $columns = array();
    private $configz = array();

    public function __construct($connection, $configuration) {

        $this->conn = $connection;
        // pass config into private property
        $this->configz = $configuration;

        // dynamically create some private properties
        /* foreach ($configuration['columns'] as $prop) {
            $this->columns[$prop] = '';
        } */

    }


    // CREATE
    private function create($data) {
        
        $setColumns = "";
        foreach ($this->configz['createColumns'] as $prop => $value) {
            $setColumns .= "$prop = :$prop, ";
        }
        $setColumns = trim($setColumns, ", ");

        $statement = "INSERT INTO {$this->configz['table']} SET $setColumns";
    
        $query = $this->conn->prepare($statement);
    
        // sanitize
        foreach ($this->configz['createColumns'] as $prop => $value) {
            // equivalent to: $query->bindParam(":name", $this->name);
            $query->bindParam(":$prop", htmlspecialchars(strip_tags($data->$prop)));
        }
        
        // execute() returns true on success and false on fail
        if ($query->execute()) {
            echo json_encode("Record created successfully.");
        }
        else {
            echo json_encode("Record NOT created.");
        }

    }


    // READ 
    private function read($data) {

        // translate all cols into a string: name, email, etc
        $readColumns = implode(", ", array_keys($this->configz['readColumns']));
        
        // dynamically create query statement
        $statement = "SELECT {$readColumns} FROM {$this->configz['table']} WHERE {$this->configz['primaryColumn']} = :id LIMIT 0,1";

        $query = $this->conn->prepare($statement);
        $query->bindValue(":id", htmlspecialchars(strip_tags($data->id)), PDO::PARAM_INT);
        $query->execute();
        $dataRow = $query->fetch(PDO::FETCH_ASSOC);

        if ($dataRow) {
            // if a record exists for ID provided, dynamically prep JSON output
            foreach ($this->configz['readColumns'] as $prop => $val) {
                // equivalent to: $this->name = $dataRow['name'];
                $this->configz['readColumns'][$prop] = $dataRow[$prop];
            }

            echo json_encode($this->configz['readColumns']);
        }
        else {
            echo json_encode("Employee not found.");
        }
        
    }        


    // UPDATE
    private function update($data) {

        $setColumns = "";
        foreach ($this->configz['updateColumns'] as $prop => $value) {
            $setColumns .= "$prop = :$prop, ";
        }
        $setColumns = trim($setColumns, ", ");
        
        $statement = "UPDATE {$this->configz['table']} SET $setColumns WHERE {$this->configz['primaryColumn']} = :id";
    
        $query = $this->conn->prepare($statement);

        foreach ($this->configz['updateColumns'] as $prop => $value) {
            // equivalent to: $query->bindParam(":name", $this->name);
            $query->bindParam(":$prop", htmlspecialchars(strip_tags($data->$prop)));
        }
        
        // execute() returns true on success and false on fail
        if ($query->execute()) {
            echo json_encode("Record updated successfully.");
        }
        else {
            echo json_encode("Record NOT update.");
        }

    }

    
    // DELETE
    private function delete($data) {

        $statement = "DELETE FROM {$this->configz['table']} WHERE {$this->configz['primaryColumn']} = :id";
        $query = $this->conn->prepare($statement);
        $query->bindValue(":id", htmlspecialchars(strip_tags($data->id)), PDO::PARAM_INT);
    
        // execute() returns true on success and false on fail
        if ($query->execute()) {
            echo json_encode("Record deleted successfully.");
        }
        else {
            echo json_encode("Record NOT deleted.");
        }

    }


    public function router($request) {

        $apiRequest = $request;

        // Remove spaces and slashes at the beginning/end of a string
        $apiRequest = trim($apiRequest, " /");
        $APIPath = explode("/", $apiRequest);

        // NEED TO SET DEFAULTS OR PROVIDE ERROR MESSAGE
        $apiCall = ($APIPath[1] != "") ? $APIPath[1] : "NOTFOUND";
        // $apiCallRecord = ($APIPath[2] != "") ? $APIPath[2] : "null"; 

        // attempt to sanitize the post body
        $data = json_decode(file_get_contents("php://filter/read=string.strip_tags/resource=php://input"));
        // $data = json_decode(file_get_contents("php://input"));

        // DETERMINE REQUEST TYPE
        switch ($apiCall) {
            
            case "create":
                    $this->create($data);
                break;

            case "read":
                    $this->read($data);
                break;

            case "update":
                    $this->update($data);
                break;

            case "delete":
                    $this->delete($data);
                break;

            default: 
                echo json_encode("API not found.");
                break;
        }

    }

}
?>