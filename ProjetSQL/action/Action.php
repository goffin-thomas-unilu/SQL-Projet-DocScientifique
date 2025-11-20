<?php
declare(strict_types=1);
// on met la classe abstraite Action dans le namespace sql\action afin de permettre une meilleur
//  gestion des différentes classes actions grâce à l'autoloader
namespace sql\action;

abstract class Action {

    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;
   
    public function __construct(){
        
        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }
    
    abstract public function execute();
    
}