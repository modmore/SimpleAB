<?php
/**
 * SimpleAB
 *
 * Copyright 2013 by Mark Hamstra <mark@modx.com>
 *
 * SimpleAB is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SimpleAB is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SimpleAB; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package simpleab
 * @var modX $modx
 */

$action = (isset($_GET['action'])) ? $_GET['action'] : '';
$webAction = ($action == 'web/conversion/log');
if ($webAction) {
    define('MODX_REQP', false);
}

require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

if ($webAction) {
    $_SERVER['HTTP_MODAUTH'] = $modx->user->getUserToken($modx->context->get('key'));
}

$corePath = $modx->getOption('simpleab.core_path',null,$modx->getOption('core_path').'components/simpleab/');
require_once $corePath.'model/simpleab/simpleab.class.php';
$modx->simpleab = new SimpleAB($modx);

$modx->lexicon->load('simpleab:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->simpleab->config,$corePath.'processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
die ($path);
