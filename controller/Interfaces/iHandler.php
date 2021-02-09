<?php
interface iHandler
{
    public function getElementById($template);
    public function getElementCollectionById($template);
    //extendable with further generic functionality
}
?>