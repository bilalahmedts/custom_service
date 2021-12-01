<?php

defined('MOODLE_INTERNAL') || die();
$functions = array(
    'local_custom_service_update_courses_sections' => array(
        'classname' => 'local_custom_service_external',
        'methodname' => 'update_courses_sections',
        'classpath' => 'local/custom_service/externallib.php',
        'description' => 'Update courses sections title in DB',
        'type' => 'write',
        'ajax' => true,
    )
);

$services = array(
    'M-Star Custom Services' => array(
        'functions' => array(
            'local_custom_service_update_courses_sections'
        ),
        'restrictedusers' => 0,
        'enabled' => 1,
        'shortname' => 'custom_web_services'
    )
);