<?php
/**
 * Translated by Romain Tripault
 * Last updated 2013-11-13
 */

$_lang['simpleab'] = 'A/B Testing';
$_lang['simpleab.menu_desc'] = 'Gérez vos tests et variations SimpleAB.';

$_lang['simpleab.home'] = 'Gérez les tests A/B';
$_lang['simpleab.test'] = 'Test';
$_lang['simpleab.tests'] = 'Tests';
$_lang['simpleab.to_home'] = 'Retour aux Tests';

$_lang['simpleab.id'] = 'ID';
$_lang['simpleab.name'] = 'Nom';
$_lang['simpleab.description'] = 'Description';
$_lang['simpleab.element'] = 'Élement';
$_lang['simpleab.type'] = 'Type';
$_lang['simpleab.threshold'] = 'Seuil de conversion Threshold';
$_lang['simpleab.threshold.desc'] = 'Combien de convertions doivent être enregistrée avant que SimpleAB ne détermine quelle variations est la meilleure. Voir également le pourcentage de randomisation.';
$_lang['simpleab.randomize'] = 'Pourcentage de randomisation';
$_lang['simpleab.randomize.desc'] = 'Après le seuil de conversion, SimpleAB utilisera par défaut la variation avec le plus de conversion. Le pourcentage de randomisation indique la fréquence, une fois le seuil atteind, à laquelle une variation aléatoire doit être affichée afin de valider la conversion. Par exemple, une randomisation de 25% signifie qu\'une requête sur 4 aura une variation aléatoire (une fois le seuil de conversion atteind).';
$_lang['simpleab.active'] = 'Actif';
$_lang['simpleab.archived'] = 'Archivé';
$_lang['simpleab.smartoptimize'] = 'Activer l\'optimisation automatique';
$_lang['simpleab.apply_to_resources'] = 'Appliquer aux ressources';
$_lang['simpleab.apply_to_resources.desc'] = 'Liste, séparée par des virgules, d\'IDs de ressources sur lesquelles effectuer ce test. Par exemple : 1,6,345';
$_lang['simpleab.apply_to_templates'] = 'Appliquer aux templates';
$_lang['simpleab.apply_to_templates.desc'] = 'Liste, séparée par des virgules, d\'IDs de templates sur lesquels effectuer ce test. Par exemple : 2,5';
$_lang['simpleab.variation'] = 'Variation';
$_lang['simpleab.variations'] = 'Variations';
$_lang['simpleab.statistics'] = 'Statistiques';
$_lang['simpleab.conversions'] = 'Conversions';
$_lang['simpleab.conversions.desc'] = 'Une conversion c\'est lorsqu\'une action désirée est effectuée (par exemple soumettre un formulaire, ou l\'accès à une certaine page) et que ce test a une valeur assignée de fin d\'action.';
$_lang['simpleab.conversionrate'] = 'Taux de conversion';
$_lang['simpleab.picks'] = 'Choix';
$_lang['simpleab.picks.desc'] = 'Un "choix" représente une vue de chaque variation. La variation affichée dépend du choix précédent, des taux de conversion normalisés, ou peut simplement être une sélection aléatoire. Les visites successives d\'un même test n\'est pas comptabilisé comme nouveau "choix".';
$_lang['simpleab.normalized'] = 'CTaux de conversion';
$_lang['simpleab.normalized.desc'] = 'Le taux actuel de conversion (pourcentage) de chaque variation. Il est calculé en divisant le nombre de choix par le nombre de conversion par variation.';

