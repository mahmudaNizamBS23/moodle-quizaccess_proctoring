<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
 * Unit Test for the quizaccess_proctoring plugin.
 *
 * @package    quizaccess_proctoring
 * @copyright  2020 Brain Station 23 <moodle@brainstation-23.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
global $CFG;

use advanced_testcase;

require_once($CFG->dirroot . "/user/lib.php");

/**
 * Unit tests for core_user.
 *
 * @copyright  2018 Adrian Greeve <adrian@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class quizaccess_proctoring_privacy_testcase extends advanced_testcase {

    /**
     * Setup the user, the quiz and ensure that the user is the last user to modify the SEB quiz settings.
     */
    public function setup_test_data() {
        $this->resetAfterTest();

        $this->setAdminUser();

        $this->course = $this->getDataGenerator()->create_course();
        $this->quiz = $this->create_test_quiz($this->course, \quizaccess_seb\settings_provider::USE_SEB_CONFIG_MANUALLY);

        $this->user = $this->getDataGenerator()->create_user();
        $this->setUser($this->user);

        $template = $this->create_template();

        $quizsettings = quiz_settings::get_record(['quizid' => $this->quiz->id]);

        // Modify settings so usermodified is updated. This is the user data we are testing for.
        $quizsettings->set('requiresafeexambrowser', \quizaccess_seb\settings_provider::USE_SEB_TEMPLATE);
        $quizsettings->set('templateid', $template->get('id'));
        $quizsettings->save();

    }

    /**
     * Check that context information is returned correctly.
     */
//    public function test_get_contexts_for_userid() {
//        $this->resetAfterTest();
//        $user = $this->getDataGenerator()->create_user();
//        // Create some other users as well.
////        $user2 = $this->getDataGenerator()->create_user();
////        $user3 = $this->getDataGenerator()->create_user();
//
//        $context = context_user::instance($user->id);
//        $contextlist = provider::get_contexts_for_userid($user->id);
//        var_dump($context, $contextlist);
//        $this->assertEquals($context, $contextlist->current());
//    }

    /**
     * Test that data is exported as expected for a user.
     * @throws dml_exception|coding_exception
     */
//    public function test_export_user_data() {
//        $this->resetAfterTest();
//        $user = $this->getDataGenerator()->create_user([
//            'firstaccess' => 1535760000,
//            'lastaccess' => 1541030400,
//            'currentlogin' => 1541030400,
//        ]);
//        $course = $this->getDataGenerator()->create_course();
//        $context = \context_user::instance($user->id);
//
//        $this->create_data_for_user($user, $course);
//
//        $approvedlist = new approved_contextlist($user, 'quizaccess_proctoring', [$context->id]);
//
//        $writer = writer::with_context($context);
//        provider::export_user_data($approvedlist);
//
//        // Make sure that the password history only returns a count.
//        $history = $writer->get_data([get_string('privacy:passwordhistorypath', 'quizaccess_proctoring')]);
//        $objectcount = new ArrayObject($history);
//        // This object should only have one property.
//        $this->assertCount(1, $objectcount);
//        $this->assertEquals(1, $history->password_history_count);
//
//    }

    /**
     * Test that user data is deleted for one user.
     */
