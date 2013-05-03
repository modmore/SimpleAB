<?php

$_lang['simpleab'] = 'A/B Testing';
$_lang['simpleab.menu_desc'] = 'Manage your SimpleAB tests and variations.';

$_lang['simpleab.home'] = 'Manage A/B Tests';
$_lang['simpleab.test'] = 'Test';
$_lang['simpleab.tests'] = 'Tests';
$_lang['simpleab.to_home'] = 'Back to Tests';

$_lang['simpleab.id'] = 'ID';
$_lang['simpleab.name'] = 'Name';
$_lang['simpleab.description'] = 'Description';
$_lang['simpleab.element'] = 'Element';
$_lang['simpleab.type'] = 'Type';
$_lang['simpleab.threshold'] = 'Conversion Threshold';
$_lang['simpleab.threshold.desc'] = 'How many conversions must be logged until SimpleAB will automatically choose the best performing variation for the requests. Also see the Randomization Percentage.';
$_lang['simpleab.randomize'] = 'Randomization Percentage';
$_lang['simpleab.randomize.desc'] = 'After passing the Conversion Threshold, SimpleAB will use the variation with the highest conversion by default. The Randomization Percentage indicates how often, after passing the threshold, a random variation should be shown to validate the conversion. For example, a randomization of 25% will mean one in four requests will be shown a random variation after passing the conversion threshold.';
$_lang['simpleab.active'] = 'Active';
$_lang['simpleab.archived'] = 'Archived';
$_lang['simpleab.apply_to_resources'] = 'Apply to Resources';
$_lang['simpleab.apply_to_resources.desc'] = 'Comma separated list of Resource IDs to run this test on. Example: 1,6,345';
$_lang['simpleab.apply_to_templates'] = 'Apply to Templates';
$_lang['simpleab.apply_to_templates.desc'] = 'Comma separated list of Template IDs to run this test on. Example: 2,5';
$_lang['simpleab.variations'] = 'Variations';
$_lang['simpleab.statistics'] = 'Analytics';
$_lang['simpleab.conversions'] = 'Conversions';
$_lang['simpleab.conversions.desc'] = 'A conversion is when a desired action (such as submitting a form, or viewing a certain page) was completed, and this test had a value assigned to it for completing the action.';
$_lang['simpleab.conversionrate'] = 'Conv. Rate';
$_lang['simpleab.picks'] = 'Picks';
$_lang['simpleab.picks.desc'] = 'A "pick" represents a view of each variation. Which variation is shown depends the previous pick, normalized conversion rates or simply a random selection. Repeated visits to the same test does not count as a new pick.';
$_lang['simpleab.normalized'] = 'Conversion Rate';
$_lang['simpleab.normalized.desc'] = 'The actual conversion rate (percentage) for each variation. It is calculated by dividing the amount of picks by the amount of conversions per variation.';

$_lang['simpleab.add_test'] = 'Add Test';
$_lang['simpleab.update_test'] = 'Edit Test';
$_lang['simpleab.manage_test'] = 'Manage Variations & Results';
$_lang['simpleab.manage_test.title'] = 'Manage [[+name]]';
$_lang['simpleab.unarchive_test'] = 'Un-archive Test';
$_lang['simpleab.unarchive_test.confirm'] = 'Are you sure you want to unarchive this test?';
$_lang['simpleab.archive_test'] = 'Archive Test';
$_lang['simpleab.archive_test.confirm'] = 'Are you sure you want to archive this test? It will be deactivated and removed from the Tests grid.';
$_lang['simpleab.archive_test.already_archived'] = 'This test has already been archived.';
$_lang['simpleab.unarchive_test.already_unarchived'] = 'This test has already been unarchived.';
$_lang['simpleab.clear_test_data'] = 'Clear Test Data';
$_lang['simpleab.add_variation'] = 'Add Variation';
$_lang['simpleab.update_variation'] = 'Edit Variation';
$_lang['simpleab.refresh_to_update'] = '<strong>Note:</strong> You have made changes to the variations of this test. You will need to refresh your browser to see this reflected in the Analytics tab. <a href="javascript:location.href=location.href;">Click here to refresh.</a>';
$_lang['simpleab.view_archived_tests'] = 'Include Archived Tests';
$_lang['simpleab.view_current_tests'] = 'View Current Tests Only';
$_lang['simpleab.clear_variation_data'] = 'Clear Picks & Conversions Data';
$_lang['simpleab.clear_variation_data.confirm'] = 'Clearing the data for this Variation cannot be undone. Are you sure you want to do this?';


$_lang['simpleab.clear_test_data_warning'] = 'Clearing the data for this test cannot be undone. If you are sure you want to do this, please tick the boxes for the data you would like to remove below. ';
$_lang['simpleab.clear_conversions'] = 'Remove Conversion Data';
$_lang['simpleab.clear_picks'] = 'Remove Picks Data ';
$_lang['simpleab.clear_variations'] = 'Remove Variations';
