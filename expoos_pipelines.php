<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Ajouter geodiversite.net à la liste des providers oembed
 *
 * @param $providers
 * @return array
 */
function expoos_oembed_lister_providers($providers){
	$providers['https://www.geodiversite.net/*'] = 'https://www.geodiversite.net/oembed.api/';
	return $providers;
}

/**
 * Récupérer le logo de l'article/rubrique d'origine_traduction
 *
 * @param array $flux
 * @return array
 */
function expoos_quete_logo_objet($flux) {
	if (empty($flux['data']) and $flux['args']['mode'] !== 'off' and in_array($flux['args']['objet'],['article','rubrique'])) {
		$table_objet = table_objet_sql($flux['args']['objet']);
		$cle_objet = $flux['args']['cle_objet'];
		$id_objet = $flux['args']['id_objet'];
		$id_trad = sql_getfetsel('id_trad', $table_objet, "$cle_objet=$id_objet");
		if ($id_trad and $id_trad != $id_objet and $origine_trad = sql_getfetsel(
			$cle_objet,
			"$table_objet AS objet",
			"(((objet.id_trad = 0) AND (objet.$cle_objet = $id_objet)) OR ((objet.id_trad > 0) AND (objet.id_trad = $id_trad))) AND ((objet.id_trad = objet.$cle_objet) OR (objet.id_trad = 0))"
		)) {
			$flux['data'] = quete_logo_objet($origine_trad, $flux['args']['objet'], $flux['args']['mode']);
		}
	}
	return $flux;
}
