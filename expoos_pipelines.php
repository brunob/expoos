<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Ajouter geodiversite.net à la liste des providers oembed
 *
 * @param $providers
 * @return mixed
 */
function expoos_oembed_lister_providers($providers){
	$providers['https://www.geodiversite.net/*'] = 'https://www.geodiversite.net/oembed.api/';
	return $providers;
}
