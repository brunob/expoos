<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

$GLOBALS['z_blocs'] = array(
	'content',
	'head',
	'head_js',
	'header',
	'footer'
);

// désactiver l'héritage des logos de rubriques
define('_LOGO_RUBRIQUE_DESACTIVER_HERITAGE', true);

// indiquer à offline de cacher les fichiers audio présents dans les pages
define('_OFFLINE_RESSOURCES_TAGS', ['audio' => 'src']);