//    public function test_delete_data_for_all_users_in_context() {
//        global $DB;
//        $this->resetAfterTest();
//        $user = $this->getDataGenerator()->create_user([
//            'idnumber' => 'A0023',
//            'emailstop' => 1,
//            'icq' => 'aksdjf98',
//            'phone1' => '555 3257',
//            'institution' => 'test',
//            'department' => 'Science',
//            'city' => 'Perth',
//            'country' => 'au'
//        ]);
//        $user2 = $this->getDataGenerator()->create_user();
//        $course = $this->getDataGenerator()->create_course();
//
//        $this->create_data_for_user($user, $course);
//        $this->create_data_for_user($user2, $course);
//
//        provider::delete_data_for_all_users_in_context(context_user::instance($user->id));
//
//        // These tables should not have any user data for $user. Only for $user2.
//        $records = $DB->get_records('user_password_history');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_password_resets');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_lastaccess');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_devices');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//
//        // Now check that there is still a record for the deleted user, but that non-critical information is removed.
//        $record = $DB->get_record('user', ['id' => $user->id]);
//        $this->assertEmpty($record->idnumber);
//        $this->assertEmpty($record->emailstop);
//        $this->assertEmpty($record->icq);
//        $this->assertEmpty($record->phone1);
//        $this->assertEmpty($record->institution);
//        $this->assertEmpty($record->department);
//        $this->assertEmpty($record->city);
//        $this->assertEmpty($record->country);
//        $this->assertEmpty($record->timezone);
//        $this->assertEmpty($record->timecreated);
//        $this->assertEmpty($record->timemodified);
//        $this->assertEmpty($record->firstnamephonetic);
//        // Check for critical fields.
//        // Deleted should now be 1.
//        $this->assertEquals(1, $record->deleted);
//        $this->assertEquals($user->id, $record->id);
//        $this->assertEquals($user->username, $record->username);
//        $this->assertEquals($user->password, $record->password);
//        $this->assertEquals($user->firstname, $record->firstname);
//        $this->assertEquals($user->lastname, $record->lastname);
//        $this->assertEquals($user->email, $record->email);
//    }

    /**
     * Test that user data is deleted for one user.
     */
//    public function test_delete_data_for_user() {
//        global $DB;
//        $this->resetAfterTest();
//        $user = $this->getDataGenerator()->create_user([
//            'idnumber' => 'A0023',
//            'emailstop' => 1,
//            'icq' => 'aksdjf98',
//            'phone1' => '555 3257',
//            'institution' => 'test',
//            'department' => 'Science',
//            'city' => 'Perth',
//            'country' => 'au'
//        ]);
//        $user2 = $this->getDataGenerator()->create_user();
//        $course = $this->getDataGenerator()->create_course();
//
//        $this->create_data_for_user($user, $course);
//        $this->create_data_for_user($user2, $course);
//
//        // Provide multiple different context to check that only the correct user is deleted.
//        $contexts = [context_user::instance($user->id)->id, context_user::instance($user2->id)->id, context_system::instance()->id];
//        $approvedlist = new approved_contextlist($user, 'core_user', $contexts);
//
//        provider::delete_data_for_user($approvedlist);
//
//        // These tables should not have any user data for $user. Only for $user2.
//        $records = $DB->get_records('user_password_history');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_password_resets');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_lastaccess');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//        $records = $DB->get_records('user_devices');
//        $this->assertCount(1, $records);
//        $data = array_shift($records);
//        $this->assertNotEquals($user->id, $data->userid);
//        $this->assertEquals($user2->id, $data->userid);
//
//        // Now check that there is still a record for the deleted user, but that non-critical information is removed.
//        $record = $DB->get_record('user', ['id' => $user->id]);
//        $this->assertEmpty($record->idnumber);
//        $this->assertEmpty($record->emailstop);
//        $this->assertEmpty($record->icq);
//        $this->assertEmpty($record->phone1);
//        $this->assertEmpty($record->institution);
//        $this->assertEmpty($record->department);
//        $this->assertEmpty($record->city);
//        $this->assertEmpty($record->country);
//        $this->assertEmpty($record->timezone);
//        $this->assertEmpty($record->timecreated);
//        $this->assertEmpty($record->timemodified);
//        $this->assertEmpty($record->firstnamephonetic);
//        // Check for critical fields.
//        // Deleted should now be 1.
//        $this->assertEquals(1, $record->deleted);
//        $this->assertEquals($user->id, $record->id);
//        $this->assertEquals($user->username, $record->username);
//        $this->assertEquals($user->password, $record->password);
//        $this->assertEquals($user->firstname, $record->firstname);
//        $this->assertEquals($user->lastname, $record->lastname);
//        $this->assertEquals($user->email, $record->email);
//    }

    /**
     * Test that only users with a user context are fetched.
     */
