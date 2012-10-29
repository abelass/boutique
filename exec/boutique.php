<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');
include_spip('public/assembler');

function exec_boutique_dist(){
	$contexte = Array();
	$contexte = calculer_contexte();
	
	// si pas autorise : message d'erreur
	if (!autoriser('modifier', 'article')) {
		include_spip('inc/minipres');
		echo minipres();
		exit;
	}
	
	// pipeline d'initialisation
	pipeline('exec_init', array('args'=>array('exec'=>'boutique'),'data'=>''));
	// entetes
	$commencer_page = charger_fonction('commencer_page', 'inc');


	// titre, partie, sous_partie (pour le menu)
	echo $commencer_page(_T('plugin:titre_boutique'), "editer", "editer");
	
// 	// titre
// 	echo recuperer_fond('prive/generale/categorie_fil_ariane',$contexte,Array("ajax"=>true));
// 	//echo gros_titre(_T('echoppe:gerer_echoppe'),'', false);
	
	// colonne gauche
	echo debut_gauche('', true);
	
	include_spip('exec/inc-boutique_boite_info');

	include_spip('exec/inc-boutique_shortcuts');	
					
	echo pipeline('affiche_gauche', array('args'=>array('exec'=>'boutique'),'data'=>''));	
	

	// colonne droite
	echo creer_colonne_droite('', true);
	echo pipeline('affiche_droite', array('args'=>array('exec'=>'boutique'),'data'=>''));
	
	// centre
	echo debut_droite('', true);
	// contenu
	// ...
	$voir = _request('voir');
	if($voir)$voir = '_'.$voir;
	echo recuperer_fond('prive/contenu/boutique_milieu'.$voir,$contexte,Array("ajax"=>true));

	// ...
	// fin contenu
	echo pipeline('affiche_milieu', array('args'=>array('exec'=>'boutique'),'data'=>''));
	
	echo fin_gauche(), fin_page();

}
?>
