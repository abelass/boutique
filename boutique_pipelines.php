<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function rubrique_produits($id_article){
	$rubrique_produit=0;

	$rubrique_produit=lire_config('boutique/rubrique_produits');

	$valide=sql_fetsel("id_article", "spip_articles", "id_article=".$id_article." AND id_rubrique=".$rubrique_produit);
	
	return $valide;
}

function boutique_affiche_milieu($flux){
	// affichage du formulaire d'activation désactivation projets	

        if ($flux['args']['exec']=='articles') {
	$id_article = $flux['args']['id_article'];
	if(rubrique_produits($id_article)){
			$deplie=false;
			if($_REQUEST['formulaire_action']=='prix' OR $_REQUEST['retour_action']) $deplie=true;
			if($_REQUEST['retour_action']=='prix')$deplie=true;
			$contexte = array('id_article'=>$id_article);
			$contenu .= recuperer_fond('prive/contenu/prix', $contexte);
			$res .= cadre_depliable('',_T('boutique:info_prix'),$deplie,$contenu,'prix','e');    		
			$flux["data"] .= $res;
			}
		}
return $flux;
}

function boutique_header_prive($flux){
	// affichage du formulaire d'activation désactivation projets	

       $flux .= '<link rel="stylesheet" href="'.find_in_path('css/flora.css').'" type="text/css" media="all" />';
 	return $flux;	
}
?>