//    public function test_get_users_in_context() {
//        $this->resetAfterTest();
//
//        $component = 'core_user';
//        // Create a user.
//        $user = $this->getDataGenerator()->create_user();
//        $usercontext = \context_user::instance($user->id);
//        $userlist = new \core_privacy\local\request\userlist($usercontext, $component);
//
//        // The list of users for user context should return the user.
//        provider::get_users_in_context($userlist);
//        $this->assertCount(1, $userlist);
//        $expected = [$user->id];
//        $actual = $userlist->get_userids();
//        $this->assertEquals($expected, $actual);
//
//        // The list of users for system context should not return any users.
//        $systemcontext = context_system::instance();
//        $userlist = new \core_privacy\local\request\userlist($systemcontext, $component);
//        provider::get_users_in_context($userlist);
//        $this->assertCount(0, $userlist);
//    }

    /**
     * Test that data for users in approved userlist is deleted.
     */
//    public function test_delete_data_for_users() {
//        global $DB;
//
//        $this->resetAfterTest();
//
//        $component = 'core_user';
//
//        // Create user1.
//        $user1 = $this->getDataGenerator()->create_user([
//            'idnumber' => 'A0023',
//            'emailstop' => 1,
//            'icq' => 'aksdjf98',
//            'phone1' => '555 3257',
//            'institution' => 'test',
//            'department' => 'Science',
//            'city' => 'Perth',
//            'country' => 'au'
//        ]);
//        $usercontext1 = \context_user::instance($user1->id);
//        $userlist1 = new \core_privacy\local\request\userlist($usercontext1, $component);
//
//        // Create user2.
//        $user2 = $this->getDataGenerator()->create_user([
//            'idnumber' => 'A0024',
//            'emailstop' => 1,
//            'icq' => 'aksdjf981',
//            'phone1' => '555 3258',
//            'institution' => 'test',
//            'department' => 'Science',
//            'city' => 'Perth',
//            'country' => 'au'
//        ]);
//        $usercontext2 = \context_user::instance($user2->id);
//        $userlist2 = new \core_privacy\local\request\userlist($usercontext2, $component);
//
//        // The list of users for usercontext1 should return user1.
//        provider::get_users_in_context($userlist1);
//        $this->assertCount(1, $userlist1);
//        // The list of users for usercontext2 should return user2.
//        provider::get_users_in_context($userlist2);
//        $this->assertCount(1, $userlist2);
//
//        // Add userlist1 to the approved user list.
//        $approvedlist = new approved_userlist($usercontext1, $component, $userlist1->get_userids());
//        // Delete using delete_data_for_users().
//        provider::delete_data_for_users($approvedlist);
//
//        // Now check that there is still a record for user1 (deleted user), but non-critical information is removed.
//        $record = $DB->get_record('user', ['id' => $user1->id]);
//        $this->assertEmpty($record->idnumber);
//        $this->assertEmpty($record->emailstop);
//        $this->assertEmpty($record->icq);
//        $this->assertEmpty($record->phone1);
//        $this->assertEmpty($record->institution);
//        $this->assertEmpty($record->department);
//        $this->assertEmpty($record->city);
//        $this->assertEmpty($record->country);
//        $this->assertEmpty($record->timezone);
//        $this->assertEmpty($record->timecreated);
//        $this->assertEmpty($record->timemodified);
//        $this->assertEmpty($record->firstnamephonetic);
//        // Check for critical fields.
//        // Deleted should now be 1.
//        $this->assertEquals(1, $record->deleted);
//        $this->assertEquals($user1->id, $record->id);
//        $this->assertEquals($user1->username, $record->username);
//        $this->assertEquals($user1->password, $record->password);
//        $this->assertEquals($user1->firstname, $record->firstname);
//        $this->assertEquals($user1->lastname, $record->lastname);
//        $this->assertEquals($user1->email, $record->email);
//
//        // Now check that the record and information for user2 is still present.
//        $record = $DB->get_record('user', ['id' => $user2->id]);
//        $this->assertNotEmpty($record->idnumber);
//        $this->assertNotEmpty($record->emailstop);
//        $this->assertNotEmpty($record->icq);
//        $this->assertNotEmpty($record->phone1);
//        $this->assertNotEmpty($record->institution);
//        $this->assertNotEmpty($record->department);
//        $this->assertNotEmpty($record->city);
//        $this->assertNotEmpty($record->country);
//        $this->assertNotEmpty($record->timezone);
//        $this->assertNotEmpty($record->timecreated);
//        $this->assertNotEmpty($record->timemodified);
//        $this->assertNotEmpty($record->firstnamephonetic);
//        $this->assertEquals(0, $record->deleted);
//        $this->assertEquals($user2->id, $record->id);
//        $this->assertEquals($user2->username, $record->username);
//        $this->assertEquals($user2->password, $record->password);
//        $this->assertEquals($user2->firstname, $record->firstname);
//        $this->assertEquals($user2->lastname, $record->lastname);
//        $this->assertEquals($user2->email, $record->email);
//    }

    /**
     * Create user data for a user.
     *
     * @param  stdClass $user A user object.
     * @param  stdClass $course A course.
     */
    protected function create_data_for_user($user, $course) {
        global $DB;
        $this->resetAfterTest();
        // Last course access.
        $lastaccess = (object) [
            'userid' => $user->id,
            'courseid' => $course->id,
            'timeaccess' => time() - DAYSECS
        ];
        $DB->insert_record('user_lastaccess', $lastaccess);

        // Password history.
        $history = (object) [
            'userid' => $user->id,
            'hash' => 'HID098djJUU',
            'timecreated' => time()
        ];
        $DB->insert_record('user_password_history', $history);

        // Password resets.
        $passwordreset = (object) [
            'userid' => $user->id,
            'timerequested' => time(),
            'timererequested' => time(),
            'token' => $this->generate_random_string()
        ];
        $DB->insert_record('user_password_resets', $passwordreset);

        // User mobile devices.
        $userdevices = (object) [
            'userid' => $user->id,
            'appid' => 'com.moodle.moodlemobile',
            'name' => 'occam',
            'model' => 'Nexus 4',
            'platform' => 'Android',
            'version' => '4.2.2',
            'pushid' => 'kishUhd',
            'uuid' => 'KIhud7s',
            'timecreated' => time(),
            'timemodified' => time()
        ];
        $DB->insert_record('user_devices', $userdevices);

        // Course request.
        $courserequest = (object) [
            'fullname' => 'Test Course',
            'shortname' => 'TC',
            'summary' => 'Summary of course',
            'summaryformat' => 1,
            'category' => 1,
            'reason' => 'Because it would be nice.',
            'requester' => $user->id,
            'password' => ''
        ];
        $DB->insert_record('course_request', $courserequest);

        // User session table data.
        $usersessions = (object) [
            'state' => 0,
            'sid' => $this->generate_random_string(), // Needs a unique id.
            'userid' => $user->id,
            'sessdata' => 'Nothing',
            'timecreated' => time(),
            'timemodified' => time(),
            'firstip' => '0.0.0.0',
            'lastip' => '0.0.0.0'
        ];
        $DB->insert_record('sessions', $usersessions);
    }

    /**
     * Create a random string.
     *
     * @param  integer $length length of the string to generate.
     * @return string A random string.
     */
    protected function generate_random_string($length = 6) {
        $response = '';
        $source = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        if ($length > 0) {

            $response = '';
            $source = str_split($source, 1);

            for ($i = 1; $i <= $length; $i++) {
                $num = mt_rand(1, count($source));
                $response .= $source[$num - 1];
            }
        }

        return $response;
    }
}
