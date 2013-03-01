<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <mark@modx.com>
 *
 * This file is part of SimpleAB
 *
 * SimpleAB is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SimpleAB is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SimpleAB; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
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
    'threshold' => 100,
    'randomize' => 25,
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
