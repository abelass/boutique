<?php
include_spip('base/abstract_sql');
// traduit le nom de la devise
function traduire_devise($code_devise){
	include_spip('inc/devises');

	$devises =devises();
	$trad= $devises[$code_devise];

	return $trad;
}
function prix_defaut($id_article){

	if($_COOKIE['spip_devise'])$devise_defaut=$_COOKIE['spip_devise'];
	elseif(lire_config('boutique/devise_default'))$devise_defaut=lire_config('boutique/devise_default');
	else 	$devise_defaut='EUR';

	$req=sql_select('code_devise,prix','spip_boutique_prix','id_article='.$id_article);

	while($row=sql_fetch($req)){
	
		$prix= $row['prix'].' '.traduire_devise($row['code_devise']);
	
		if($row['code_devise']==$devise_defaut) $defaut = $row['prix'].' '.traduire_devise($row['code_devise']);
	}	
		
	if($defaut)$defaut=$defaut;
	else $defaut=$prix;

	return $defaut;
}

function devise_defaut($id_article){

	if($_COOKIE['spip_devise'])$devise_defaut=$_COOKIE['spip_devise'];
	elseif(lire_config('boutique/devise_default'))$devise_defaut=lire_config('boutique/devise_default');
	else 	$devise_defaut='EUR';

	$req=sql_select('code_devise,prix','spip_boutique_prix','id_article='.$id_article);

	while($row=sql_fetch($req)){
	
		$prix= $row['prix'].' '.traduire_devise($row['code_devise']);
	
		if($row['code_devise']==$devise_defaut) $defaut = $row['code_devise'];
	}	
		
	if($defaut)$defaut=$defaut;
	else $defaut=$prix;

	return $defaut;
}

function titre_mot($id_mot){
	$titre=sql_fetsel('titre','spip_mots','id_mot='.$id_mot);

	return extraire_multi($titre['titre']);
}

function titre_article($id_article){
	$titre=sql_fetsel('titre','spip_articles','id_article='.$id_article);

	return $titre['titre'];
}

function traduire_code_devise($code_devise,$id_article,$option=""){

	$prix=sql_fetsel('prix','spip_boutique_prix','id_article='.$id_article.' AND code_devise LIKE "%'.$code_devise.'%"');

	$return =$prix['prix'].' '. traduire_devise($code_devise);
	
	if($option=='prix') $return =$prix['prix'];
	
	return $return;
}


function generer_url_retour_paiement($token_panier,$prestataire_paiement,$url_encode=''){
	
	$id_uniq_temp = sha1($token_panier.date("YmdGis"));
	
	
	$valeurs=array(
		'token_retour'=>$id_uniq_temp,
		'token_panier'=>$token_panier,
		'prestataire_paiement'=>$prestataire_paiement
		);
	

	sql_insertq("spip_boutique_tokens_retour",$valeurs);
	
	$url=generer_url_action("boutique_retour_prestataire_paiement","token_retour_paiement=$id_uniq_temp",$separateur);
	
	if ($url_encode) $url=myUrlEncode($url);
	
	return $url;
	
}

function myUrlEncode($string) {
    $replacements = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $entities = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
    return str_replace($entities, $replacements, urlencode($string));
    }
?>
