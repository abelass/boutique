<?php

function boutique_init_tables_interfaces($tables_interfaces){

	$tables_interfaces['table_des_tables']['boutique_prix'] = 'boutique_prix';
	$tables_interfaces['table_des_tables']['boutique_commande'] = 'boutique_commande';
	$tables_interfaces['table_des_tables']['geo_pays'] = 'geo_pays';	
	return $tables_interfaces;
}


?>
