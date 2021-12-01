<?php

use core_completion\progress;
require_once(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/externallib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/course/lib.php');

class local_custom_service_external extends external_api {
    public static function update_courses_sections_parameters() {
        return new external_function_parameters(
            array(
                'courseids' => new external_value(PARAM_TEXT, 'Course Ids')
            )
        );
    }
    public static function update_courses_sections($courseids) {
        global $DB,$CFG;
        require_once($CFG->libdir . '/filelib.php');
        require_once($CFG->dirroot . '/course/lib.php');
        
        $course = $DB->get_record('course', array('id' => $courseids), '*', MUST_EXIST);
        $sections = $DB->get_records('course_sections', array('course' => $courseids));
        
        $count = 0;

        foreach ($sections as $key => $value) {
            $section = $DB->get_record('course_sections', array('id' => $key), '*', MUST_EXIST);

            $data = new stdClass();
            $data->id = $section->id;
            $data->name = $section->summary;
            $data->availability = '{"op":"&","c":[],"showc":[]}';

            //check if section is empty-then update
            if($section->name == NULL){
                $done = course_update_section($course, $section, $data);
            }
            $count ++;
        }
        
        $lti_updated = [
                        'ids'=>$courseids,
                        'message'=>'Success',
                        'updated'=>$count
                        ];
        return $lti_updated;
    }
    public static function update_courses_sections_returns() {
        return new external_single_structure(
                array(
                    'ids' => new external_value(PARAM_TEXT, 'course ids'),
                    'message'=> new external_value(PARAM_TEXT, 'success message'),
                    'updated'=>new external_value(PARAM_TEXT,'Items Updated')
                )
            );
    }

}