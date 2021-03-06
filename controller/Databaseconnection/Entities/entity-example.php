<?php
class Entity_Example extends iEntity{
    //contains all columns from the database entity 
    public $properties = array(
        "id" => "0",
        "name" => "example",
        "size" => "0"
    );
    function __construct($attributes = array()){
        //even if called uncomplete it merges every single data to the property array
       if(count($attributes) > 0){
          
           $this->properties = array_merge($this->properties,$attributes);
       }
   }
   function getPropertySet(){
       return $this->properties;
   }
   function setPropertySet($AttributeSet){
       $this->properties = $AttributeSet;
   }
   function getProperty($index){
       return $this->properties[$index];
   }
   function setProperty($index, $value){
       $this->properties[$index] = $value;
   }
}
?>