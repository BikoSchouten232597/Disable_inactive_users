<?php
defined('MOODLE_INTERNAL') || die();

$tasks = array(
    array(
        'classname' => 'local_ldap_connection\task\suspend_inactive_users',
        'blocking' => 0,
        'minute' => '0',
        'hour' => '0',
        'day' => '1',
        'dayofweek' => '*',
        'month' => '*',
    ),
);
