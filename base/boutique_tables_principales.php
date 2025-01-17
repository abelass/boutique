<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
//
// Formulaires : Structure
//

function boutique_declarer_tables_principales($tables_principales){
	$spip_boutique_commande = array(
		"id_commande" 		=> "int(21) NOT NULL",
		"nom" 			=> "varchar(255) NOT NULL",
		"email" 		=> "varchar(255) NOT NULL",
		"adresse" 		=> "text NOT NULL",		
		"code_postal" 		=> "varchar(255) NOT NULL",
		"ville" 		=> "text NOT NULL",
		"pays" 			=> "int(3) NOT NULL",		
		"id_produit" 		=> "text NOT NULL",
		"titre" 		=> "text NOT NULL",
		"titre_2" 		=> "text NOT NULL",		
		"de_la_part_de" 	=> "text NOT NULL",		
		"id_option" 		=> "int(21) NOT NULL",
		"commentaire" 		=> "text NOT NULL",
		"prix" 			=> "float NOT NULL",
		"frais_livraison" 	=> "float NOT NULL",		
		"code_devise" 		=> "varchar(3) NOT NULL",
		"token" 		=> "varchar(255) NOT NULL",
		"statut" 		=> "varchar(255) NOT NULL",	
		"statut_paiement" 	=> "varchar(255) NOT NULL",
		"traitement" 		=> "varchar(255) NOT NULL",		
		"date_enregistrement" 	=> "date DEFAULT '0000-00-00' NOT NULL",		
		"date_creation" 	=> "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",		
		"maj" 			=> "TIMESTAMP");
	
	$spip_boutique_commande_key = array(
		"PRIMARY KEY" 	=> "id_commande",
		);
		
	$spip_boutique_commande_join = array(
		"id_commande"	=> "id_commande",
		);

	$tables_principales['spip_boutique_commande'] = array(
		'field' => &$spip_boutique_commande,
		'key' => &$spip_boutique_commande_key,
		'join' => &$spip_boutique_commande_join
	);

	$spip_boutique_prix = array(
		"id_prix" 	=> "int(21) NOT NULL",
		"id_article" 	=> "int(21) NOT NULL",
		"code_devise" 	=> "varchar(3) NOT NULL",
		"prix" 		=> "float NOT NULL",
		);
	
	$spip_boutique_prix_key = array(
		"PRIMARY KEY" 	=> "id_prix",
		"KEY id_article"	=> "id_article",
		);
		
	$spip_boutique_prix_join = array(
		"id_prix"	=> "id_prix",
		"id_article"	=> "id_article",
		);

	$tables_principales['spip_boutique_prix'] = array(
		'field' => &$spip_boutique_prix,
		'key' => &$spip_boutique_prix_key,
		'join' => &$spip_boutique_prix_join
	);
			
		
		
	return $tables_principales;
	
	}
?>
