<?php
/*
Logic:

The controller class is the interface between gui and business logic.
It is separated in different layers:
    
    0       GUI (e.g. HTML formular)
    1       Controller                  Raw data as user input to objects or objects to raw data for GUI
    2       Handler                     Performs data manipulating and business logic, builds database querys and receives database results
    3       DatabaseConnection          Interacts with the database        

from the gui the controller is called - the controller takes / gets the data and calls the handler.
The handler is implemented for entities, like a handler for entity user - it contains all functionality which are neccesary for the object
which are in relation to the user object. That means also database entitys like country or user permission set.
The handler calles from the database connection functions to execute sql querys.
*/

//Including all handler, entities, ...
include 'Interfaces/iEntity.php';
include 'Interfaces/iHandler.php';

include 'Databaseconnection/dbconnection.php';

include 'Databaseconnection/Entities/entity-example.php';

include 'Handler/handler-example.php';

class Controller{
    //defining instance variables
    //Handler:
    public $handlerExample;

    //Debug var for try-catch
    public $debug;

    function __construct(DatabaseConnection $dbconnection){
        $this->debug = true;
        $this->handlerExample = new Handler_Example($dbconnection->connect(), $this->$debug);
        
        /*
            here come the code to initialize website start, e.g. logging in - storring user in session 
        */
    }

    function getExampleById($eID){
        $this->handlerExample->getElementById(array(
            'entity' => 'example',  //db table name
            'id' => $eID,           //Primary Key id in db
            'type' => new Example() //Output class
        ));
    }
}
?>