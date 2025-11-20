<?php
namespace sql\action;

// La classe RepositorySQL permet d'établir la connexion avec la base de donnée
// De plus chaque méthode de l'objet RepositorySQL répond à une des fonctionnalitées demandées 
class RepositorySQL {

    // l'attribut pdo établit la connexion et est utilisé dans chaque méthode pour exécuter des requêtes SQL
    public \PDO $pdo;
    
    // la méthode constructeur établit la connexion avec la base de donnée 
    public function __construct() {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=projetsql_docscientifique','root','');
    }
    
    // méthode permettant d'obtenir la liste des articles d'un chercheur donné en paramètre
    public function ArticleAuteur(String $nomC) { 
        //var_dump($nomC);
        
        // Requête SQL pour afficher le numero de l'article, son titre ainsi que son résumé grâce à une jointure 
        // entre les tables ARTICLE,ECRIRE et CHERCHEUR à la condition que le nom du cherheur soit présent dans la base de donnée
        $sql = "
                SELECT a.NUMART, a.TITRE, a.RESUME
                FROM ARTICLE a
                JOIN ECRIRE e ON a.NumArt = e.NUMART
                JOIN chercheur c ON e.NumCher = c.NumCher
                WHERE c.NOMCHERCHEUR = '$nomC'
                ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // la variable $articles permet de stocker toutes les lignes de la requête $sql exécuté
        $articles = $stmt->fetchAll();
        // on vérifie si la variable $articles est vide ou non, si elle est l'est cela veut dire que soit le chercheur n'existe pas ou que celui-ci n'a pas encore écrit d'article
        if (empty($articles)){
            echo "<p style='color: #E4080A';>Le chercheur renseigné n'est pas présent dans la base de donnée ou n'a pas encore écrit d'article</p>";
        }
        // si la variable $articles n'est pas vide, cela veut dire que le chercheur a au moins écrit un article
        else {
            echo "<h3 style='color:#2BC508';>Articles du Chercheur $nomC : </h3>";
            // var_dump() permet de voir le contenu brut de la variable passé en paramètre
            //var_dump($articles);

            // la boucle while permet de parcourir la variable $articles étant un tableau contenant des tableaux grâce à leur index
            $index = 0;
            while ($index < count($articles)) {
                // $article est un tableau contenant les infos d'un seul article
                $article = $articles[$index];
                // on affiche les infos telle que NUMART, TITRE ou encore RESUME
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Numéro de l'article</b> : {$article['NUMART']} <br> <strong>Titre</strong> : <em>{$article['TITRE']}</em> <br> <b>Résumé de l'article</b> : <br><span>{$article['RESUME']}</span> </p>";
                // on ncrément la l'index pour passer à l'article suivant 
                $index++;
            }

        }

    }

    // méthode permettant d'afficher la liste des co-auteurs ayant travaillé avec un chercheur donné en paramètre
    public function CoAuteur(String $chercheur) { 

        //var_dump($nomC);
        
        // Requête SQL pour afficher le nom de chaque chercheur ayant co-écrit avec le chercheur donné, grâce à une jointure 
        // entre les tables ECRIRE et CHERCHEUR à la condition que le nom du cherheur soit présent dans la base de donnée 
        // et que le numéro du premier chercheur soit différent du second afin d'éviter de choisir le chercheur donné 
        
        $sql1 =" 
                SELECT DISTINCT c2.NOMCHERCHEUR
                FROM CHERCHEUR c1
                JOIN ECRIRE e1 ON c1.NUMCHER = e1.NUMCHER
                JOIN ECRIRE e2 ON e1.NUMART = e2.NUMART
                JOIN CHERCHEUR c2 ON e2.NUMCHER = c2.NUMCHER
                WHERE c1.NOMCHERCHEUR = '$chercheur' AND c2.NUMCHER != c1.NUMCHER
                ";
        

        $stmt = $this->pdo->prepare($sql1);
        $stmt->execute();

        // la variable $chercheursL permet de stocker toutes les lignes de la requête $sql1 exécuté
        $chercheursL = $stmt->fetchAll();
        //var_dump($chercheursL);

        // on vérifie si la variable $chercheursL est vide ou non, si elle est l'est cela veut dire que soit le chercheur n'existe pas ou que celui-ci n'a pas écrit d'article avec d'autres personnes 
        if (empty($chercheursL)){
            echo "<p style='color: #E4080A';>Le chercheur renseigné ne présente aucun article sur lesquels il a travaillé avec d'autres chercheurs ou alors celui-ci n'est pas inscrit dans la base de donnée</p>";
        }
        // si la variable $chercheursL n'est pas vide, cela veut dire que le chercheur a au moins travaillé avec une personne considéré co-autrice
        else {
            echo "<h3 style='color:#2BC508';>Co-auteurs du Chercheur $chercheur : </h3>";
            
            //var_dump($chercheursL);

            // la boucle while permet de parcourir la variable $chercheursL étant un tableau contenant la liste des co-auteurs du chercheur donné
            $index = 0;
            while ($index < count($chercheursL)) {
                // $chercheurIndex est un tableau contenant la liste des co-auteurs
                $chercheurIndex = $chercheursL[$index];
                // on affiche les NOMCHERCHEUR
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Nom du chercheur</b> : {$chercheurIndex['NOMCHERCHEUR']} <br> </p>";
                // on incrémente l'index pour passer à l'indice suivant 
                $index++;
            }

        }

    }


