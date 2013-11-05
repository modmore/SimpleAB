<?php

$_lang['simpleab'] = 'A/B Tests';
$_lang['simpleab.menu_desc'] = 'Beheer de SimpleAB tests en variaties.';

$_lang['simpleab.home'] = 'Beheer A/B Tests';
$_lang['simpleab.test'] = 'Test';
$_lang['simpleab.tests'] = 'Tests';
$_lang['simpleab.to_home'] = 'Terug naar Tests';

$_lang['simpleab.id'] = 'ID';
$_lang['simpleab.name'] = 'Naam';
$_lang['simpleab.description'] = 'Omschrijving';
$_lang['simpleab.element'] = 'Element';
$_lang['simpleab.type'] = 'Type';
$_lang['simpleab.threshold'] = 'Conversie Drempel';
$_lang['simpleab.threshold.desc'] = 'Het aantal conversies dat gelogd moet zijn voordat SimpleAB automatisch de beste variatie kiest (op basis van conversie percentages) voor website bezoekers.';
$_lang['simpleab.randomize'] = 'Willekeurige Percentage';
$_lang['simpleab.randomize.desc'] = 'Na het behalen van de conversie drempel kiest SimpleAB automatisch de variatie met het hoogste conversie percentage. Het Willekeurige Percentage geeft aan hoe vaak er in die situatie alsnog een willekeurige variatie gekozen dient te worden ter bevestiging van de conversie. Bijvoorbeeld bij een willekeurige percentage van 25, zal er voor 1 op de 4 bezoekers een willekeurige variatie getoond worden na het overschrijden van de conversie drempel.';
$_lang['simpleab.active'] = 'Actief';
$_lang['simpleab.archived'] = 'Gearchiveerd';
$_lang['simpleab.smartoptimize'] = 'Automatisch Optimaliseren';
$_lang['simpleab.apply_to_resources'] = 'Gebruik op Documenten';
$_lang['simpleab.apply_to_resources.desc'] = 'Kommagescheiden lijst van Documenten om deze test op uit te voeren. Bijvoorbeeld 1,6,345';
$_lang['simpleab.apply_to_templates'] = 'Gebruik op Templates';
$_lang['simpleab.apply_to_templates.desc'] = 'Kommagescheiden lijst van Template IDs om deze test op uit te voeren. Bijvoorbeeld: 2,5';
$_lang['simpleab.variation'] = 'Variatie';
$_lang['simpleab.variations'] = 'Variaties';
$_lang['simpleab.statistics'] = 'Statistieken';
$_lang['simpleab.conversions'] = 'Conversies';
$_lang['simpleab.conversions.desc'] = 'Een conversie is wanneer een gewenste actie (het opslaan van een formulier, of een bepaalde pagina bekijken) plaatsvind en er voor deze test een variatie was gekozen.';
$_lang['simpleab.conversionrate'] = 'Conv. Percent.';
$_lang['simpleab.picks'] = 'Weergaven';
$_lang['simpleab.picks.desc'] = 'Weergaven per variatie. Welke variatie getoond wordt is gebaseerd op een eventuele vorige keuze, eerdere conversie percentages of simpelweg een willekeurige variatie. Herhaalde bezoeken tellen niet als een nieuwe weergave.';
$_lang['simpleab.normalized'] = 'Conversie Percentage';
$_lang['simpleab.normalized.desc'] = 'Het conversie percentage per variatie. Dit is berekend door het aantal weergaven te delen door het aantal conversies per variatie.';

