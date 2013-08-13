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

$xpdo_meta_map['sabTest']= array (
  'package' => 'simpleab',
  'version' => '1.1',
  'table' => 'simpleab_test',
  'fields' => 
  array (
    'name' => NULL,
    'description' => NULL,
    'type' => 'modTemplate',
    'active' => 0,
    'archived' => 0,
    'smartoptimize' => 0,
    'threshold' => 100,
    'randomize' => 25,
    'resources' => NULL,
    'templates' => NULL,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '75',
      'phptype' => 'string',
      'null' => false,
    ),
    'description' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '500',
      'phptype' => 'string',
      'null' => false,
    ),
    'type' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '75',
      'phptype' => 'string',
      'null' => false,
      'default' => 'modTemplate',
    ),
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'bool',
      'null' => false,
      'default' => 0,
    ),
    'archived' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'bool',
      'null' => false,
      'default' => 0,
    ),
    'smartoptimize' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'bool',
      'null' => false,
      'default' => 0,
    ),
    'threshold' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
      'default' => 100,
    ),
    'randomize' => 
    array (
      'dbtype' => 'int',
      'precision' => '3',
      'phptype' => 'integer',
      'null' => false,
      'default' => 25,
    ),
    'resources' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '250',
      'phptype' => 'string',
      'null' => true,
    ),
    'templates' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '250',
      'phptype' => 'string',
      'null' => true,
    ),
  ),
  'composites' => 
  array (
    'Variations' => 
    array (
      'class' => 'sabVariation',
      'cardinality' => 'many',
      'foreign' => 'test',
      'local' => 'id',
      'owner' => 'local',
    ),
    'Conversions' => 
    array (
      'class' => 'sabConversion',
      'cardinality' => 'many',
      'foreign' => 'test',
      'local' => 'id',
      'owner' => 'local',
    ),
  ),
);
