# MedIT — débogage d'un site WordPress

Site vitrine d'une entreprise de services informatiques pour le secteur médical, livré avec 6 bugs à corriger.

**Démo :** [stephanietrnc.github.io/medIT](https://stephanietrnc.github.io/medIT/)

## Contexte

Projet de la formation Développeur WordPress d'OpenClassrooms, repris et amélioré ensuite.
Le but : remettre en état un site existant (OceanWP, Elementor, ACF, Contact Form 7) et documenter chaque correction dans un cahier de recette.
Le contenu du site (textes, photos, cabinet d'avocats) vient de la démo du thème : seul le code a été travaillé.

## Les 6 bugs corrigés

| Bug | Cause | Correction |
| --- | --- | --- |
| Erreur critique, site inaccessible | Fonction `contact_btn` déclarée deux fois (`header.php` et `functions.php`) | Doublon supprimé |
| Elementor charge sans fin | Erreur 500 sur une requête Ajax : faute de frappe dans un fichier de l'extension (`send_successs`) | Mise à jour d'Elementor |
| La croix ne ferme pas la pop-up | `$` ne fonctionne pas avec le jQuery de WordPress (mode noConflict) | `jQuery` et ciblage du bon parent |
| Formulaire absent de la pop-up | Mauvais identifiant de formulaire et `echo` manquant devant `do_shortcode` | Identifiant et `echo` corrigés |
| Lien Google Maps en 404 | Mauvais format de retour du champ ACF | Champ réglé pour renvoyer l'URL |
| Bouton contact pas centré | Bouton ajouté hors d'un `<li>` dans le menu | Alignement corrigé en CSS, puis bouton placé dans un `<li>` |

## Améliorations après la formation

- Pop-up sortie de `header.php` : template partiel + script chargé via `functions.php`
- Champs ACF échappés, site protégé si ACF est désactivé
- Pop-up accessible : vrai bouton de fermeture, touche Échap, focus clavier, affichée une seule fois
- Contraste des textes et boutons conforme WCAG AA
- Bouton contact dans un `<li>`, uniquement dans le menu principal
- Font Awesome chargé une seule fois au lieu de deux (environ 160 Ko en moins)
- Image de fond en WebP (240 Ko → 73 Ko), textes alternatifs des photos
- Page FAQ : message clair à la place du shortcode `[faq]` cassé
- Extensions inutiles retirées, menu mobile et champ newsletter corrigés

## Structure

- `themes/oceanwp-child-theme-master` : le thème enfant
- `docs` : version statique du site, publiée avec GitHub Pages

La démo est statique : les formulaires (pop-up, contact, newsletter) et la recherche ne fonctionnent pas en ligne.
