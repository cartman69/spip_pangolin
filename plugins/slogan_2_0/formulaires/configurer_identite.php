<?php
/*
 * Plugin Slogan
 * (c) 2009 C.Morin
 * Distribue sous licence GPL
 *
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_configurer_identite_charger_dist(){
	// travailler sur des meta fraiches
	include_spip('inc/meta');
	lire_metas();
	
	$valeurs = array();
	foreach(array('nom_site','adresse_site','slogan_site','descriptif_site','email_webmaster') as $k)
		$valeurs[$k] = isset($GLOBALS['meta'][$k])?$GLOBALS['meta'][$k]:'';
		
	return $valeurs;
}

function formulaires_configurer_identite_verifier_dist(){
	$erreurs = array();

	// adresse_site est obligatoire mais rempli automatiquement si absent !
	foreach(array('nom_site'/*,'adresse_site'*/) as $obli)
		if (!_request($obli))
			$erreurs[$obli] = _T('info_obligatoire');

	if ($email = _request('email_webmaster') AND !email_valide($email))
		$erreurs['email_webmaster'] = _T('info_email_invalide');
	
	return $erreurs;
}

function formulaires_configurer_identite_traiter_dist(){
	include_spip('inc/config');
	appliquer_modifs_config();
	
	include_spip('inc/meta');
	foreach(array('nom_site','adresse_site','slogan_site','descriptif_site') as $k)
		ecrire_meta($k,_request($k));

	return array('message_ok'=>_T('config_info_enregistree'),'editable'=>true);
}