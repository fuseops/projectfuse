<?php
// created: 2009-08-13 13:22:29
$dictionary["accounts_sms_sms"] = array (
  'true_relationship_type' => 'one-to-many',
  'relationships' => 
  array (
    'accounts_sms_sms' => 
    array (
      'lhs_module' => 'Accounts',
      'lhs_table' => 'accounts',
      'lhs_key' => 'id',
      'rhs_module' => 'SMS_SMS',
      'rhs_table' => 'sms_sms',
      'rhs_key' => 'id',
      'relationship_type' => 'many-to-many',
      'join_table' => 'sms_relations',
      'join_key_lhs' => 'relation_id',
      'join_key_rhs' => 'sms_id',
      'relationship_role_column'=>'relation_type',
      'relationship_role_column_value'=>'accounts'
    ),
  ),
  'table' => 'sms_relations',
  'fields' => 
  array (
    0 => 
    array (
      'name' => 'id',
      'type' => 'varchar',
      'len' => 36,
    ),
    1 => 
    array (
      'name' => 'date_modified',
      'type' => 'datetime',
    ),
    2 => 
    array (
      'name' => 'deleted',
      'type' => 'bool',
      'len' => '1',
      'default' => '0',
      'required' => true,
    ),
    3 => 
    array (
      'name' => 'relation_id',
      'type' => 'varchar',
      'len' => 36,
    ),
    4 => 
    array (
      'name' => 'sms_id',
      'type' => 'varchar',
      'len' => 36,
    ),
    5 => 
    array (
      'name' => 'relation_type',
      'type' => 'varchar',
      'len' => 36,
    ),

  ),
  'indices' => 
  array ()
);
?>