    // méthode permettant d'afficher la liste de chaque chercheur avec leurs laboratoires attribués
    public function ListLaboCher() { 

        // requête sql renvoyant le nom du chercheur associé à sa liste de laboratoire où il y travaille
        $sql ="
                SELECT c.NOMCHERCHEUR, l.NOMLABO
                FROM CHERCHEUR c
                LEFT JOIN TRAVAILLER t ON c.NUMCHER = t.NUMCHER
                LEFT JOIN LABORATOIRE l ON t.NUMLABO = l.NUMLABO
                ORDER BY c.NOMCHERCHEUR, l.NOMLABO;
            ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // la variable $listeLabo permet de stocker toutes les lignes de la requête $sql exécuté
        $listeLabo = $stmt->fetchAll();
        //var_dump($listeLabo);

        $index = 0;
        while ($index < count($listeLabo)) {
                // $chercheurIndex est un tableau contenant les infos d'un seul post(la où un chercheur a un labo)
                $chercheurIndex = $listeLabo[$index];
                // on affiche les infos telle que NOMCHERCHEUR et NOMLABO
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Nom du chercheur</b> : {$chercheurIndex['NOMCHERCHEUR']} <br> <b> Nom du Laboratoire </b>: {$chercheurIndex['NOMLABO']} </p>";
                // on incrémente la l'index pour passer à l'indice suivant 
                $index++;
            }
        

    }

    // méthode permettant d'afficher la liste des chercheurs ayant annoté au moins un nombre donné d’articles en paramètre. 
    public function ListCherAnnoterMin(int $n) {
        // requête sql renvoyant les chercheurs ayant annoté au moins un nombre donné d'articles 
        $sql ="
                SELECT c.NOMCHERCHEUR
                FROM CHERCHEUR c
                JOIN ANNOTER a ON c.NUMCHER = a.NUMCHER
                GROUP BY c.NUMCHER, c.NOMCHERCHEUR
                HAVING COUNT(DISTINCT a.NUMART) >= $n
                ORDER BY c.NOMCHERCHEUR;
            ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
            
        // la variable $listeCherMin permet de stocker toutes les lignes de la requête $sql exécuté
        $listeCherMin = $stmt->fetchAll();

        // var_dump() permet de voir le contenu brut de la variable passé en paramètre
        //var_dump($listeCherMin);

        // test si la variable est vide ou non
        if (empty($listeCherMin)){
            echo "<p style='color: #E4080A';>Aucun chercheur n'a annoté ce nombre d'article</p>";
        }
        // si la variable $listeCherMin n'est pas vide, cela veut dire que le chercheur a au moins annoté n articles
        else {
            echo "<h3 style='color:#2BC508';>Liste de chercheur ayant annoté au moins $n  articles : </h3>";
            
            // la boucle while permet de parcourir la variable $listeCherMin étant un tableau contenant des tableaux grâce à leur index
            $index = 0;
            while ($index < count($listeCherMin)) {
                // $chercheurIndex est un tableau contenant les infos d'un seul chercheur
                $chercheurIndex = $listeCherMin[$index];
                // on affiche l'info NOMCHERCHEUR
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Nom du chercheur</b> : {$chercheurIndex['NOMCHERCHEUR']} <br></p>";
                // on incrémente la l'index pour passer à l'indice suivant 
                $index++;
            }

        }
    }

