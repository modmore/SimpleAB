<?php

$_lang['simpleab'] = 'A/B Testing';
$_lang['simpleab.menu_desc'] = 'Manage your SimpleAB tests and variations.';

$_lang['simpleab.home'] = 'Manage A/B Tests';
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
$_lang['simpleab.apply_to_resources'] = 'Apply to Resources';
$_lang['simpleab.apply_to_resources.desc'] = 'Comma separated list of Resource IDs to run this test on. Example: 1,6,345';
$_lang['simpleab.apply_to_templates'] = 'Apply to Templates';
$_lang['simpleab.apply_to_templates.desc'] = 'Comma separated list of Template IDs to run this test on. Example: 2,5';
$_lang['simpleab.variations'] = 'Variations';
$_lang['simpleab.statistics'] = 'Statistics';
$_lang['simpleab.conversions'] = 'Conversions';
$_lang['simpleab.conversions.desc'] = 'A conversion is when a desired action (such as submitting a form, or viewing a certain page) was completed, and this test had a value assigned to it for completing the action.';
$_lang['simpleab.picks'] = 'Picks';
$_lang['simpleab.picks.desc'] = 'A "pick" represents a view of each variation. Which variation is shown depends the previous pick, normalized conversion rates or simply a random selection. Repeated visits to the same test does not count as a new pick.';
$_lang['simpleab.normalized'] = 'Normalized Conversions';
$_lang['simpleab.normalized.desc'] = 'Normalized conversions are the actual conversion rate (in percentage) of each variation. It is calculated by dividing the amount of picks by the amount of conversions per variation.';

$_lang['simpleab.add_test'] = 'Add Test';
$_lang['simpleab.update_test'] = 'Update Test';
$_lang['simpleab.update_test.description'] = 'Use this window to quickly update the name, description or active state of the Test. Looking for variations, conversions and more? Right click the test in the grid, and choose Manage Test instead.';
$_lang['simpleab.manage_test'] = 'Manage Test';
$_lang['simpleab.manage_test.title'] = 'Manage [[+name]]';
$_lang['simpleab.add_variation'] = 'Add Variation';
$_lang['simpleab.update_variation'] = 'Update Variation';
