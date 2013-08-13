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

$xpdo_meta_map['sabConversion']= array (
  'package' => 'simpleab',
  'version' => '1.1',
  'table' => 'simpleab_conversions',
  'fields' => 
  array (
    'test' => NULL,
    'variation' => NULL,
    'date' => NULL,
    'value' => NULL,
  ),
  'fieldMeta' => 
  array (
    'test' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
    'variation' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
    'date' => 
    array (
      'dbtype' => 'int',
      'precision' => '8',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
    'value' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
      'attributes' => 'unsigned',
    ),
  ),
  'aggregates' => 
  array (
    'Test' => 
    array (
      'class' => 'sabTest',
      'cardinality' => 'one',
      'foreign' => 'id',
      'local' => 'test',
      'owner' => 'foreign',
    ),
    'Variation' => 
    array (
      'class' => 'sabVariation',
      'cardinality' => 'one',
      'foreign' => 'id',
      'local' => 'variation',
      'owner' => 'foreign',
    ),
  ),
);