    // méthode permettant d'afficher la liste de chaque chercheur avec leurs laboratoires attribués
    public function MoyNoteCher(string $nomChercheur) { 

        // requête sql renvoyant le nom du chercheur associé à sa liste de laboratoire où il y travaille
        $sql ="
                SELECT c.NOMCHERCHEUR, AVG(n.NOTE) AS moyenne_notes
                FROM CHERCHEUR c
                JOIN NOTER n ON c.NUMCHER = n.NUMCHER
                WHERE c.NOMCHERCHEUR = '$nomChercheur'
                GROUP BY c.NUMCHER, c.NOMCHERCHEUR;
            ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // la variable $MoyNote permet de stocker toutes les lignes de la requête $sql exécuté
        $MoyNote = $stmt->fetchAll();

        // var_dump() permet de voir le contenu brut de la variable passé en paramètre
        //var_dump($MoyNote);

        // test si la variable est vide ou non
        if (empty($MoyNote)){
            echo "<p style='color: #E4080A';>Le chercheur n'est pas présent dans la base de donné ou alors celui-ci n'a noté aucun article</p>";
        }
        // si la variable $MoyNote n'est pas vide, cela veut dire que le chercheur a noté au moins 1 article
        else {
            echo "<h3 style='color:#2BC508';>La moyenne du chercheur $nomChercheur : </h3>";
            
            // la boucle while permet de parcourir la variable $MoyNote étant un tableau contenant des tableaux grâce à leur index
            $index = 0;
            while ($index < count($MoyNote)) {
                // $chercheurIndex est un tableau contenant les infos d'un seul chercheur avec sa moyenne de note
                $chercheurIndex = $MoyNote[$index];
                // on affiche l'info NOMCHERCHEUR
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Nom du chercheur</b> : {$chercheurIndex['NOMCHERCHEUR']} <br><b>Moyenne des notes</b> : {$chercheurIndex['moyenne_notes']} </p>";
                // on incrémente la l'index pour passer à l'indice suivant 
                $index++;
            }

        }

    }

    // méthode permettant d'afficher pour chaque chercheur d’un laboratoire donné(déterminé par son sigle), afficher le nombre d’articles 
    // publiés, le nombre et la moyenne des notes obtenues , de plus ordonné de façon décroissant par rapport aux nombre d'articles.
    public function Stat_labo(string $sigleLabo) { 

        // requête sql renvoyant les statistiques (NOMCHERCHEUR,nombre d'articles, nombre de notes, moyenne) 
        // de chaque chercheur travaillant dans le laboratoire donné en paramètre
        $sql ="
                SELECT 
                    c.NOMCHERCHEUR,
                    COUNT(DISTINCT e.NUMART) AS articles,
                    COUNT(n.NOTE) AS notes,
                    COALESCE(AVG(n.NOTE), 0) AS moyenne
                FROM CHERCHEUR c
                JOIN TRAVAILLER t ON c.NUMCHER = t.NUMCHER
                LEFT JOIN ECRIRE e ON c.NUMCHER = e.NUMCHER
                LEFT JOIN NOTER n ON c.NUMCHER = n.NUMCHER
                WHERE t.NUMLABO IN (SELECT NUMLABO FROM LABORATOIRE WHERE SIGLELABO = '$sigleLabo')
                GROUP BY c.NUMCHER, c.NOMCHERCHEUR
                ORDER BY articles DESC;
            ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // la variable $StatLabo permet de stocker toutes les lignes de la requête $sql exécuté
        $StatLabo = $stmt->fetchAll();

        // var_dump() permet de voir le contenu brut de la variable passé en paramètre
        //var_dump($StatLabo);

        // test si la variable est vide ou non
        if (empty($StatLabo)){
            echo "<p style='color: #E4080A';>Le laboratoire n'est pas présent dans la base de donnée ou aucun chercheur n'y travaille</p>";
        }
        // si la variable $StatLabo n'est pas vide, cela veut dire que au moins un chercheur travaille dans le laboratoire donné 
        else {
            echo "<h3 style='color:#2BC508';>Statistique du laboratoire avec pour sigle $sigleLabo : </h3>";
            
            // la boucle while permet de parcourir la variable $StatLabo étant un tableau contenant des tableaux grâce à leur index
            $index = 0;
            while ($index < count($StatLabo)) {
                // $chercheurIndex est un tableau contenant les infos d'un seul chercheur avec sa moyenne de note
                $chercheurIndex = $StatLabo[$index];
                // on affiche l'info NOMCHERCHEUR, articles, notes et moyenne
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> <b>Nom du chercheur</b> : {$chercheurIndex['NOMCHERCHEUR']} <br> <b>Nombre d'articles réalisés</b> : {$chercheurIndex['articles']} <br> <b>Nombre de notes</b> : {$chercheurIndex['notes']} <br> <b>Moyenne des notes</b> : {$chercheurIndex['moyenne']} </p>";
                // on incrémente la l'index pour passer à l'indice suivant 
                $index++;
            }

        }

    }

