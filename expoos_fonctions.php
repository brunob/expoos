<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// convertir une couleur hex en grba avec un niveau de transparence
function couleur_transaprence($couleur, $transparence = 0.75) {
	include_spip('inc/filtres_images_lib_mini');
	$rgb = _couleur_hex_to_dec($couleur);
	return 'rgba('.$rgb['red'].','.$rgb['green'].','.$rgb['blue'].','.$transparence.')';
}

// restreindre les champs extras en fonction de la composition de la rubrique
include_spip('inc/cextras_autoriser');
restreindre_extras('rubrique', ['largeur','variante','colonnes','carto'], 'expo', 'composition');