$_lang['simpleab.add_test'] = 'Voeg Test Toe';
$_lang['simpleab.add_template_test'] = 'Voeg Template Test Toe';
$_lang['simpleab.add_chunk_test'] = 'Voeg Chunk Test Toe';
$_lang['simpleab.update_test'] = 'Bewerk Test';
$_lang['simpleab.manage_test'] = 'Beheer Variations & Resultaten';
$_lang['simpleab.manage_test.title'] = 'Beheer [[+name]]';
$_lang['simpleab.unarchive_test'] = 'Dearchiveer Test';
$_lang['simpleab.unarchive_test.confirm'] = 'Weet je zeker dat je deze test wilt dearchiveren?';
$_lang['simpleab.archive_test'] = 'Archiveer Test';
$_lang['simpleab.archive_test.confirm'] = 'Weet je zeker dat je deze test wilt archiveren? De test zal niet meer in de tabel getoond worden.';
$_lang['simpleab.archive_test.already_archived'] = 'Deze test is al gearchiveerd.';
$_lang['simpleab.unarchive_test.already_unarchived'] = 'Deze test is al gedearchiveerd.';
$_lang['simpleab.clear_test_data'] = 'Verwijder Test Gegevens';
$_lang['simpleab.add_variation'] = 'Voeg Variatie Toe';
$_lang['simpleab.update_variation'] = 'Bewerk Variatie';
$_lang['simpleab.refresh_to_update'] = '<strong>Let op:</strong> Er zijn wijzigingen gemaakt aan de variaties van deze test. Om dit in de statistieken terug te zien dient de pagina ververst te worden. <a href="javascript:location.href=location.href;">Click hier om de pagina te verversen.</a>';
$_lang['simpleab.view_archived_tests'] = 'Toon Gearchiveerde Tests';
$_lang['simpleab.view_current_tests'] = 'Toon Enkel Huidige Tests';
$_lang['simpleab.clear_variation_data'] = 'Verwijder Weergaven & Conversies';
$_lang['simpleab.clear_variation_data.confirm'] = 'Het is niet mogelijk om het verwijderen van de weergaven en conversies ongedaan te maken. Weet je zeker dat je deze data wilt verwijderen?';
$_lang['simpleab.delete_variation'] = 'Verwijder Variatie';
$_lang['simpleab.delete_variation.confirm'] = 'Weet je zeker dat je de variatie wilt verwijderen? Het is mogelijk om de variatie opnieuw aan te maken, echter zullen de conversie en weergave statistieken voor deze variatie verloren gaan.';
$_lang['simpleab.delete_test'] = 'Verwijder Test';
$_lang['simpleab.delete_test.confirm'] = 'Weet je zeker dat je de test wilt verwijderen? Het is mogelijk om de test opnieuw aan te maken, echter zullen de variaties, conversies en weergaven verloren gaan. Indien je enkel de test wilt verbergen is het mogelijk om dat te doen door de test te archiveren.';
$_lang['simpleab.duplicate_test'] = 'Dupliceer Test';
$_lang['simpleab.duplicate_data'] = 'Dupliceer ook Weergave en Conversie Data';
$_lang['simpleab.duplicate_of'] = 'Duplicaat van ';
$_lang['simpleab.preview_variation'] = 'Preview Variatie';
$_lang['simpleab.resource'] = 'Document';


$_lang['simpleab.clear_test_data_warning'] = 'Het verwijderen van de data van deze test kan niet ongedaan gemaakt worden. Als je zeker weet dat je dit wil doen, kies hieronder dan de specifieke data die verwijderd dient te worden. ';
$_lang['simpleab.clear_conversions'] = 'Verwijder Conversie Data';
$_lang['simpleab.clear_picks'] = 'Verwijder Weergave Data';
$_lang['simpleab.clear_variations'] = 'Verwijder Variaties';


$_lang['setting_simpleab.use_previous_picks'] = 'Use Previous Picks';
$_lang['setting_simpleab.use_previous_picks_desc'] = 'When enabled, SimpleAB will look at the users\' session to make sure they are presented the same variation on subsequent visits. You probably don\'t really want to turn this off in production, but it\'s great for demos!';

$_lang['setting_simpleab.hide_logo'] = 'Hide modmore logo';
$_lang['setting_simpleab.hide_logo_desc'] = 'By default, there is a subtle modmore logo in the bottom right of the component, linking back to the SimpleAB documentation. If you don\'t want it there, no sweat, just enable this setting.';
