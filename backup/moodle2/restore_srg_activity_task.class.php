<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * The task that provides a complete restore of mod_srg is defined here.
 *
 * @package     mod_srg
 * @category    backup
 * @copyright  2022 Universtity of Stuttgart <kasra.habib@iste.uni-stuttgart.de>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// More information about the backup process: {@link https://docs.moodle.org/dev/Backup_API}.
// More information about the restore process: {@link https://docs.moodle.org/dev/Restore_API}.

require_once($CFG->dirroot . '/mod/srg/backup/moodle2/restore_srg_stepslib.php');

/**
 * Restore task for mod_srg.
 */
class restore_srg_activity_task extends restore_activity_task
{

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings()
    {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps()
    {
        $this->add_step(new restore_srg_activity_structure_step('srg_structure', 'srg.xml'));
    }

    /**
     * Defines the contents in the activity that must be processed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_contents()
    {
        $contents = array();

        $contents[] = new restore_decode_content('srg', array('intro', 'content'), 'srg');

        return $contents;
    }

    /**
     * Defines the decoding rules for links belonging to the activity to be executed by the link decoder.
     *
     * @return array.
     */
    public static function define_decode_rules()
    {
        $rules = array();

        // srg by cm->id
        $rules[] = new restore_decode_rule('SRGVIEWBYID', '/mod/srg/view.php?id=$1', 'course_module');
        // List of srgs in course
        $rules[] = new restore_decode_rule('SRGINDEX', '/mod/srg/index.php?id=$1', 'course');

        return $rules;
    }

    /**
     * Defines the restore log rules that will be applied by the
     * {@see restore_logs_processor} when restoring mod_srg logs. It
     * must return one array of {@see restore_log_rule} objects.
     *
     * @return array.
     */
    public static function define_restore_log_rules()
    {
        $rules = array();

        // $rules[] = new restore_log_rule('srg', 'add', 'view.php?id={course_module}', '{srg}');
        // $rules[] = new restore_log_rule('srg', 'update', 'view.php?id={course_module}', '{srg}');
        // $rules[] = new restore_log_rule('srg', 'view', 'view.php?id={course_module}', '{srg}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course()
    {
        $rules = array();


        // $rules[] = new restore_log_rule('srg', 'view all', 'index?id={course}', null, null, null, 'index.php?id={course}');
        // $rules[] = new restore_log_rule('srg', 'view all', 'index.php?id={course}', null);

        return $rules;
    }

    public function after_restore()
    {
        // Do something at end of restore
    }
}
