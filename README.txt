Fichier README.txt

Le dossier ProjetSQL contient :
	les scripts php dans le sous-dossier action 
	l'implémentation de l'autoloader (sous-dossier vendor, composer.json, composer.lock)
	le script php dispatcher
	l'index/main php 
	

Après la création des tables, des triggers, l'insertion des data.
Il y a une ligne déclenchant le trigger CO_Auteur_Trigger : INSERT INTO NOTER VALUES (5, 1, 4);

Les données dans la table log_chercheurs ont été réalisé avec succès même si à ce stade la table ne contient que des data avec pour action 'INSERT'.


Pour la 1er fonctionnalité, il faut renseigner le Nom du Chercheur afin d'obtenir la liste des articles qu'il a réalisé :

	si le chercheur renseigné ne figure pas dans la base de donnée, un message rouge s'affichera stipulant la non présence de celui-ci (exemple : Port)
	si le chercheur renseigné n'a réalisé aucun article, un message rouge s'affichera stipulant que le chercheur n'a réalisé aucun article pour le moment (ex: Port)

	si le chercheur renseigné figure dans la base de donnée, cela affichera le numéro de l'article, son titre ainsi que son résumé (ex: Cohen-Boulakia)


Pour la 2eme fonctionnalité, Il faut renseigner le Nom d'un chercheur afin d'obtenir la liste de ses co-auteur :

	si le chercheur renseigné ne figure pas dans la base de donnée, un message rouge s'affichera stipulant la non présence de celui-ci (ex: Port)
	si le chercheur renseigné n'a réalisé aucun article avec des co-auteurs, un message rouge s'affichera stipulant que le chercheur n'a réalisé aucun article en collaboration avec 	d'autres chercheurs (ex: Port)

	si le chercheur renseigné figure dans la base de donnée, cela affichera la liste de ses co-auteurs (ex: Davidson)


Pour la 3eme fonctionnalité, aucun renseignement est nécessaire :

	cela va afficher la liste de tous les chercheurs avec leurs laboratoires attribués


Pour la 4eme fonctionnalité, Il faut renseigner un nombre minimum d'article afin d'obtenir la liste de ses co-auteur :

	si le nombre renseigné ne colle pas avec les data de la base de donnée, un message rouge s'affichera stipulant que le nombre renseigné est trop grand (ex: 10)

	si le nombre renseigné colle avec les data de la base de donnée, cela affichera la liste des chercheurs ayant annoté au moins ce nombre d'articles (ex: 2)


Pour la 5eme fonctionnalité, Il faut renseigner le Nom d'un chercheur afin d'obtenir la moyenne des notes qu'il a donné :

	si le chercheur renseigné ne figure pas dans la base de donnée, un message rouge s'affichera stipulant la non présence de celui-ci (ex: Port)
	si le chercheur renseigné n'a noté aucun article, un message rouge s'affichera stipulant que le chercheur n'a noté aucun article (ex: Froidevaux)

	si le chercheur renseigné figure dans la base de donnée, cela affichera la moyenne des notes qu'il a donné (ex: Guerraoui)


Pour la 6eme fonctionnalité, Il faut renseigner le sigle d'un laboratoire afin d'obtenir le nom du chercheur, le nombre d'articles, le nombre de notes et la moyenne de celles-ci pour chaque chercheur travaillant dans le laboratoire spécifié en triant de façon décroissante par rapport au nombre d'articles réalisés :

	si le sigle du laboratoire renseigné ne figure pas dans la base de donnée, un message rouge s'affichera stipulant la non présence de celui-ci (ex: CSS)

	si le sigle du laboratoire renseigné figure dans la base de donnée, cela affichera le nom du chercheur, le nombre d'articles, le nombre de notes et leur moyenne (ex: INRIA Saclay)



Pour la 7eme fonctionnalité, Il faut renseigner le numéro d'un article afin de déterminer si la note maximale attribuée à celui-ci provient d'un chercheur travaillant dans le même laboratoire que l'auteur :

	si le numéro d'article renseigné n'est pas compris entre [1,totalArticle] alors cela renverra un message rouge stipulant que le numéro renseigné n'est pas présent dans la base 	de donnée (exemple: 0/-5 ou encore 11)	

	si le numéro de l'article renseigné renvoie que la note maximale provient d'un membre du même laboratoire, un message rouge s'affichera stipulant qu'il y a un Conflit (ex: 4)

	si le numéro de l'article renseigné renvoie que la note maximale ne provient pas d'un membre du même laboratoire, cela affichera un message bleu disant qu'il n'y a pas de Conflit (ex: 1)
