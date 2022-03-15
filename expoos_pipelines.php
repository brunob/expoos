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


/**
 * Insertion dans le pipeline pre_boucle (SPIP)
 * Pour les listes d'articles, il faut exclure les articles annexes
 *
 * @param array $flux
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte modifié
 */
function expoos_pre_boucle($boucle) {
	// On ne s'intéresse qu'à la boucle ARTICLES
	if ($boucle->type_requete == 'articles' and empty($boucle->modificateur['tout'])) {
		// On n'insère le filtre {annexe=''} pour exclure les annexes que si aucune des conditions
		// suivantes n'est vérifiée:
		// - pas de critère annexe autre que {annexe=''}
		// pas de critère {id_article=XX} ou {id_article} ou {id_article?}
		$boucle_articles = true;

		// On cherche les critères id_rubrique, id_article ou annexe
		foreach ($boucle->criteres as $_critere) {
			// Aucun filtre du tout quand on cherche des traductions
			if ($_critere->op == 'traduction' or $_critere->op == 'origine_traduction') {
				$boucle_articles = false;
				break;
			}
			elseif (isset($_critere->param[0][0]->texte) and $_critere->param[0][0]->texte == 'annexe') { // {annexe=x}
				if (
					($_critere->op == '=')
					and ($_critere->param[1][0]->texte == '')
					and empty($_critere->param[1][1])
					or $_critere->not
				) {
					// On veut exclure explicitement les annexes
					break;
				} else {
					// on désigne bien des annexes par leur champ 'annexe'
					$boucle_articles = false;
					break;
				}
			}
			elseif (($_critere->op == 'id_article') // {id_article} ou {id_article?}
				or (isset($_critere->param[0][0]->texte) and $_critere->param[0][0]->texte == 'id_article')) { // {id_article=x}
				// On pointe sur un article précis, il est donc inutile de rajouter un test sur la rubrique
				// Pour le critère {id_article?} on considère que pour sélectionner des annexes uniques
				// ou des articles éditoriaux on doit préciser le critère {id_rubrique}
				$boucle_articles = false;
			}
		}

		// Si on est en présence d'une boucle article purement éditoriale, on ajoute le filtre annexe=''
		if ($boucle_articles) {
			$boucle->where[] = array("'='", "'articles.annexe'", "'\"\"'");
		}
	}

	return $boucle;
}