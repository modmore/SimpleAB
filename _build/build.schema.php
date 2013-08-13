<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of SimpleAB.
 *
 * For license terms, please review core/components/simpleab/docs/license.txt.
 *
 */
$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
$modx->initialize('mgr');
$modx->loadClass('transport.modPackageBuilder', '', false, true);
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$root = dirname(dirname(__FILE__)) . '/';
$sources = array(
    'root' => $root,
    'core' => $root . 'core/components/simpleab/',
    'model' => $root . 'core/components/simpleab/model/',
    'assets' => $root . 'assets/components/simpleab/',
    'schema' => $root . 'core/components/simpleab/model/schema/',
);
$manager = $modx->getManager();
$generator = $manager->getGenerator();
$generator->classTemplate = <<<EOD
<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of SimpleAB.
 *
 * For license terms, please review core/components/simpleab/docs/license.txt.
 *
*/
class [+class+] extends [+extends+]
{

}
EOD;

$generator->platformTemplate = <<<EOD
<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of SimpleAB.
 *
 * For license terms, please review core/components/simpleab/docs/license.txt.
 *
*/
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\\\', '/') . '/[+class-lowercase+].class.php');
/**
 * [+platform+]-specific implementation of [+class+]
 */
class [+class+]_[+platform+] extends [+class+]
{

}
EOD;

$generator->mapHeader = <<<EOD
<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <support@modmore.com>
 *
 * This file is part of SimpleAB.
 *
 * For license terms, please review core/components/simpleab/docs/license.txt.
 *
*/

EOD;

$generator->parseSchema($sources['schema'] . 'simpleab.mysql.schema.xml', $sources['model']);

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

echo "\nExecution time: {$totalTime}\n";


/* Create and/or dump data */
$modx->addPackage('simpleab', $sources['model']);

$objects = array(
    'sabTest',
    'sabVariation',
    'sabConversion',
    'sabPick',
);

foreach ($objects as $object) {
    if(isset($_REQUEST['dump']) && $_REQUEST['dump'] == 'true') {
        $manager->removeObjectContainer($object);
    }
    $manager->createObjectContainer($object);
}

$manager->addField('sabTest', 'threshold');
$manager->addField('sabTest', 'randomize');
$manager->addField('sabConversion', 'date');
$manager->addField('sabTest', 'resources');
$manager->addField('sabTest', 'templates');
$manager->addField('sabTest', 'archived');
$manager->addField('sabTest', 'smartoptimize');

exit ();