    // méthode permettant de vérifier que la note maximale d’un article donné en paramètre n’a pas été attribuée par 
    // un chercheur appartenant au même laboratoire que l’un des auteurs de cet article.
    public function VerifNote(int $numArt) { 


        // requête permettant de compter le nombre total d'article et insérer le résultat dans nombre_total_articles 
        $sqlTotal = "
                        SELECT COUNT(*) AS nombre_total_articles
                        FROM ARTICLE;
                    ";

        $stmt1 = $this->pdo->prepare($sqlTotal);
        $stmt1->execute();

        // la variable $VerifTotal permet de stocker resultat de la requête sqltotal
        $VerifTotal = $stmt1->fetchAll();
        //var_dump($VerifTotal);
        //echo "{$VerifTotal[0]['nombre_total_articles']}";
        
        // on vérifie ensuite que le numéro renseigné par l'utilisateur est bien compris entre 1 et le total de nombre d'article présent dans la base de donnée
        if ( $numArt<=$VerifTotal[0]['nombre_total_articles'] && $numArt>=1){

            // requête sql renvoyant si il y a un conflit ou non en donnant le numéro de l'article pour vérifier si la note maximale
            // ne provient pas d'un chercheur du même laboratoire que l'auteur
            // ce résultat est stocké dans resultat
            $sql ="
                SELECT 
                    IF(
                        EXISTS (
                            SELECT 1
                            FROM NOTER n
                            JOIN TRAVAILLER t1 ON n.NUMCHER = t1.NUMCHER
                            JOIN ECRIRE e ON e.NUMART = n.NUMART
                            JOIN TRAVAILLER t2 ON e.NUMCHER = t2.NUMCHER
                            WHERE n.NUMART = $numArt
                            AND n.NOTE = (SELECT MAX(NOTE) FROM NOTER WHERE NUMART = $numArt)
                            AND t1.NUMLABO = t2.NUMLABO
                        ),
                        'Conflit : La note maximale est donnée par un chercheur du meme laboratoire.',
                        'Aucun conflit : La note maximale n''est pas donnée par un chercheur du meme laboratoire.'
                    ) AS resultat
                ;
            ";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            // la variable $Verif permet de stocker resultat de la requête sql
            $Verif = $stmt->fetchAll();

            // var_dump() permet de voir le contenu brut de la variable passé en paramètre
            //var_dump($Verif);

            // cette condition sert à déterminer si la phrase de résultat contient 'Aucun' si cela est vrai alors on affiche le résultat
            // en bleu sinon en rouge
            if (str_contains($Verif[0]['resultat'],'Aucun')){
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #007BFF; color: white; margin: 10px; max-width: 600px;'> {$Verif[0]['resultat']} </p>";
            }
            else{
                echo "<p style='padding: 20px; border-radius: 10px; background-color: #E4080A; color: white; margin: 10px; max-width: 600px;'> {$Verif[0]['resultat']} </p>";
            }
        }
        // s'affiche si l'utilisateur a renseigné un numéro d'article non présent dans la base de donnée (exemple: <=0 ou >nombre total d'article)
        else { 
            echo "<p style='color:#E4080A;'>Le numéro de l'article donné n'est pas présent dans la base de donnée</p>";
        }
        
    }
}