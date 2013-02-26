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

$xpdo_meta_map['sabVariation']= array (
  'package' => 'simpleab',
  'version' => '1.1',
  'table' => 'simpleab_variation',
  'fields' => 
  array (
    'test' => NULL,
    'name' => NULL,
    'description' => NULL,
    'active' => 0,
    'element' => NULL,
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
    'active' => 
    array (
      'dbtype' => 'tinyint',
      'precision' => '1',
      'phptype' => 'bool',
      'null' => false,
      'default' => 0,
    ),
    'element' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => false,
    ),
  ),
  'indexes' => 
  array (
    'test' => 
    array (
      'alias' => 'test',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'test' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'active' => 
    array (
      'alias' => 'active',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'active' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
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
  ),
);
