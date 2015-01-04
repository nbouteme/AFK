Vues
====

La plupart des vues ont en commun une barre latérale, base.php, et le "@Content@" est substitué par les templates.
base.php contient déja les header des page, et le chargement des styles et code javascript, il n'y a qu'a ecrire le corps des page (ce qui est dans le body)
et faire abstraction du reste.

Le controlleur charge alors la template a afficher, puis fais un rendu de la page (base dans la plupart des cas) en substituant @Content@ par le template, si il a été chargé avant.
