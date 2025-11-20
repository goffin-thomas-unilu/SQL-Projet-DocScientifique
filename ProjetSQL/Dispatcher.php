<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';
// on importe le namespace sq\action en le mettant en alias avec A 
use sql\action as A;


// la classe Dispatcher permet de gérer quelle action a été choisi par l'utilisateur et ainsi créer la classe 
// correspondante réalisant la requête souhaitée
class Dispatcher {
    private string $action;

	public function __construct () {
		$this->action = $_GET["action"];
	}

    public function run(){
        if (isset($this->action)) {
            switch ($this->action) {
                case "ArtAuteur":
                    print("<em>Article d'un auteur ---</em> <br> <br>");
                    $obj = new A\ArtAuteurAction();
                    $obj->execute();
                    break;

                case 'CoAuteur':
                    echo "Affichage des co auteurs";
                    $obj = new A\CoAuteurAction();
                    $obj->execute();
                    break;
                    
                case 'ListLaboCher':
                    $obj = new A\ListLaboCherAction();
                    $obj->execute();
                    break;
                
                case 'ListCherAnnoterMin':
                    $obj = new A\ListCherAnnoterMinAction();
                    $obj->execute();
                    break;

                case 'Moy_Note_Cher':
                    $obj = new A\Moy_Note_CherAction();
                    $obj->execute();
                    break;

                case 'Stat_Chercheur':
                    $obj = new A\Stat_ChercheurAction();
                    $obj->execute();
                    break;

                case 'Verif_NoteMax_Labo':
                    $obj = new A\Verif_NoteMax_LaboAction();
                    $obj->execute();
                    break;

                default:
                    $obj = new A\DefaultAction();
                    $obj->execute();
                    break;
                }
        }
    }
}