<?php
declare(strict_types=1);
namespace sql\action;
class Verif_NoteMax_LaboAction extends Action {
    public function execute() {
        print("<p style='color: #228CFD';>Donnez le numéro d'un article afin de voir si la note maximale a été attribué par un chercheur appartenant au même laboratoire ↓</p>");

        // on vérifie qu'une variable d'url existe
        if ($this->http_method === 'GET'){

            echo <<<FIN
                <!doctype html>
                <html lang='fr'>
                <head>
                    <title> Verif SQL</title>
                </head>

                <body>
                    <form method="POST" id="form1" action="?action=Verif_NoteMax_Labo">
                        <input type="number"
                            name="Num_article"
                            placeholder="Numero article">
                        <button type="submit" > Envoyer </button>
                        
                FIN;
        print("<br>");
        }
        else {
            // on récupère la variable POST
            $numA =$_POST[ 'Num_article' ] ; 
            // on instancie un objet RepositorySQL
            $rep = new RepositorySQL();
            // on appelle la méthode adéquate en fonction de l'action actuelle
            // intval() convertit la variable passé en paramètre en int car numA est un string avant cela
            $rep->VerifNote(intval($numA));
        
        }
    }
}