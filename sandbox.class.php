<?php 
class sandbox
{
    private $name = null;

    public function __construct($name = null)
    {
        $this->name = $name;
    }
    
    public function get_name()
    {
        return $this->name;
    }

    public function set_name($name = null)
    {
        $this->name = $name;
    }

    public function set_country_list()
    {
        return [];
    }
}