<?php

if (!defined("_ECRIRE_INC_VERSION")) return;


function formulaires_prix_charger_dist($id_article){


	$devises_dispos =lire_config('boutique/devises');
	$devises_choisis =array();	
	
	$d=sql_select('code_devise','spip_boutique_prix','id_article='.$id_article);
		
	while($row=sql_fetch($d)){
		$devises_choisis[$row['code_devise']] = $row['code_devise'];	
		}
		
	$devises = array_diff($devises_dispos,$devises_choisis);
	
	
	$valeurs = array(
		'id_article'=>$id_article,
		'devises'=>$devises,	
		'code_devise'=>'',
		'prix'=>'',									
		);
	return $valeurs;			
}


function formulaires_prix_verifier_dist(){

	
	foreach(array('prix','code_devise') as $obligatoire)
	
	if (!_request($obligatoire)) $erreurs[$obligatoire] = _T('encheres:champ_obligatoire');	
		
    return $erreurs; // si c'est vide, traiter sera appele, sinon le formulaire sera resoumis
}

/*Elimination de la base de donées */
function formulaires_prix_traiter_dist($id_article){
	$valeurs=array(
		'id_article' => $id_article,
		'prix' => _request('prix'),
		'code_devise' => _request('code_devise')
		);
	sql_insertq('spip_boutique_prix', $valeurs);
}

?>