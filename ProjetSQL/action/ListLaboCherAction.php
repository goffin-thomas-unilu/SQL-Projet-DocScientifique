<?php
declare(strict_types=1);
namespace sql\action;
class ListLaboCherAction extends Action {
    public function execute() {
        print("Liste des laboratoires pour chaque chercheur <br>");
        
        print("<p style='color: #228CFD';>Voici la liste des laboratoires de chaque Chercheur ↓</p>");

        // instanciation d'un objet RepositorySQL
        $rep = new RepositorySQL();
        // appel de la méthode ListLaboCher
        $rep->ListLaboCher();


 }
}