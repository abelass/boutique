<?php

function formulaires_commande_charger_dist($id_produit,$n_titre=NULL){
	include_spip('boutique_mes_fonctions');
	
	$valeurs = array(
		'id_commande'=>_request('id_commande'),	
		'retour'=>_request('retour'),
		'prix'=>_request('prix'),					
		'nom'=>'',	
		'email'=>'',	
		'adresse'=>'',
		'code_postal'=>'',
		'id_produit'=>$id_produit,	
		'de_la_part_de'=>'',			
		'ville'=>'',
		'pays'=>'',			
		'titre'=>'',
		'titre_2'=>'',	
		'n_titre'=>$n_titre,				
		'id_option'=>'',
		'commentaire'=>'',
		'code_devise'=>'',
		'date_enregistrement_jour'=>'',
		'date_enregistrement_mois'=>'',
		'date_enregistrement_annee'=>'',
		'url_retour'=>'',						
		);
		
	if($code_pays=$_COOKIE['spip_pays'])$valeurs['pays']=sql_getfetsel('id_pays','spip_geo_pays','code='.sql_quote($code_pays));
		
	$valeurs['code_devise_defaut']=devise_defaut($id_produit);
		
	$req=sql_select('titre,id_mot','spip_mots','id_groupe='.lire_config('boutique/groupe_constellation'));
	
	$valeurs['constellation']=array();
		
	while($data=sql_fetch($req)){
		$valeurs['constellation'][$data['id_mot']]=extraire_multi($data['titre']);
		}
		
	$valeurs['devises_choisis']=array();	
		
	$req=sql_select('code_devise,prix,id_prix','spip_boutique_prix','id_article='.$id_produit);

	while($row=sql_fetch($req)){
		$valeurs['devises_choisis'][$row['code_devise']] = $row['prix'].' '.traduire_devise($row['code_devise']);
		}

	
	$valeurs['prev']=_request('prev');
	
	

	$prix=traduire_code_devise(_request('code_devise'),$id_produit,'prix');
 	$valeurs['_hidden'] .='<input type="hidden" value="'.$prix.'" name="prix"/>';
	
	//Insertion du pipeline charger
	$pipelines = pipeline('bt_form_commande_charger',array(
   				'args'=>$valeurs,		
    				'data'=>""
			)
		);
		
	if(is_array($pipelines)){
		foreach($pipelines as $key=>$value){
		if($key!='_hidden')$valeurs[$key]=$value;
		elseif(is_array($value)){
			foreach($value as $name=>$v){
			$valeurs[$key] .='<input type="hidden" value="'.$v.'" name="'.$name.'"/>';
				}	
		 	}
		 }
		 
		}
return $valeurs;
}

function formulaires_commande_verifier_dist($id_produit,$n_titre=NULL){

	$email=_request('email');


	$date_enregistrement_annee=_request('date_enregistrement_annee');

   	$erreurs = array();
    	foreach(array('nom','email','adresse','code_postal','ville','titre','id_option','code_devise','date_enregistrement_jour','date_enregistrement_mois','date_enregistrement_annee','pays') as $champ) {
        	if (!_request($champ)) {
            		$erreurs[$champ] = _T('spip:info_obligatoire');
        		}
    	}
    	
    	if ($n_titre AND !_request('titre_2'))$erreurs['titre_2'] = _T('spip:info_obligatoire');
    	
    	if (count($erreurs)) {
        	$erreurs['message_erreur'] = _T('spip:avis_erreur');
   		 }
    
    	if($email AND !email_valide($email)){
		$erreurs['email'] = _T('info_email_invalide');
		}
		
			
				
	if (!checkdate(_request('date_enregistrement_mois') ,_request('date_enregistrement_jour'),$date_enregistrement_annee )){		
 		$erreurs['date_enregistrement_annee'] = _T('boutique:date_non_valide');
 			}
 			
 	//Insertion du pipeline verifier	
	$pipelines = pipeline('bt_form_commande_verifier',array(
   		 'args'=>array(
        			'id_objet'=>$id_produit     			
    				), 
    			'data'=>""
			)
		);
	if(is_array($pipelines)){
		foreach($pipelines as $key=>$value)
		$erreurs[$key]=$value;
		}			
	
    return $erreurs;



}
function formulaires_commande_traiter_dist($id_produit,$n_titre=NULL){
   	refuser_traiter_formulaire_ajax(); 	
	include_spip('boutique_mes_fonctions');
	$prev=_request('prev');
	$code_devise=_request('code_devise');
	$prix=_request('prix');
	//if(_request('prix'))$prix=traduire_code_devise($code_devise,$id_produit,'prix');
	$frais_livraison=lire_config('boutique/frais_livraison_'.$code_devise);
	$date_enregistrement = _request('date_enregistrement_annee').'-'._request('date_enregistrement_mois').'-'._request('date_enregistrement_jour');
	$retour = array();

	if($prev){

		$retour['message_ok']='prev';
		}
	elseif(_request('modifier')){
		$retour['message_ok']='modifier';
		}
	else{
		$token = md5(uniqid(rand(), true));
		include_spip('inc/cookie');
	 	spip_setcookie('spip_boutique_session',$token, time()+2*3600 );
		
		$valeurs = array(
			'nom'=>_request('nom'),
			'lang'=>_request('lang'),		
			'email'=>_request('email'),
			'adresse'=>_request('adresse'),
			'code_postal'=>_request('code_postal'),
			'ville'=>_request('ville'),		
			'pays'=>_request('pays'),					
			'id_produit'=>$id_produit,		
			'titre'=>_request('titre'),
			'titre_2'=>_request('titre_2'),			
			'de_la_part_de'=>_request('de_la_part_de'),			
			'id_option'=>_request('id_option'),
			'commentaire'=>_request('commentaire'),
			'prix'=>$prix,
			'frais_livraison'=>$frais_livraison,				
			'code_devise'=>$code_devise,
			'date_enregistrement'=>$date_enregistrement,
			'date_creation'=>date('Y-m-d H:i:s'),
			'token'=>$token							
			);
	 
	 	$id_commande=sql_insertq('spip_boutique_commande',$valeurs);
	 	
		$retour['message_ok']=array('id_commande'=>$id_commande);
		
		 //Insertion du pipeline traiter
		 	
		$pipelines = pipeline('bt_form_commande_traiter',array(
			'args'=>array(
					'id_objet'=>$id_produit     			
					), 
				'data'=>""
				)
			);
			
	 	header('Location:'.parametre_url(_request('url_retour'),'id_commande',$id_commande,'&'));
	 	}



    return $retour;
}


?>