$_lang['simpleab.add_test'] = 'Ajouter le test';
$_lang['simpleab.add_template_test'] = 'Ajouter le test de template';
$_lang['simpleab.add_chunk_test'] = 'Ajouter le test de chunk';
$_lang['simpleab.update_test'] = 'Éditer le test';
$_lang['simpleab.manage_test'] = 'Gérer les variations et résultats';
$_lang['simpleab.manage_test.title'] = 'Gérer [[+name]]';
$_lang['simpleab.unarchive_test'] = 'Désarchiver le test';
$_lang['simpleab.unarchive_test.confirm'] = 'Êtes-vous sûr de vouloir retirer ce test des archives ?';
$_lang['simpleab.archive_test'] = 'Archiver le test';
$_lang['simpleab.archive_test.confirm'] = 'Êtes-vous sûr de vouloir archiver ce test ? Il sera désactivé et retiré de la grille des tests.';
$_lang['simpleab.archive_test.already_archived'] = 'Ce test a déjà été archivé.';
$_lang['simpleab.unarchive_test.already_unarchived'] = 'Ce test a déjà été désarchivé.';
$_lang['simpleab.clear_test_data'] = 'Effacer les données du test';
$_lang['simpleab.add_variation'] = 'Ajouter une variation';
$_lang['simpleab.update_variation'] = 'Éditer la variation';
$_lang['simpleab.refresh_to_update'] = '<strong>Note:</strong> Vous avez effectué des modifications aux variations de ce test. Vous devrez actualiser votre navigateur pour voir les changements répercutés dans l\'onglet des statistiques. <a href="javascript:location.href=location.href;">Cliquez ici pour actualiser.</a>';
$_lang['simpleab.view_archived_tests'] = 'Inclure les tests archivés';
$_lang['simpleab.view_current_tests'] = 'Afficher les tests acuels uniquement';
$_lang['simpleab.clear_variation_data'] = 'Effacer les données des choix et conversions';
$_lang['simpleab.clear_variation_data.confirm'] = 'Effacer les données de cette variation est irreverssible. Êtes-vous sûr de vouloir continuer ?';
$_lang['simpleab.delete_variation'] = 'Supprimer la variation';
$_lang['simpleab.delete_variation.confirm'] = 'Êtes-vous sûr de vouloir continuer ? Vous pouvez recréer la variation, mais vous ne poueez pas restaurer ses statistiques.';
$_lang['simpleab.delete_test'] = 'Supprimer le test';
$_lang['simpleab.delete_test.confirm'] = 'Êtes-vous sûr de vouloir continuer ? Bien que vous puissiez recréer le test, toutes ses données seront perdues. Si vous désirez simplement le masquer, veuillez simplement archiver le test.';
$_lang['simpleab.duplicate_test'] = 'Dupliquer le test';
$_lang['simpleab.duplicate_data'] = 'Inclure les données des choix et conversions';
$_lang['simpleab.duplicate_of'] = 'Copie de ';
$_lang['simpleab.preview_variation'] = 'Aperçu de la variation';
$_lang['simpleab.resource'] = 'Ressource';


$_lang['simpleab.clear_test_data_warning'] = 'Effacer les données de ce test est irreverssible. Si vous êtes-sûr de vouloir ceci, veuillez cocher ci-dessous les cases des données que vous souhaitez supprimer. ';
$_lang['simpleab.clear_conversions'] = 'Supprimer les données de conversion';
$_lang['simpleab.clear_picks'] = 'Supprimer les données des choix ';
$_lang['simpleab.clear_variations'] = 'Supprimer les variations';


$_lang['setting_simpleab.use_previous_picks'] = 'Utiliser les choix antérieurs';
$_lang['setting_simpleab.use_previous_picks_desc'] = 'Activez cette option pour que SimpleAB vérifie dans les sessions des utilisateurs afin de s\'assurer qu\'ils aient la même variation When enabled, SimpleAB will look at the users\' session to make sure they are presented the same variation suite à une visite précédente. Vous ne souhaitez probablement pas désactiver cette option en production, mais c\'est super pour les démos!';

$_lang['setting_simpleab.hide_logo'] = 'Masquer le logo modmore';
$_lang['setting_simpleab.hide_logo_desc'] = 'Par défaut, il y a un logo modmore discret en bas à droite (dans le composant) qui envoi vers la documentation de SimpleAB. Si vous ne souhaitez pas afficher ce logo, pas de panique, activez simple cette option.';
