<?php
class Handler_Example implements iHandler{
    public $dbc;
    public $debug;
    function __construct($dbconnection, $dbg){
        $this->dbc = $dbconnection;
        $this->debug = $dbg;
    }
    //Implement interface
     /*template design
        what and range
        array
            entity => table name
            id => 0
            type => new Entity
    */
    function getElementById($template){
        try{
            $output = "no object";
            
            //prepare and bind parameter
            $query = $this->dbc->prepare(str_replace('{entity}',$template['entity'],'SELECT * FROM {entity} WHERE id = :id'));
            $query->bindParam(':id', $template['id'], PDO::PARAM_INT);
            //execute statement
            $query->execute();
            $rawOutput = $query->fetchAll();
            //declare target
            $class = new ReflectionClass(get_class($template['type']));
            //get data from query result
            foreach($rawOutput as $row){
                foreach($row as $attribute => $attrValue){
                    //Filter additional numeric indices
                    if(is_numeric($attribute)){
                        unset($row[$attribute]);   
                    }
                }
                $args = array();
                array_push($args, $row);
                //NewInstance expects an array of args
                $output =  $class->newInstanceArgs($args);
            }
        }catch(Exception $e){
            if($this->debug){
                echo $e;
            }
        }
        
        return $output;
    }
     /*template design
        what and range
        array(
            'entity' => 'table name'
            'start_id' => 5
            'end_id' => 10
            'type' => new Entity() e.g. new User()
            )
    */
    function getElementCollectionById($template){
        $output = array();
        try{
            
            //prepare sql statement
            $query = $this->dbc->prepare(str_replace(
                '{entity}',
                $template['entity'],
                'SELECT * FROM {entity} WHERE id >= :start_id and id <= :end_id'));
            //bind param
            $query->bindParam(':start_id', $template['start_id'], PDO::PARAM_INT);
            $query->bindParam(':end_id', $template['end_id'], PDO::PARAM_INT);
            $query->execute();
            $rawOutput = $query->fetchAll();
            $class = new ReflectionClass(get_class($template['type']));
            $Collection = array();
            //loop through restults
            foreach($rawOutput as $row){
                foreach($row as $attribute => $attrValue){
                    //Filter additional numeric array keys
                    if(is_numeric($attribute)){
                        unset($row[$attribute]);   
                    }
                }
                //Return object to collection
                $args = array();
                array_push($args, $row);
                //NewInstance expects an array of args - entity constructor accepts array with attributes
                array_push($Collection, $class->newInstanceArgs($args));
            }
            return $Collection;
        }catch(Exception $e){
            echo $e;
            if($this->debug){
                echo $e;
            }
        }
        return $output;
    }
}
?>