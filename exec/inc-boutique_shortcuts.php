<?php
	echo debut_cadre_relief('',true,'', _T('spip:titre_cadre_raccourcis'));
	
	echo '<ol class="shortcut">';
	
	if(_request('voir')){
	echo	'<li><a href="?exec=boutique" class="cellule-h"><img src="'.chemin('img/logo_boutique_24.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('boutique:retour_panel').' '._T('boutique:boutique').'</a>';
	echo '</li>';
	}

	echo	'<li><a href="?exec=cfg&cfg=boutique" class="cellule-h"><img src="'.chemin('cfg-22.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('spip:icone_configuration_site').'</a></li>';
	

	if(_request('exec')=='boutique'){
		$codeprom='<div><a href="?exec=codes_promo"><img src="'.chemin('img/logo_promo.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('codeprom:gestion_promotions').'</a></div>';
		}
	else{
		$codeprom .=	'<div><a href="?exec=boutique"><img src="'.chemin('img/logo_boutique_22.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('boutique:boutique').'</a></div>';
		if(!_request('editer_promo') )
			$codeprom.=	'<div><a href="?exec=codes_promo&editer_promo=new"><img src="'.chemin('img/logo_promo.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('codeprom:editer_code').'</a></div>';
		else		$codeprom.='<div><a href="?exec=codes_promo"><img src="'.chemin('img/logo_promo.png').'" alt="'._T('spip:icone_configuration_site').'" align="absmiddle" />&nbsp;'._T('codeprom:gestion_promotions').'</a></div>';		
		}
	echo $codeprom;
	echo pipeline('bt_affiche_gauche_shortcuts', array('args'=>array('exec'=>_request('exec')),'data'=>''));
			
	echo '</ol>';
	
	echo fin_cadre_relief(true);
?>