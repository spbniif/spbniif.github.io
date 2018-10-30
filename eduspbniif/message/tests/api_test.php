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
 * Test message API.
 *
 * @package core_message
 * @category test
 * @copyright 2016 Mark Nelson <markn@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

require_once($CFG->dirroot . '/message/tests/messagelib_test.php');

/**
 * Test message API.
 *
 * @package core_message
 * @category test
 * @copyright 2016 Mark Nelson <markn@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_message_api_testcase extends core_message_messagelib_testcase {

    public function test_mark_all_read_for_user_touser() {
        $sender = $this->getDataGenerator()->create_user(array('firstname' => 'Test1', 'lastname' => 'User1'));
        $recipient = $this->getDataGenerator()->create_user(array('firstname' => 'Test2', 'lastname' => 'User2'));

        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient);
        $this->send_fake_message($sender, $recipient);
        $this->send_fake_message($sender, $recipient);

        \core_message\api::mark_all_read_for_user($recipient->id);
        $this->assertDebuggingCalled();
        $this->assertEquals(message_count_unread_messages($recipient), 0);
    }

    public function test_mark_all_read_for_user_touser_with_fromuser() {
        $sender1 = $this->getDataGenerator()->create_user(array('firstname' => 'Test1', 'lastname' => 'User1'));
        $sender2 = $this->getDataGenerator()->create_user(array('firstname' => 'Test3', 'lastname' => 'User3'));
        $recipient = $this->getDataGenerator()->create_user(array('firstname' => 'Test2', 'lastname' => 'User2'));

        $this->send_fake_message($sender1, $recipient, 'Notification', 1);
        $this->send_fake_message($sender1, $recipient, 'Notification', 1);
        $this->send_fake_message($sender1, $recipient, 'Notification', 1);
        $this->send_fake_message($sender1, $recipient);
        $this->send_fake_message($sender1, $recipient);
        $this->send_fake_message($sender1, $recipient);
        $this->send_fake_message($sender2, $recipient, 'Notification', 1);
        $this->send_fake_message($sender2, $recipient, 'Notification', 1);
        $this->send_fake_message($sender2, $recipient, 'Notification', 1);
        $this->send_fake_message($sender2, $recipient);
        $this->send_fake_message($sender2, $recipient);
        $this->send_fake_message($sender2, $recipient);

        \core_message\api::mark_all_read_for_user($recipient->id, $sender1->id);
        $this->assertDebuggingCalled();
        $this->assertEquals(message_count_unread_messages($recipient), 3);
    }

    public function test_mark_all_read_for_user_touser_with_type() {
        $sender = $this->getDataGenerator()->create_user(array('firstname' => 'Test1', 'lastname' => 'User1'));
        $recipient = $this->getDataGenerator()->create_user(array('firstname' => 'Test2', 'lastname' => 'User2'));

        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient, 'Notification', 1);
        $this->send_fake_message($sender, $recipient);
        $this->send_fake_message($sender, $recipient);
        $this->send_fake_message($sender, $recipient);

        \core_message\api::mark_all_read_for_user($recipient->id, 0, MESSAGE_TYPE_NOTIFICATION);
        $this->assertDebuggingCalled();
        $this->assertEquals(message_count_unread_messages($recipient), 3);

        \core_message\api::mark_all_read_for_user($recipient->id, 0, MESSAGE_TYPE_MESSAGE);
        $this->assertDebuggingCalled();
        $this->assertEquals(message_count_unread_messages($recipient), 0);
    }

    /**
     * Test count_blocked_users.
     */
    public function test_count_blocked_users() {
        global $USER;

        // Set this user as the admin.
        $this->setAdminUser();

        // Create user to add to the admin's block list.
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        $this->assertEquals(0, \core_message\api::count_blocked_users());

        // Add 1 blocked user to admin's blocked user list.
        \core_message\api::block_user($USER->id, $user1->id);

        $this->assertEquals(0, \core_message\api::count_blocked_users($user1));
        $this->assertEquals(1, \core_message\api::count_blocked_users());
    }

    /**
     * Tests searching users in a course.
     */
    public function test_search_users_in_course() {
        // Create some users.
        $user1 = new stdClass();
        $user1->firstname = 'User';
        $user1->lastname = 'One';
        $user1 = self::getDataGenerator()->create_user($user1);

        // The person doing the search.
        $this->setUser($user1);

        // Second user is going to have their last access set to now, so they are online.
        $user2 = new stdClass();
        $user2->firstname = 'User';
        $user2->lastname = 'Two';
        $user2->lastaccess = time();
        $user2 = self::getDataGenerator()->create_user($user2);

        // Block the second user.
        \core_message\api::block_user($user1->id, $user2->id);

        $user3 = new stdClass();
        $user3->firstname = 'User';
        $user3->lastname = 'Three';
        $user3 = self::getDataGenerator()->create_user($user3);

        // Create a course.
        $course1 = new stdClass();
        $course1->fullname = 'Course';
        $course1->shortname = 'One';
        $course1 = $this->getDataGenerator()->create_course($course1);

        // Enrol the searcher and one user in the course.
        $this->getDataGenerator()->enrol_user($user1->id, $course1->id);
        $this->getDataGenerator()->enrol_user($user2->id, $course1->id);

        // Perform a search.
        $results = \core_message\api::search_users_in_course($user1->id, $course1->id, 'User');

        $this->assertEquals(1, count($results));

        $user = $results[0];
        $this->assertEquals($user2->id, $user->userid);
        $this->assertEquals(fullname($user2), $user->fullname);
        $this->assertFalse($user->ismessaging);
        $this->assertNull($user->lastmessage);
        $this->assertNull($user->messageid);
        $this->assertNull($user->isonline);
        $this->assertFalse($user->isread);
        $this->assertTrue($user->isblocked);
        $this->assertNull($user->unreadcount);
    }

    /**
     * Tests searching users.
     */
    public function test_search_users() {
        global $DB;

        // Create some users.
        $user1 = new stdClass();
        $user1->firstname = 'User';
        $user1->lastname = 'One';
        $user1 = self::getDataGenerator()->create_user($user1);

        // Set as the user performing the search.
        $this->setUser($user1);

        $user2 = new stdClass();
        $user2->firstname = 'User search';
        $user2->lastname = 'Two';
        $user2 = self::getDataGenerator()->create_user($user2);

        $user3 = new stdClass();
        $user3->firstname = 'User search';
        $user3->lastname = 'Three';
        $user3 = self::getDataGenerator()->create_user($user3);

        $user4 = new stdClass();
        $user4->firstname = 'User';
        $user4->lastname = 'Four';
        $user4 = self::getDataGenerator()->create_user($user4);

        $user5 = new stdClass();
        $user5->firstname = 'User search';
        $user5->lastname = 'Five';
        $user5 = self::getDataGenerator()->create_user($user5);

        $user6 = new stdClass();
        $user6->firstname = 'User';
        $user6->lastname = 'Six';
        $user6 = self::getDataGenerator()->create_user($user6);

        // Create some courses.
        $course1 = new stdClass();
        $course1->fullname = 'Course search';
        $course1->shortname = 'One';
        $course1 = $this->getDataGenerator()->create_course($course1);

        $course2 = new stdClass();
        $course2->fullname = 'Course';
        $course2->shortname = 'Two';
        $course2 = $this->getDataGenerator()->create_course($course2);

        $course3 = new stdClass();
        $course3->fullname = 'Course';
        $course3->shortname = 'Three search';
        $course3 = $this->getDataGenerator()->create_course($course3);

        $course4 = new stdClass();
        $course4->fullname = 'Course Four';
        $course4->shortname = 'CF100';
        $course4 = $this->getDataGenerator()->create_course($course4);

        $course5 = new stdClass();
        $course5->fullname = 'Course';
        $course5->shortname = 'Five search';
        $course5 = $this->getDataGenerator()->create_course($course5);

        $role = $DB->get_record('role', ['shortname' => 'student']);
        $this->getDataGenerator()->enrol_user($user1->id, $course1->id, $role->id);
        $this->getDataGenerator()->enrol_user($user1->id, $course2->id, $role->id);
        $this->getDataGenerator()->enrol_user($user1->id, $course3->id, $role->id);
        $this->getDataGenerator()->enrol_user($user1->id, $course5->id, $role->id);

        // Add some users as contacts.
        \core_message\api::add_contact($user1->id, $user2->id);
        \core_message\api::add_contact($user1->id, $user3->id);
        \core_message\api::add_contact($user1->id, $user4->id);

        // Remove the viewparticipants capability from one of the courses.
        $course5context = context_course::instance($course5->id);
        assign_capability('moodle/course:viewparticipants', CAP_PROHIBIT, $role->id, $course5context->id);

        // Perform a search.
        list($contacts, $courses, $noncontacts) = \core_message\api::search_users($user1->id, 'search');

        // Check that we retrieved the correct contacts.
        $this->assertEquals(2, count($contacts));
        $this->assertEquals($user3->id, $contacts[0]->userid);
        $this->assertEquals($user2->id, $contacts[1]->userid);

        // Check that we retrieved the correct courses.
        $this->assertEquals(2, count($courses));
        $this->assertEquals($course3->id, $courses[0]->id);
        $this->assertEquals($course1->id, $courses[1]->id);

        // Check that we retrieved the correct non-contacts.
        $this->assertEquals(1, count($noncontacts));
        $this->assertEquals($user5->id, $noncontacts[0]->userid);
    }

    /**
     * Tests searching messages.
     */
    public function test_search_messages() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user3, $user1, 'Don\'t block me.', 0, $time);
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Block user 3.
        \core_message\api::block_user($user1->id, $user3->id);

        // Perform a search.
        $messages = \core_message\api::search_messages($user1->id, 'o');

        // Confirm the data is correct.
        $this->assertEquals(3, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];
        $message3 = $messages[2];

        $this->assertEquals($user2->id, $message1->userid);
        $this->assertEquals($user2->id, $message1->useridfrom);
        $this->assertEquals(fullname($user2), $message1->fullname);
        $this->assertTrue($message1->ismessaging);
        $this->assertEquals('Word.', $message1->lastmessage);
        $this->assertNotEmpty($message1->messageid);
        $this->assertNull($message1->isonline);
        $this->assertFalse($message1->isread);
        $this->assertFalse($message1->isblocked);
        $this->assertNull($message1->unreadcount);

        $this->assertEquals($user2->id, $message2->userid);
        $this->assertEquals($user1->id, $message2->useridfrom);
        $this->assertEquals(fullname($user2), $message2->fullname);
        $this->assertTrue($message2->ismessaging);
        $this->assertEquals('Yo!', $message2->lastmessage);
        $this->assertNotEmpty($message2->messageid);
        $this->assertNull($message2->isonline);
        $this->assertTrue($message2->isread);
        $this->assertFalse($message2->isblocked);
        $this->assertNull($message2->unreadcount);

        $this->assertEquals($user3->id, $message3->userid);
        $this->assertEquals($user3->id, $message3->useridfrom);
        $this->assertEquals(fullname($user3), $message3->fullname);
        $this->assertTrue($message3->ismessaging);
        $this->assertEquals('Don\'t block me.', $message3->lastmessage);
        $this->assertNotEmpty($message3->messageid);
        $this->assertNull($message3->isonline);
        $this->assertFalse($message3->isread);
        $this->assertTrue($message3->isblocked);
        $this->assertNull($message3->unreadcount);
    }

    /**
     * Test verifying that favourited conversations can be retrieved.
     */
    public function test_get_favourite_conversations() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // No conversations yet.
        $this->assertEquals([], \core_message\api::get_conversations($user1->id));

        // Create some conversations for user1.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $messageid1 = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $messageid2 = $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        $this->send_fake_message($user1, $user4, 'Hey mate, you see the new messaging UI in Moodle?', 0, $time + 9);
        $this->send_fake_message($user4, $user1, 'Yah brah, it\'s pretty rad.', 0, $time + 10);
        $messageid3 = $this->send_fake_message($user1, $user4, 'Dope.', 0, $time + 11);

        // Favourite the first 2 conversations for user1.
        $convoids = [];
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user3->id]);
        $user1context = context_user::instance($user1->id);
        $service = \core_favourites\service_factory::get_service_for_user_context($user1context);
        foreach ($convoids as $convoid) {
            $service->create_favourite('core_message', 'message_conversations', $convoid, $user1context);
        }

        // We should have 3 conversations.
        $this->assertCount(3, \core_message\api::get_conversations($user1->id));

        // And 2 favourited conversations.
        $conversations = \core_message\api::get_conversations($user1->id, 0, 20, null, true);
        $this->assertCount(2, $conversations);
    }

    /**
     * Tests retrieving favourite conversations with a limit and offset to ensure pagination works correctly.
     */
    public function test_get_favourite_conversations_limit_offset() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // No conversations yet.
        $this->assertEquals([], \core_message\api::get_conversations($user1->id));

        // Create some conversations for user1.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $messageid1 = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $messageid2 = $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        $this->send_fake_message($user1, $user4, 'Hey mate, you see the new messaging UI in Moodle?', 0, $time + 9);
        $this->send_fake_message($user4, $user1, 'Yah brah, it\'s pretty rad.', 0, $time + 10);
        $messageid3 = $this->send_fake_message($user1, $user4, 'Dope.', 0, $time + 11);

        // Favourite the all conversations for user1.
        $convoids = [];
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user3->id]);
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user4->id]);
        $user1context = context_user::instance($user1->id);
        $service = \core_favourites\service_factory::get_service_for_user_context($user1context);
        foreach ($convoids as $convoid) {
            $service->create_favourite('core_message', 'message_conversations', $convoid, $user1context);
        }

        // Get all records, using offset 0 and large limit.
        $this->assertCount(2, \core_message\api::get_conversations($user1->id, 1, 10, null, true));

        // Now, get 10 conversations starting at the second record. We should see 2 conversations.
        $this->assertCount(2, \core_message\api::get_conversations($user1->id, 1, 10, null, true));

        // Now, try to get favourited conversations using an invalid offset.
        $this->assertCount(0, \core_message\api::get_conversations($user1->id, 4, 10, null, true));
    }

    /**
     * Tests retrieving favourite conversations when a conversation contains a deleted user.
     */
    public function test_get_favourite_conversations_with_deleted_user() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        // Favourite the all conversations for user1.
        $convoids = [];
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $convoids[] = \core_message\api::get_conversation_between_users([$user1->id, $user3->id]);
        $user1context = context_user::instance($user1->id);
        $service = \core_favourites\service_factory::get_service_for_user_context($user1context);
        foreach ($convoids as $convoid) {
            $service->create_favourite('core_message', 'message_conversations', $convoid, $user1context);
        }

        // Delete the second user.
        delete_user($user2);

        // Retrieve the conversations.
        $conversations = \core_message\api::get_conversations($user1->id, 0, 20, null, true);

        // We should only have one conversation because the other user was deleted.
        $this->assertCount(1, $conversations);

        // Confirm the conversation is from the non-deleted user.
        $conversation = reset($conversations);
        $this->assertEquals($user3->id, $conversation->userid);
    }

    /**
     * Test confirming that conversations can be marked as favourites.
     */
    public function test_set_favourite_conversation() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        // Favourite the first conversation as user 1.
        $conversationid1 = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        \core_message\api::set_favourite_conversation($conversationid1, $user1->id);

        // Verify we have a single favourite conversation a user 1.
        $this->assertCount(1, \core_message\api::get_conversations($user1->id, 0, 20, null, true));

        // Verify we have no favourites as user2, despite being a member in that conversation.
        $this->assertCount(0, \core_message\api::get_conversations($user2->id, 0, 20, null, true));

        // Try to favourite the same conversation again.
        $this->expectException(\moodle_exception::class);
        \core_message\api::set_favourite_conversation($conversationid1, $user1->id);
    }

    /**
     * Test verifying that trying to mark a non-existent conversation as a favourite, results in an exception.
     */
    public function test_set_favourite_conversation_nonexistent_conversation() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        // Try to favourite a non-existent conversation.
        $this->expectException(\moodle_exception::class);
        \core_message\api::set_favourite_conversation(0, $user1->id);
    }

    /**
     * Test verifying that a conversation cannot be marked as favourite unless the user is a member of that conversation.
     */
    public function test_set_favourite_conversation_non_member() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        // Try to favourite the first conversation as user 3, who is not a member.
        $conversationid1 = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $this->expectException(\moodle_exception::class);
        \core_message\api::set_favourite_conversation($conversationid1, $user3->id);
    }

    /**
     * Test confirming that those conversations marked as favourites can be unfavourited.
     */
    public function test_unset_favourite_conversation() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        // Favourite the first conversation as user 1 and the second as user 3.
        $conversationid1 = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $conversationid2 = \core_message\api::get_conversation_between_users([$user1->id, $user3->id]);
        \core_message\api::set_favourite_conversation($conversationid1, $user1->id);
        \core_message\api::set_favourite_conversation($conversationid2, $user3->id);

        // Verify we have a single favourite conversation for both user 1 and user 3.
        $this->assertCount(1, \core_message\api::get_conversations($user1->id, 0, 20, null, true));
        $this->assertCount(1, \core_message\api::get_conversations($user3->id, 0, 20, null, true));

        // Now unfavourite the conversation as user 1.
        \core_message\api::unset_favourite_conversation($conversationid1, $user1->id);

        // Verify we have a single favourite conversation user 3 only, and none for user1.
        $this->assertCount(1, \core_message\api::get_conversations($user3->id, 0, 20, null, true));
        $this->assertCount(0, \core_message\api::get_conversations($user1->id, 0, 20, null, true));

        // Try to favourite the same conversation again as user 1.
        $this->expectException(\moodle_exception::class);
        \core_message\api::unset_favourite_conversation($conversationid1, $user1->id);
    }

    /**
     * Test verifying that a valid conversation cannot be unset as a favourite if it's not marked as a favourite.
     */
    public function test_unset_favourite_conversation_not_favourite() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Now try to unfavourite the conversation as user 1.
        $conversationid1 = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        $this->expectException(\moodle_exception::class);
        \core_message\api::unset_favourite_conversation($conversationid1, $user1->id);
    }

    /**
     * Test verifying that a non-existent conversation cannot be unset as a favourite.
     */
    public function test_unset_favourite_conversation_non_existent_conversation() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();

        // Now try to unfavourite the conversation as user 1.
        $this->expectException(\moodle_exception::class);
        \core_message\api::unset_favourite_conversation(0, $user1->id);
    }

    /**
     * Tests retrieving conversations.
     */
    public function test_get_conversations() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // No conversations yet.
        $this->assertEquals([], \core_message\api::get_conversations($user1->id));

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $messageid1 = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $messageid2 = $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        $this->send_fake_message($user1, $user4, 'Hey mate, you see the new messaging UI in Moodle?', 0, $time + 9);
        $this->send_fake_message($user4, $user1, 'Yah brah, it\'s pretty rad.', 0, $time + 10);
        $messageid3 = $this->send_fake_message($user1, $user4, 'Dope.', 0, $time + 11);

        // Retrieve the conversations.
        $conversations = \core_message\api::get_conversations($user1->id);

        // Confirm the data is correct.
        $this->assertEquals(3, count($conversations));

        $message1 = array_shift($conversations);
        $message2 = array_shift($conversations);
        $message3 = array_shift($conversations);

        $this->assertEquals($user4->id, $message1->userid);
        $this->assertEquals($user1->id, $message1->useridfrom);
        $this->assertTrue($message1->ismessaging);
        $this->assertEquals('Dope.', $message1->lastmessage);
        $this->assertEquals($messageid3, $message1->messageid);
        $this->assertNull($message1->isonline);
        $this->assertFalse($message1->isread);
        $this->assertFalse($message1->isblocked);
        $this->assertEquals(1, $message1->unreadcount);

        $this->assertEquals($user3->id, $message2->userid);
        $this->assertEquals($user3->id, $message2->useridfrom);
        $this->assertTrue($message2->ismessaging);
        $this->assertEquals('Cool.', $message2->lastmessage);
        $this->assertEquals($messageid2, $message2->messageid);
        $this->assertNull($message2->isonline);
        $this->assertFalse($message2->isread);
        $this->assertFalse($message2->isblocked);
        $this->assertEquals(2, $message2->unreadcount);

        $this->assertEquals($user2->id, $message3->userid);
        $this->assertEquals($user2->id, $message3->useridfrom);
        $this->assertTrue($message3->ismessaging);
        $this->assertEquals('Word.', $message3->lastmessage);
        $this->assertEquals($messageid1, $message3->messageid);
        $this->assertNull($message3->isonline);
        $this->assertFalse($message3->isread);
        $this->assertFalse($message3->isblocked);
        $this->assertEquals(2, $message3->unreadcount);
    }

    /**
     * Tests retrieving conversations with a limit and offset to ensure pagination works correctly.
     */
    public function test_get_conversations_limit_offset() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $messageid1 = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $messageid2 = $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        $this->send_fake_message($user1, $user4, 'Hey mate, you see the new messaging UI in Moodle?', 0, $time + 9);
        $this->send_fake_message($user4, $user1, 'Yah brah, it\'s pretty rad.', 0, $time + 10);
        $messageid3 = $this->send_fake_message($user1, $user4, 'Dope.', 0, $time + 11);

        // Retrieve the conversations.
        $conversations = \core_message\api::get_conversations($user1->id, 1, 1);

        // We should only have one conversation because of the limit.
        $this->assertCount(1, $conversations);

        $conversation = array_shift($conversations);

        $this->assertEquals($user3->id, $conversation->userid);
        $this->assertEquals($user3->id, $conversation->useridfrom);
        $this->assertTrue($conversation->ismessaging);
        $this->assertEquals('Cool.', $conversation->lastmessage);
        $this->assertEquals($messageid2, $conversation->messageid);
        $this->assertNull($conversation->isonline);
        $this->assertFalse($conversation->isread);
        $this->assertFalse($conversation->isblocked);
        $this->assertEquals(2, $conversation->unreadcount);

        // Retrieve the next conversation.
        $conversations = \core_message\api::get_conversations($user1->id, 2, 1);

        // We should only have one conversation because of the limit.
        $this->assertCount(1, $conversations);

        $conversation = array_shift($conversations);

        $this->assertEquals($user2->id, $conversation->userid);
        $this->assertEquals($user2->id, $conversation->useridfrom);
        $this->assertTrue($conversation->ismessaging);
        $this->assertEquals('Word.', $conversation->lastmessage);
        $this->assertEquals($messageid1, $conversation->messageid);
        $this->assertNull($conversation->isonline);
        $this->assertFalse($conversation->isread);
        $this->assertFalse($conversation->isblocked);
        $this->assertEquals(2, $conversation->unreadcount);

        // Ask for an offset that doesn't exist.
        $conversations = \core_message\api::get_conversations($user1->id, 4, 1);

        // We should not get any conversations back.
        $this->assertCount(0, $conversations);
    }

    /**
     * Tests retrieving conversations when a conversation contains a deleted user.
     */
    public function test_get_conversations_with_deleted_user() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth, have some different conversations with different users.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $this->send_fake_message($user1, $user3, 'Booyah', 0, $time + 5);
        $this->send_fake_message($user3, $user1, 'Whaaat?', 0, $time + 6);
        $this->send_fake_message($user1, $user3, 'Nothing.', 0, $time + 7);
        $this->send_fake_message($user3, $user1, 'Cool.', 0, $time + 8);

        // Delete the second user.
        delete_user($user2);

        // Retrieve the conversations.
        $conversations = \core_message\api::get_conversations($user1->id);

        // We should only have one conversation because the other user was deleted.
        $this->assertCount(1, $conversations);

        // Confirm the conversation is from the non-deleted user.
        $conversation = reset($conversations);
        $this->assertEquals($user3->id, $conversation->userid);
    }

   /**
    * The data provider for get_conversations_mixed.
    *
    * This provides sets of data to for testing.
    * @return array
    */
   public function get_conversations_mixed_provider() {
       return array(
            'Test that conversations with messages contacts is correctly ordered.' => array(
                'users' => array(
                    'user1',
                    'user2',
                    'user3',
                ),
                'contacts' => array(
                ),
                'messages' => array(
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S1',
                    ),
                    array(
                        'from'          => 'user2',
                        'to'            => 'user1',
                        'state'         => 'unread',
                        'subject'       => 'S2',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'timecreated'   => 0,
                        'subject'       => 'S3',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user3',
                        'state'         => 'read',
                        'timemodifier'  => 1,
                        'subject'       => 'S4',
                    ),
                    array(
                        'from'          => 'user3',
                        'to'            => 'user1',
                        'state'         => 'read',
                        'timemodifier'  => 1,
                        'subject'       => 'S5',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user3',
                        'state'         => 'read',
                        'timecreated'   => 0,
                        'subject'       => 'S6',
                    ),
                ),
                'expectations' => array(
                    'user1' => array(
                        // User1 has conversed most recently with user3. The most recent message is M5.
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user3',
                            'subject'           => 'S5',
                            'unreadcount'       => 0,
                        ),
                        // User1 has also conversed with user2. The most recent message is S2.
                        array(
                            'messageposition'   => 1,
                            'with'              => 'user2',
                            'subject'           => 'S2',
                            'unreadcount'       => 1,
                        ),
                    ),
                    'user2' => array(
                        // User2 has only conversed with user1. Their most recent shared message was S2.
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S2',
                            'unreadcount'       => 2,
                        ),
                    ),
                    'user3' => array(
                        // User3 has only conversed with user1. Their most recent shared message was S5.
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S5',
                            'unreadcount'       => 0,
                        ),
                    ),
                ),
            ),
            'Test that users with contacts and messages to self work as expected' => array(
                'users' => array(
                    'user1',
                    'user2',
                    'user3',
                ),
                'contacts' => array(
                    'user1' => array(
                        'user2' => 0,
                        'user3' => 0,
                    ),
                    'user2' => array(
                        'user3' => 0,
                    ),
                ),
                'messages' => array(
                    array(
                        'from'          => 'user1',
                        'to'            => 'user1',
                        'state'         => 'unread',
                        'subject'       => 'S1',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user1',
                        'state'         => 'unread',
                        'subject'       => 'S2',
                    ),
                ),
                'expectations' => array(
                    'user1' => array(
                        // User1 has conversed most recently with user1. The most recent message is S2.
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S2',
                            'unreadcount'       => 0, // Messages sent to and from the same user are counted as read.
                        ),
                    ),
                ),
            ),
            'Test conversations with a single user, where some messages are read and some are not.' => array(
                'users' => array(
                    'user1',
                    'user2',
                ),
                'contacts' => array(
                ),
                'messages' => array(
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'read',
                        'subject'       => 'S1',
                    ),
                    array(
                        'from'          => 'user2',
                        'to'            => 'user1',
                        'state'         => 'read',
                        'subject'       => 'S2',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'timemodifier'  => 1,
                        'subject'       => 'S3',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'timemodifier'  => 1,
                        'subject'       => 'S4',
                    ),
                ),
                'expectations' => array(
                    // The most recent message between user1 and user2 was S4.
                    'user1' => array(
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user2',
                            'subject'           => 'S4',
                            'unreadcount'       => 0,
                        ),
                    ),
                    'user2' => array(
                        // The most recent message between user1 and user2 was S4.
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S4',
                            'unreadcount'       => 2,
                        ),
                    ),
                ),
            ),
            'Test conversations with a single user, where some messages are read and some are not, and messages ' .
            'are out of order' => array(
            // This can happen through a combination of factors including multi-master DB replication with messages
            // read somehow (e.g. API).
                'users' => array(
                    'user1',
                    'user2',
                ),
                'contacts' => array(
                ),
                'messages' => array(
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'read',
                        'subject'       => 'S1',
                        'timemodifier'  => 1,
                    ),
                    array(
                        'from'          => 'user2',
                        'to'            => 'user1',
                        'state'         => 'read',
                        'subject'       => 'S2',
                        'timemodifier'  => 2,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S3',
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S4',
                    ),
                ),
                'expectations' => array(
                    // The most recent message between user1 and user2 was S2, even though later IDs have not been read.
                    'user1' => array(
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user2',
                            'subject'           => 'S2',
                            'unreadcount'       => 0,
                        ),
                    ),
                    'user2' => array(
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S2',
                            'unreadcount'       => 2
                        ),
                    ),
                ),
            ),
            'Test unread message count is correct for both users' => array(
                'users' => array(
                    'user1',
                    'user2',
                ),
                'contacts' => array(
                ),
                'messages' => array(
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'read',
                        'subject'       => 'S1',
                        'timemodifier'  => 1,
                    ),
                    array(
                        'from'          => 'user2',
                        'to'            => 'user1',
                        'state'         => 'read',
                        'subject'       => 'S2',
                        'timemodifier'  => 2,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'read',
                        'subject'       => 'S3',
                        'timemodifier'  => 3,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'read',
                        'subject'       => 'S4',
                        'timemodifier'  => 4,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S5',
                        'timemodifier'  => 5,
                    ),
                    array(
                        'from'          => 'user2',
                        'to'            => 'user1',
                        'state'         => 'unread',
                        'subject'       => 'S6',
                        'timemodifier'  => 6,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S7',
                        'timemodifier'  => 7,
                    ),
                    array(
                        'from'          => 'user1',
                        'to'            => 'user2',
                        'state'         => 'unread',
                        'subject'       => 'S8',
                        'timemodifier'  => 8,
                    ),
                ),
                'expectations' => array(
                    // The most recent message between user1 and user2 was S2, even though later IDs have not been read.
                    'user1' => array(
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user2',
                            'subject'           => 'S8',
                            'unreadcount'       => 1,
                        ),
                    ),
                    'user2' => array(
                        array(
                            'messageposition'   => 0,
                            'with'              => 'user1',
                            'subject'           => 'S8',
                            'unreadcount'       => 3,
                        ),
                    ),
                ),
            ),
        );
    }

    /**
     * Test get_conversations with a mixture of messages.
     *
     * @dataProvider get_conversations_mixed_provider
     * @param array $usersdata The list of users to create for this test.
     * @param array $messagesdata The list of messages to create.
     * @param array $expectations The list of expected outcomes.
     */
    public function test_get_conversations_mixed($usersdata, $contacts, $messagesdata, $expectations) {
        global $DB;

        // Create all of the users.
        $users = array();
        foreach ($usersdata as $username) {
            $users[$username] = $this->getDataGenerator()->create_user(array('username' => $username));
        }

        foreach ($contacts as $username => $contact) {
            foreach ($contact as $contactname => $blocked) {
                $record = new stdClass();
                $record->userid     = $users[$username]->id;
                $record->contactid  = $users[$contactname]->id;
                $record->blocked    = $blocked;
                $record->id = $DB->insert_record('message_contacts', $record);
            }
        }

        $defaulttimecreated = time();
        foreach ($messagesdata as $messagedata) {
            $from       = $users[$messagedata['from']];
            $to         = $users[$messagedata['to']];
            $subject    = $messagedata['subject'];

            if (isset($messagedata['state']) && $messagedata['state'] == 'unread') {
                $messageid = $this->send_fake_message($from, $to, $subject);
            } else {
                // If there is no state, or the state is not 'unread', assume the message is read.
                $messageid = message_post_message($from, $to, $subject, FORMAT_PLAIN);
            }

            $updatemessage = new stdClass();
            $updatemessage->id = $messageid;
            if (isset($messagedata['timecreated'])) {
                $updatemessage->timecreated = $messagedata['timecreated'];
            } else if (isset($messagedata['timemodifier'])) {
                $updatemessage->timecreated = $defaulttimecreated + $messagedata['timemodifier'];
            } else {
                $updatemessage->timecreated = $defaulttimecreated;
            }

            $DB->update_record('messages', $updatemessage);
        }

        foreach ($expectations as $username => $data) {
            // Get the recent conversations for the specified user.
            $user = $users[$username];
            $conversations = array_values(\core_message\api::get_conversations($user->id));
            foreach ($data as $expectation) {
                $otheruser = $users[$expectation['with']];
                $conversation = $conversations[$expectation['messageposition']];
                $this->assertEquals($otheruser->id, $conversation->userid);
                $this->assertEquals($expectation['subject'], $conversation->lastmessage);
                $this->assertEquals($expectation['unreadcount'], $conversation->unreadcount);
            }
        }
    }

    /**
     * Tests retrieving contacts.
     */
    public function test_get_contacts() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();

        // Set as the user.
        $this->setUser($user1);

        $user2 = new stdClass();
        $user2->firstname = 'User';
        $user2->lastname = 'A';
        $user2 = self::getDataGenerator()->create_user($user2);

        $user3 = new stdClass();
        $user3->firstname = 'User';
        $user3->lastname = 'B';
        $user3 = self::getDataGenerator()->create_user($user3);

        $user4 = new stdClass();
        $user4->firstname = 'User';
        $user4->lastname = 'C';
        $user4 = self::getDataGenerator()->create_user($user4);

        $user5 = new stdClass();
        $user5->firstname = 'User';
        $user5->lastname = 'D';
        $user5 = self::getDataGenerator()->create_user($user5);

        // Add some users as contacts.
        \core_message\api::add_contact($user1->id, $user2->id);
        \core_message\api::add_contact($user1->id, $user3->id);
        \core_message\api::add_contact($user1->id, $user4->id);

        // Retrieve the contacts.
        $contacts = \core_message\api::get_contacts($user1->id);

        // Confirm the data is correct.
        $this->assertEquals(3, count($contacts));
        usort($contacts, ['static', 'sort_contacts']);

        $contact1 = $contacts[0];
        $contact2 = $contacts[1];
        $contact3 = $contacts[2];

        $this->assertEquals($user2->id, $contact1->userid);
        $this->assertEmpty($contact1->useridfrom);
        $this->assertFalse($contact1->ismessaging);
        $this->assertNull($contact1->lastmessage);
        $this->assertNull($contact1->messageid);
        $this->assertNull($contact1->isonline);
        $this->assertFalse($contact1->isread);
        $this->assertFalse($contact1->isblocked);
        $this->assertNull($contact1->unreadcount);

        $this->assertEquals($user3->id, $contact2->userid);
        $this->assertEmpty($contact2->useridfrom);
        $this->assertFalse($contact2->ismessaging);
        $this->assertNull($contact2->lastmessage);
        $this->assertNull($contact2->messageid);
        $this->assertNull($contact2->isonline);
        $this->assertFalse($contact2->isread);
        $this->assertFalse($contact2->isblocked);
        $this->assertNull($contact2->unreadcount);

        $this->assertEquals($user4->id, $contact3->userid);
        $this->assertEmpty($contact3->useridfrom);
        $this->assertFalse($contact3->ismessaging);
        $this->assertNull($contact3->lastmessage);
        $this->assertNull($contact3->messageid);
        $this->assertNull($contact3->isonline);
        $this->assertFalse($contact3->isread);
        $this->assertFalse($contact3->isblocked);
        $this->assertNull($contact3->unreadcount);
    }

    /**
     * Tests retrieving messages.
     */
    public function test_get_messages() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Retrieve the messages.
        $messages = \core_message\api::get_messages($user1->id, $user2->id);

        // Confirm the message data is correct.
        $this->assertEquals(4, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];
        $message3 = $messages[2];
        $message4 = $messages[3];

        $this->assertEquals($user1->id, $message1->useridfrom);
        $this->assertEquals($user2->id, $message1->useridto);
        $this->assertTrue($message1->displayblocktime);
        $this->assertContains('Yo!', $message1->text);

        $this->assertEquals($user2->id, $message2->useridfrom);
        $this->assertEquals($user1->id, $message2->useridto);
        $this->assertFalse($message2->displayblocktime);
        $this->assertContains('Sup mang?', $message2->text);

        $this->assertEquals($user1->id, $message3->useridfrom);
        $this->assertEquals($user2->id, $message3->useridto);
        $this->assertFalse($message3->displayblocktime);
        $this->assertContains('Writing PHPUnit tests!', $message3->text);

        $this->assertEquals($user2->id, $message4->useridfrom);
        $this->assertEquals($user1->id, $message4->useridto);
        $this->assertFalse($message4->displayblocktime);
        $this->assertContains('Word.', $message4->text);
    }

    /**
     * Tests retrieving most recent message.
     */
    public function test_get_most_recent_message() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Retrieve the most recent messages.
        $message = \core_message\api::get_most_recent_message($user1->id, $user2->id);

        // Check the results are correct.
        $this->assertEquals($user2->id, $message->useridfrom);
        $this->assertEquals($user1->id, $message->useridto);
        $this->assertContains('Word.', $message->text);
    }

    /**
     * Tests retrieving a user's profile.
     */
    public function test_get_profile() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();

        $user2 = new stdClass();
        $user2->country = 'AU';
        $user2->city = 'Perth';
        $user2 = self::getDataGenerator()->create_user($user2);

        // The person doing the search.
        $this->setUser($user1);

        // Get the profile.
        $profile = \core_message\api::get_profile($user1->id, $user2->id);

        $this->assertEquals($user2->id, $profile->userid);
        $this->assertEmpty($profile->email);
        $this->assertEmpty($profile->country);
        $this->assertEmpty($profile->city);
        $this->assertEquals(fullname($user2), $profile->fullname);
        $this->assertNull($profile->isonline);
        $this->assertFalse($profile->isblocked);
        $this->assertFalse($profile->iscontact);
    }

    /**
     * Tests retrieving a user's profile.
     */
    public function test_get_profile_as_admin() {
        // The person doing the search.
        $this->setAdminUser();

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();

        $user2 = new stdClass();
        $user2->country = 'AU';
        $user2->city = 'Perth';
        $user2 = self::getDataGenerator()->create_user($user2);

        // Get the profile.
        $profile = \core_message\api::get_profile($user1->id, $user2->id);

        $this->assertEquals($user2->id, $profile->userid);
        $this->assertEquals($user2->email, $profile->email);
        $this->assertEquals($user2->country, $profile->country);
        $this->assertEquals($user2->city, $profile->city);
        $this->assertEquals(fullname($user2), $profile->fullname);
        $this->assertFalse($profile->isonline);
        $this->assertFalse($profile->isblocked);
        $this->assertFalse($profile->iscontact);
    }

    /**
     * Tests checking if a user can mark all messages as read.
     */
    public function test_can_mark_all_messages_as_read() {
        // Set as the admin.
        $this->setAdminUser();

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $conversationid = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);

        // The admin can do anything.
        $this->assertTrue(\core_message\api::can_mark_all_messages_as_read($user1->id, $conversationid));

        // Set as the user 1.
        $this->setUser($user1);

        // The user can mark the messages as he is in the conversation.
        $this->assertTrue(\core_message\api::can_mark_all_messages_as_read($user1->id, $conversationid));

        // User 1 can not mark the messages read for user 2.
        $this->assertFalse(\core_message\api::can_mark_all_messages_as_read($user2->id, $conversationid));

        // This user is not a part of the conversation.
        $this->assertFalse(\core_message\api::can_mark_all_messages_as_read($user3->id, $conversationid));
    }

    /**
     * Tests checking if a user can delete a conversation.
     */
    public function test_can_delete_conversation() {
        // Set as the admin.
        $this->setAdminUser();

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        $conversationid = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);

        // The admin can do anything.
        $this->assertTrue(\core_message\api::can_delete_conversation($user1->id, $conversationid));

        // Set as the user 1.
        $this->setUser($user1);

        // They can delete their own messages.
        $this->assertTrue(\core_message\api::can_delete_conversation($user1->id, $conversationid));

        // They can't delete someone elses.
        $this->assertFalse(\core_message\api::can_delete_conversation($user2->id, $conversationid));
    }

    /**
     * Tests deleting a conversation.
     */
    public function test_delete_conversation() {
        global $DB;

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $m1id = $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $m2id = $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $m3id = $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $m4id = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Delete the conversation as user 1.
        \core_message\api::delete_conversation($user1->id, $user2->id);
        $this->assertDebuggingCalled();

        $muas = $DB->get_records('message_user_actions', array(), 'timecreated ASC');
        $this->assertCount(4, $muas);
        // Sort by id.
        ksort($muas);

        $mua1 = array_shift($muas);
        $mua2 = array_shift($muas);
        $mua3 = array_shift($muas);
        $mua4 = array_shift($muas);

        $this->assertEquals($user1->id, $mua1->userid);
        $this->assertEquals($m1id, $mua1->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua1->action);

        $this->assertEquals($user1->id, $mua2->userid);
        $this->assertEquals($m2id, $mua2->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua2->action);

        $this->assertEquals($user1->id, $mua3->userid);
        $this->assertEquals($m3id, $mua3->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua3->action);

        $this->assertEquals($user1->id, $mua4->userid);
        $this->assertEquals($m4id, $mua4->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua4->action);
    }

    /**
     * Tests deleting a conversation by conversation id.
     */
    public function test_delete_conversation_by_id() {
        global $DB;

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $m1id = $this->send_fake_message($user1, $user2, 'Yo!', 0, $time + 1);
        $m2id = $this->send_fake_message($user2, $user1, 'Sup mang?', 0, $time + 2);
        $m3id = $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!', 0, $time + 3);
        $m4id = $this->send_fake_message($user2, $user1, 'Word.', 0, $time + 4);

        // Delete the conversation as user 1.
        $conversationid = \core_message\api::get_conversation_between_users([$user1->id, $user2->id]);
        \core_message\api::delete_conversation_by_id($user1->id, $conversationid);

        $muas = $DB->get_records('message_user_actions', array(), 'timecreated ASC');
        $this->assertCount(4, $muas);
        // Sort by id.
        ksort($muas);

        $mua1 = array_shift($muas);
        $mua2 = array_shift($muas);
        $mua3 = array_shift($muas);
        $mua4 = array_shift($muas);

        $this->assertEquals($user1->id, $mua1->userid);
        $this->assertEquals($m1id, $mua1->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua1->action);

        $this->assertEquals($user1->id, $mua2->userid);
        $this->assertEquals($m2id, $mua2->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua2->action);

        $this->assertEquals($user1->id, $mua3->userid);
        $this->assertEquals($m3id, $mua3->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua3->action);

        $this->assertEquals($user1->id, $mua4->userid);
        $this->assertEquals($m4id, $mua4->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_DELETED, $mua4->action);
    }

    /**
     * Tests counting unread conversations.
     */
    public function test_count_unread_conversations() {
        $this->resetAfterTest(true);

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // The person wanting the conversation count.
        $this->setUser($user1);

        // Send some messages back and forth, have some different conversations with different users.
        $this->send_fake_message($user1, $user2, 'Yo!');
        $this->send_fake_message($user2, $user1, 'Sup mang?');
        $this->send_fake_message($user1, $user2, 'Writing PHPUnit tests!');
        $this->send_fake_message($user2, $user1, 'Word.');

        $this->send_fake_message($user1, $user3, 'Booyah');
        $this->send_fake_message($user3, $user1, 'Whaaat?');
        $this->send_fake_message($user1, $user3, 'Nothing.');
        $this->send_fake_message($user3, $user1, 'Cool.');

        $this->send_fake_message($user1, $user4, 'Hey mate, you see the new messaging UI in Moodle?');
        $this->send_fake_message($user4, $user1, 'Yah brah, it\'s pretty rad.');
        $this->send_fake_message($user1, $user4, 'Dope.');

        // Check the amount for the current user.
        $this->assertEquals(3, core_message\api::count_unread_conversations());

        // Check the amount for the second user.
        $this->assertEquals(1, core_message\api::count_unread_conversations($user2));
    }

    /**
     * Tests deleting a conversation.
     */
    public function test_get_all_message_preferences() {
        $user = self::getDataGenerator()->create_user();
        $this->setUser($user);

        // Set a couple of preferences to test.
        set_user_preference('message_provider_mod_assign_assign_notification_loggedin', 'popup', $user);
        set_user_preference('message_provider_mod_assign_assign_notification_loggedoff', 'email', $user);

        $processors = get_message_processors();
        $providers = message_get_providers_for_user($user->id);
        $prefs = \core_message\api::get_all_message_preferences($processors, $providers, $user);

        $this->assertEquals(1, $prefs->mod_assign_assign_notification_loggedin['popup']);
        $this->assertEquals(1, $prefs->mod_assign_assign_notification_loggedoff['email']);
    }

    /**
     * Tests the user can post a message.
     */
    public function test_can_post_message() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the first user.
        $this->setUser($user1);

        // With the default privacy setting, users can't message them.
        $this->assertFalse(\core_message\api::can_post_message($user2));

        // Enrol users to the same course.
        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user1->id, $course->id);
        $this->getDataGenerator()->enrol_user($user2->id, $course->id);
        // After enrolling users to the course, they should be able to message them with the default privacy setting.
        $this->assertTrue(\core_message\api::can_post_message($user2));
    }

    /**
     * Tests the user can't post a message without proper capability.
     */
    public function test_can_post_message_without_sendmessage_cap() {
        global $DB;

        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the user 1.
        $this->setUser($user1);

        // Remove the capability to send a message.
        $roleids = $DB->get_records_menu('role', null, '', 'shortname, id');
        unassign_capability('moodle/site:sendmessage', $roleids['user'],
            context_system::instance());

        // Check that we can not post a message without the capability.
        $this->assertFalse(\core_message\api::can_post_message($user2));
    }

    /**
     * Tests the user can post a message when they are contact.
     */
    public function test_can_post_message_when_contact() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the first user.
        $this->setUser($user1);

        // Check that we can not send user2 a message.
        $this->assertFalse(\core_message\api::can_post_message($user2));

        // Add users as contacts.
        \core_message\api::add_contact($user1->id, $user2->id);

        // Check that the return result is now true.
        $this->assertTrue(\core_message\api::can_post_message($user2));
    }

    /**
     * Tests the user can't post a message if they are not a contact and the user
     * has requested messages only from contacts.
     */
    public function test_can_post_message_when_not_contact() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the first user.
        $this->setUser($user1);

        // Set the second user's preference to not receive messages from non-contacts.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS, $user2->id);

        // Check that we can not send user 2 a message.
        $this->assertFalse(\core_message\api::can_post_message($user2));
    }

    /**
     * Tests the user can't post a message if they are blocked.
     */
    public function test_can_post_message_when_blocked() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set the user.
        $this->setUser($user1);

        // Block the second user.
        \core_message\api::block_user($user1->id, $user2->id);

        // Check that the second user can no longer send the first user a message.
        $this->assertFalse(\core_message\api::can_post_message($user1, $user2));
    }

    /**
     * Tests the user can post a message when site-wide messaging setting is enabled,
     * even if they are not a contact and are not members of the same course.
     */
    public function test_can_post_message_site_messaging_setting() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the first user.
        $this->setUser($user1);

        // By default, user only can be messaged by contacts and members of any of his/her courses.
        $this->assertFalse(\core_message\api::can_post_message($user2));

        // Enable site-wide messagging privacy setting. The user will be able to receive messages from everybody.
        set_config('messagingallusers', true);

        // Set the second user's preference to receive messages from everybody.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_SITE, $user2->id);

        // Check that we can send user2 a message.
        $this->assertTrue(\core_message\api::can_post_message($user2));

        // Disable site-wide messagging privacy setting. The user will be able to receive messages from contacts
        // and members sharing a course with her.
        set_config('messagingallusers', false);

        // As site-wide messaging setting is disabled, the value for user2 will be changed to MESSAGE_PRIVACY_COURSEMEMBER.
        $this->assertFalse(\core_message\api::can_post_message($user2));

        // Enrol users to the same course.
        $course = $this->getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user1->id, $course->id);
        $this->getDataGenerator()->enrol_user($user2->id, $course->id);
        // Check that we can send user2 a message because they are sharing a course.
        $this->assertTrue(\core_message\api::can_post_message($user2));

        // Set the second user's preference to receive messages only from contacts.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS, $user2->id);
        // Check that now the user2 can't be contacted because user1 is not their contact.
        $this->assertFalse(\core_message\api::can_post_message($user2));

        // Make contacts user1 and user2.
        \core_message\api::add_contact($user2->id, $user1->id);
        // Check that we can send user2 a message because they are contacts.
        $this->assertTrue(\core_message\api::can_post_message($user2));
    }

    /**
     * Tests the user with the messageanyuser capability can post a message.
     */
    public function test_can_post_message_with_messageanyuser_cap() {
        global $DB;

        // Create some users.
        $teacher1 = self::getDataGenerator()->create_user();
        $student1 = self::getDataGenerator()->create_user();
        $student2 = self::getDataGenerator()->create_user();

        // Create users not enrolled in any course.
        $user1 = self::getDataGenerator()->create_user();

        // Create a course.
        $course1 = $this->getDataGenerator()->create_course();

        // Enrol the users in the course.
        $this->getDataGenerator()->enrol_user($teacher1->id, $course1->id, 'editingteacher');
        $this->getDataGenerator()->enrol_user($student1->id, $course1->id, 'student');
        $this->getDataGenerator()->enrol_user($student2->id, $course1->id, 'student');

        // Set some student preferences to not receive messages from non-contacts.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS, $student1->id);

        // Check that we can send student1 a message because teacher has the messageanyuser cap by default.
        $this->assertTrue(\core_message\api::can_post_message($student1, $teacher1));
        // Check that the teacher can't contact user1 because it's not his teacher.
        $this->assertFalse(\core_message\api::can_post_message($user1, $teacher1));

        // Remove the messageanyuser capability from the course1 for teachers.
        $coursecontext = context_course::instance($course1->id);
        $teacherrole = $DB->get_record('role', ['shortname' => 'editingteacher']);
        assign_capability('moodle/site:messageanyuser', CAP_PROHIBIT, $teacherrole->id, $coursecontext->id);
        $coursecontext->mark_dirty();

        // Check that we can't send user1 a message because they are not contacts.
        $this->assertFalse(\core_message\api::can_post_message($student1, $teacher1));
        // However, teacher can message student2 because they are sharing a course.
        $this->assertTrue(\core_message\api::can_post_message($student2, $teacher1));
    }

    /**
     * Tests get_user_privacy_messaging_preference method.
     */
    public function test_get_user_privacy_messaging_preference() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Enable site-wide messagging privacy setting. The user will be able to receive messages from everybody.
        set_config('messagingallusers', true);

        // Set some user preferences.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_SITE, $user1->id);
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS, $user2->id);

        // Check the returned value for each user.
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_SITE,
            \core_message\api::get_user_privacy_messaging_preference($user1->id)
        );
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS,
            \core_message\api::get_user_privacy_messaging_preference($user2->id)
        );
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_SITE,
            \core_message\api::get_user_privacy_messaging_preference($user3->id)
        );

        // Disable site-wide messagging privacy setting. The user will be able to receive messages from members of their course.
        set_config('messagingallusers', false);

        // Check the returned value for each user.
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_COURSEMEMBER,
            \core_message\api::get_user_privacy_messaging_preference($user1->id)
        );
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS,
            \core_message\api::get_user_privacy_messaging_preference($user2->id)
        );
        $this->assertEquals(
            \core_message\api::MESSAGE_PRIVACY_COURSEMEMBER,
            \core_message\api::get_user_privacy_messaging_preference($user3->id)
        );
    }

    /**
     * Tests that when blocking messages from non-contacts is enabled that
     * non-contacts trying to send a message return false.
     */
    public function test_is_user_non_contact_blocked() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set as the first user.
        $this->setUser($user1);

        // By default, user only can be messaged by contacts and members of any of his/her courses.
        $this->assertTrue(\core_message\api::is_user_non_contact_blocked($user2));
        $this->assertDebuggingCalled();

        // Enable all users privacy messaging and check now the default user's preference has been set to allow receiving
        // messages from everybody.
        set_config('messagingallusers', true);
        // Check that the return result is now false because any site user can contact him/her.
        $this->assertFalse(\core_message\api::is_user_non_contact_blocked($user2));
        $this->assertDebuggingCalled();

        // Set the second user's preference to not receive messages from non-contacts.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_ONLYCONTACTS, $user2->id);
        // Check that the return result is still true (because is even more restricted).
        $this->assertTrue(\core_message\api::is_user_non_contact_blocked($user2));
        $this->assertDebuggingCalled();

        // Add the first user as a contact for the second user.
        \core_message\api::add_contact($user2->id, $user1->id);

        // Check that the return result is now false.
        $this->assertFalse(\core_message\api::is_user_non_contact_blocked($user2));
        $this->assertDebuggingCalled();

        // Set the second user's preference to receive messages from course members.
        set_user_preference('message_blocknoncontacts', \core_message\api::MESSAGE_PRIVACY_COURSEMEMBER, $user2->id);
        // Check that the return result is still false (because $user1 is still his/her contact).
        $this->assertFalse(\core_message\api::is_user_non_contact_blocked($user2));
        $this->assertDebuggingCalled();
    }

    /**
     * Tests that we return true when a user is blocked, or false
     * if they are not blocked.
     */
    public function test_is_user_blocked() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Set the user.
        $this->setUser($user1);

        // User shouldn't be blocked.
        $this->assertFalse(\core_message\api::is_user_blocked($user1->id, $user2->id));
        $this->assertDebuggingCalled();

        // Block the user.
        \core_message\api::block_user($user1->id, $user2->id);

        // User should be blocked.
        $this->assertTrue(\core_message\api::is_user_blocked($user1->id, $user2->id));
        $this->assertDebuggingCalled();

        // Unblock the user.
        \core_message\api::unblock_user($user1->id, $user2->id);
        $this->assertFalse(\core_message\api::is_user_blocked($user1->id, $user2->id));
        $this->assertDebuggingCalled();
    }

    /**
     * Tests that the admin is not blocked even if someone has chosen to block them.
     */
    public function test_is_user_blocked_as_admin() {
        // Create a user.
        $user1 = self::getDataGenerator()->create_user();

        // Set the user.
        $this->setUser($user1);

        // Block the admin user.
        \core_message\api::block_user($user1->id, 2);

        // Now change to the admin user.
        $this->setAdminUser();

        // As the admin you should still be able to send messages to the user.
        $this->assertFalse(\core_message\api::is_user_blocked($user1->id));
        $this->assertDebuggingCalled();
    }

    /*
     * Tes get_message_processor api.
     */
    public function test_get_message_processor() {
        $processors = get_message_processors(true);
        if (empty($processors)) {
            $this->markTestSkipped("No message processors found");
        }

        $name = key($processors);
        $processor = current($processors);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals($processor->name, $testprocessor->name);
        $this->assertEquals($processor->enabled, $testprocessor->enabled);
        $this->assertEquals($processor->available, $testprocessor->available);
        $this->assertEquals($processor->configured, $testprocessor->configured);

        // Disable processor and test.
        \core_message\api::update_processor_status($testprocessor, 0);
        $testprocessor = \core_message\api::get_message_processor($name, true);
        $this->assertEmpty($testprocessor);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals($processor->name, $testprocessor->name);
        $this->assertEquals(0, $testprocessor->enabled);

        // Enable again and test.
        \core_message\api::update_processor_status($testprocessor, 1);
        $testprocessor = \core_message\api::get_message_processor($name, true);
        $this->assertEquals($processor->name, $testprocessor->name);
        $this->assertEquals(1, $testprocessor->enabled);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals($processor->name, $testprocessor->name);
        $this->assertEquals(1, $testprocessor->enabled);
    }

    /**
     * Test method update_processor_status.
     */
    public function test_update_processor_status() {
        $processors = get_message_processors();
        if (empty($processors)) {
            $this->markTestSkipped("No message processors found");
        }
        $name = key($processors);
        $testprocessor = current($processors);

        // Enable.
        \core_message\api::update_processor_status($testprocessor, 1);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals(1, $testprocessor->enabled);

        // Disable.
        \core_message\api::update_processor_status($testprocessor, 0);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals(0, $testprocessor->enabled);

        // Enable again.
        \core_message\api::update_processor_status($testprocessor, 1);
        $testprocessor = \core_message\api::get_message_processor($name);
        $this->assertEquals(1, $testprocessor->enabled);
    }

    /**
     * Test method is_user_enabled.
     */
    public function is_user_enabled() {
        $processors = get_message_processors();
        if (empty($processors)) {
            $this->markTestSkipped("No message processors found");
        }
        $name = key($processors);
        $testprocessor = current($processors);

        // Enable.
        \core_message\api::update_processor_status($testprocessor, 1);
        $status = \core_message\api::is_processor_enabled($name);
        $this->assertEquals(1, $status);

        // Disable.
        \core_message\api::update_processor_status($testprocessor, 0);
        $status = \core_message\api::is_processor_enabled($name);
        $this->assertEquals(0, $status);

        // Enable again.
        \core_message\api::update_processor_status($testprocessor, 1);
        $status = \core_message\api::is_processor_enabled($name);
        $this->assertEquals(1, $status);
    }

    /**
     * Test retrieving messages by providing a minimum timecreated value.
     */
    public function test_get_messages_time_from_only() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Message 1', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Message 2', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Message 3', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Message 4', 0, $time + 4);

        // Retrieve the messages from $time, which should be all of them.
        $messages = \core_message\api::get_messages($user1->id, $user2->id, 0, 0, 'timecreated ASC', $time);

        // Confirm the message data is correct.
        $this->assertEquals(4, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];
        $message3 = $messages[2];
        $message4 = $messages[3];

        $this->assertContains('Message 1', $message1->text);
        $this->assertContains('Message 2', $message2->text);
        $this->assertContains('Message 3', $message3->text);
        $this->assertContains('Message 4', $message4->text);

        // Retrieve the messages from $time + 3, which should only be the 2 last messages.
        $messages = \core_message\api::get_messages($user1->id, $user2->id, 0, 0, 'timecreated ASC', $time + 3);

        // Confirm the message data is correct.
        $this->assertEquals(2, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];

        $this->assertContains('Message 3', $message1->text);
        $this->assertContains('Message 4', $message2->text);
    }

    /**
     * Test retrieving messages by providing a maximum timecreated value.
     */
    public function test_get_messages_time_to_only() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Message 1', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Message 2', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Message 3', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Message 4', 0, $time + 4);

        // Retrieve the messages up until $time + 4, which should be all of them.
        $messages = \core_message\api::get_messages($user1->id, $user2->id, 0, 0, 'timecreated ASC', 0, $time + 4);

        // Confirm the message data is correct.
        $this->assertEquals(4, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];
        $message3 = $messages[2];
        $message4 = $messages[3];

        $this->assertContains('Message 1', $message1->text);
        $this->assertContains('Message 2', $message2->text);
        $this->assertContains('Message 3', $message3->text);
        $this->assertContains('Message 4', $message4->text);

        // Retrieve the messages up until $time + 2, which should be the first two.
        $messages = \core_message\api::get_messages($user1->id, $user2->id, 0, 0, 'timecreated ASC', 0, $time + 2);

        // Confirm the message data is correct.
        $this->assertEquals(2, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];

        $this->assertContains('Message 1', $message1->text);
        $this->assertContains('Message 2', $message2->text);
    }

    /**
     * Test retrieving messages by providing a minimum and maximum timecreated value.
     */
    public function test_get_messages_time_from_and_to() {
        // Create some users.
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // The person doing the search.
        $this->setUser($user1);

        // Send some messages back and forth.
        $time = 1;
        $this->send_fake_message($user1, $user2, 'Message 1', 0, $time + 1);
        $this->send_fake_message($user2, $user1, 'Message 2', 0, $time + 2);
        $this->send_fake_message($user1, $user2, 'Message 3', 0, $time + 3);
        $this->send_fake_message($user2, $user1, 'Message 4', 0, $time + 4);

        // Retrieve the messages from $time + 2 up until $time + 3, which should be 2nd and 3rd message.
        $messages = \core_message\api::get_messages($user1->id, $user2->id, 0, 0, 'timecreated ASC', $time + 2, $time + 3);

        // Confirm the message data is correct.
        $this->assertEquals(2, count($messages));

        $message1 = $messages[0];
        $message2 = $messages[1];

        $this->assertContains('Message 2', $message1->text);
        $this->assertContains('Message 3', $message2->text);
    }

    /**
     * Test returning blocked users.
     */
    public function test_get_blocked_users() {
        global $USER;

        // Set this user as the admin.
        $this->setAdminUser();

        // Create a user to add to the admin's contact list.
        $user1 = $this->getDataGenerator()->create_user();
        $user2 = $this->getDataGenerator()->create_user();

        // Add users to the admin's contact list.
        \core_message\api::block_user($USER->id, $user2->id);

        $this->assertCount(1, \core_message\api::get_blocked_users($USER->id));

        // Block other user.
        \core_message\api::block_user($USER->id, $user1->id);
        $this->assertCount(2, \core_message\api::get_blocked_users($USER->id));

        // Test deleting users.
        delete_user($user1);
        $this->assertCount(1, \core_message\api::get_blocked_users($USER->id));
    }

    /**
     * Test returning contacts with unread message count.
     */
    public function test_get_contacts_with_unread_message_count() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // Add the users to each of their contacts.
        \core_message\api::add_contact($user1->id, $user2->id);
        \core_message\api::add_contact($user2->id, $user3->id);

        $this->send_fake_message($user1, $user2);
        $this->send_fake_message($user1, $user2);
        $this->send_fake_message($user1, $user2);
        $message4id = $this->send_fake_message($user1, $user2);

        $this->send_fake_message($user3, $user2);
        $message6id = $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);

        // Send a message that should never be included as the user is not a contact.
        $this->send_fake_message($user4, $user2);

        // Get the contacts and the unread message count.
        $messages = \core_message\api::get_contacts_with_unread_message_count($user2->id);

        // Confirm the size is correct.
        $this->assertCount(2, $messages);
        ksort($messages);

        $messageinfo1 = array_shift($messages);
        $messageinfo2 = array_shift($messages);

        $this->assertEquals($user1->id, $messageinfo1->id);
        $this->assertEquals(4, $messageinfo1->messagecount);
        $this->assertEquals($user3->id, $messageinfo2->id);
        $this->assertEquals(5, $messageinfo2->messagecount);

        // Mark some of the messages as read.
        $m4 = $DB->get_record('messages', ['id' => $message4id]);
        $m6 = $DB->get_record('messages', ['id' => $message6id]);
        \core_message\api::mark_message_as_read($user2->id, $m4);
        \core_message\api::mark_message_as_read($user2->id, $m6);

        // Get the contacts and the unread message count.
        $messages = \core_message\api::get_contacts_with_unread_message_count($user2->id);

        // Confirm the size is correct.
        $this->assertCount(2, $messages);
        ksort($messages);

        // Confirm read messages are not included.
        $messageinfo1 = array_shift($messages);
        $messageinfo2 = array_shift($messages);
        $this->assertEquals($user1->id, $messageinfo1->id);
        $this->assertEquals(3, $messageinfo1->messagecount);
        $this->assertEquals($user3->id, $messageinfo2->id);
        $this->assertEquals(4, $messageinfo2->messagecount);

        // Now, let's populate the database with messages from user2 to user 1.
        $this->send_fake_message($user2, $user1);
        $this->send_fake_message($user2, $user1);
        $messageid = $this->send_fake_message($user2, $user1);

        // Send a message that should never be included as the user is not a contact.
        $this->send_fake_message($user4, $user1);

        // Get the contacts and the unread message count.
        $messages = \core_message\api::get_contacts_with_unread_message_count($user1->id);

        // Confirm the size is correct.
        $this->assertCount(1, $messages);
        $messageinfo1 = array_shift($messages);
        $this->assertEquals($user2->id, $messageinfo1->id);
        $this->assertEquals(3, $messageinfo1->messagecount);

        // Mark the last message as read.
        $m = $DB->get_record('messages', ['id' => $messageid]);
        \core_message\api::mark_message_as_read($user1->id, $m);

        $messages = \core_message\api::get_contacts_with_unread_message_count($user1->id);

        // Confirm the size is correct.
        $this->assertCount(1, $messages);

        // Confirm read messages are not included.
        $messageinfo1 = array_shift($messages);
        $this->assertEquals($user2->id, $messageinfo1->id);
        $this->assertEquals(2, $messageinfo1->messagecount);
    }

    /**
     * Test returning contacts with unread message count when there are no messages.
     */
    public function test_get_contacts_with_unread_message_count_no_messages() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Add the users to each of their contacts.
        \core_message\api::add_contact($user2->id, $user1->id);

        // Check we get the correct message count.
        $messages = \core_message\api::get_contacts_with_unread_message_count($user2->id);

        // Confirm the size is correct.
        $this->assertCount(1, $messages);

        $messageinfo = array_shift($messages);

        $this->assertEquals($user1->id, $messageinfo->id);
        $this->assertEquals(0, $messageinfo->messagecount);
    }

    /**
     * Test returning non-contacts with unread message count.
     */
    public function test_get_non_contacts_with_unread_message_count() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        // Add a user to the contact list of the users we are testing this function with.
        \core_message\api::add_contact($user1->id, $user4->id);
        \core_message\api::add_contact($user2->id, $user4->id);

        $this->send_fake_message($user1, $user2);
        $this->send_fake_message($user1, $user2);
        $this->send_fake_message($user1, $user2);
        $message4id = $this->send_fake_message($user1, $user2);

        $this->send_fake_message($user3, $user2);
        $message6id = $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);
        $this->send_fake_message($user3, $user2);

        // Send a message that should never be included as the user is a contact.
        $this->send_fake_message($user4, $user2);

        // Get the non-contacts and the unread message count.
        $messages = \core_message\api::get_non_contacts_with_unread_message_count($user2->id);

        // Check we get the correct message count.
        ksort($messages);
        $this->assertCount(2, $messages);
        $messageinfo1 = array_shift($messages);
        $messageinfo2 = array_shift($messages);
        $this->assertEquals($user1->id, $messageinfo1->id);
        $this->assertEquals(4, $messageinfo1->messagecount);
        $this->assertEquals($user3->id, $messageinfo2->id);
        $this->assertEquals(5, $messageinfo2->messagecount);

        // Mark some of the messages as read.
        $m4 = $DB->get_record('messages', ['id' => $message4id]);
        $m6 = $DB->get_record('messages', ['id' => $message6id]);
        \core_message\api::mark_message_as_read($user2->id, $m4);
        \core_message\api::mark_message_as_read($user2->id, $m6);

        // Get the non-contacts and the unread message count.
        $messages = \core_message\api::get_non_contacts_with_unread_message_count($user2->id);

        // Check the marked message is not returned in the message count.
        ksort($messages);
        $this->assertCount(2, $messages);
        $messageinfo1 = array_shift($messages);
        $messageinfo2 = array_shift($messages);
        $this->assertEquals($user1->id, $messageinfo1->id);
        $this->assertEquals(3, $messageinfo1->messagecount);
        $this->assertEquals($user3->id, $messageinfo2->id);
        $this->assertEquals(4, $messageinfo2->messagecount);

        // Now, let's populate the database with messages from user2 to user 1.
        $this->send_fake_message($user2, $user1);
        $this->send_fake_message($user2, $user1);
        $messageid = $this->send_fake_message($user2, $user1);

        // Send a message that should never be included as the user is a contact.
        $this->send_fake_message($user4, $user1);

        // Get the non-contacts and the unread message count.
        $messages = \core_message\api::get_non_contacts_with_unread_message_count($user1->id);

        // Confirm the size is correct.
        $this->assertCount(1, $messages);
        $messageinfo1 = array_shift($messages);
        $this->assertEquals($user2->id, $messageinfo1->id);
        $this->assertEquals(3, $messageinfo1->messagecount);

        // Mark the last message as read.
        $m = $DB->get_record('messages', ['id' => $messageid]);
        \core_message\api::mark_message_as_read($user1->id, $m);

        // Get the non-contacts and the unread message count.
        $messages = \core_message\api::get_non_contacts_with_unread_message_count($user1->id);

        // Check the marked message is not returned in the message count.
        $this->assertCount(1, $messages);
        $messageinfo1 = array_shift($messages);
        $this->assertEquals($user2->id, $messageinfo1->id);
        $this->assertEquals(2, $messageinfo1->messagecount);
    }

    /**
     * Test marking a message as read.
     */
    public function test_mark_message_as_read() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $this->send_fake_message($user1, $user2);
        $m2id = $this->send_fake_message($user1, $user2);
        $this->send_fake_message($user2, $user1);
        $m4id = $this->send_fake_message($user2, $user1);

        $m2 = $DB->get_record('messages', ['id' => $m2id]);
        $m4 = $DB->get_record('messages', ['id' => $m4id]);
        \core_message\api::mark_message_as_read($user2->id, $m2, 11);
        \core_message\api::mark_message_as_read($user1->id, $m4, 12);

        // Confirm there are two user actions.
        $muas = $DB->get_records('message_user_actions', [], 'timecreated ASC');
        $this->assertEquals(2, count($muas));

        // Confirm they are correct.
        $mua1 = array_shift($muas);
        $mua2 = array_shift($muas);

        // Confirm first action.
        $this->assertEquals($user2->id, $mua1->userid);
        $this->assertEquals($m2id, $mua1->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_READ, $mua1->action);
        $this->assertEquals(11, $mua1->timecreated);

        // Confirm second action.
        $this->assertEquals($user1->id, $mua2->userid);
        $this->assertEquals($m4id, $mua2->messageid);
        $this->assertEquals(\core_message\api::MESSAGE_ACTION_READ, $mua2->action);
        $this->assertEquals(12, $mua2->timecreated);
    }

    /**
     * Test marking a notification as read.
     */
    public function test_mark_notification_as_read() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $this->send_fake_message($user1, $user2, 'Notification 1', 1);
        $n2id = $this->send_fake_message($user1, $user2, 'Notification 2', 1);
        $this->send_fake_message($user2, $user1, 'Notification 3', 1);
        $n4id = $this->send_fake_message($user2, $user1, 'Notification 4', 1);

        $n2 = $DB->get_record('notifications', ['id' => $n2id]);
        $n4 = $DB->get_record('notifications', ['id' => $n4id]);

        \core_message\api::mark_notification_as_read($n2, 11);
        \core_message\api::mark_notification_as_read($n4, 12);

        // Retrieve the notifications.
        $n2 = $DB->get_record('notifications', ['id' => $n2id]);
        $n4 = $DB->get_record('notifications', ['id' => $n4id]);

        // Confirm they have been marked as read.
        $this->assertEquals(11, $n2->timeread);
        $this->assertEquals(12, $n4->timeread);
    }

    /**
     * Test a conversation is not returned if there is none.
     */
    public function test_get_conversation_between_users_no_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $this->assertFalse(\core_message\api::get_conversation_between_users([$user1->id, $user2->id]));
    }

    /**
     * Test we can return a conversation that exists between users.
     */
    public function test_get_conversation_between_users_with_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversationid = \core_message\api::create_conversation_between_users([$user1->id, $user2->id]);
        $this->assertDebuggingCalled();

        $this->assertEquals($conversationid,
            \core_message\api::get_conversation_between_users([$user1->id, $user2->id]));
    }

    /**
     * Test count_conversation_members for non existing conversation.
     */
    public function test_count_conversation_members_no_existing_conversation() {
        $this->assertEquals(0,
            \core_message\api::count_conversation_members(0));
    }

    /**
     * Test count_conversation_members for existing conversation.
     */
    public function test_count_conversation_members_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertEquals(2,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test add_members_to_conversation for an individual conversation.
     */
    public function test_add_members_to_individual_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->expectException('moodle_exception');
        \core_message\api::add_members_to_conversation([$user3->id], $conversationid);
    }

    /**
     * Test add_members_to_conversation for existing conversation.
     */
    public function test_add_members_to_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::add_members_to_conversation([$user3->id], $conversationid));
        $this->assertEquals(3,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test add_members_to_conversation for non existing conversation.
     */
    public function test_add_members_to_no_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();

        // Throw dml_missing_record_exception for non existing conversation.
        $this->expectException('dml_missing_record_exception');
        \core_message\api::add_members_to_conversation([$user1->id], 0);
    }

    /**
     * Test add_member_to_conversation for non existing user.
     */
    public function test_add_members_to_no_existing_user() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        // Don't throw an error for non existing user, but don't add it as a member.
        $this->assertNull(\core_message\api::add_members_to_conversation([0], $conversationid));
        $this->assertEquals(2,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test add_members_to_conversation for current conversation member.
     */
    public function test_add_members_to_current_conversation_member() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        // Don't add as a member a user that is already conversation member.
        $this->assertNull(\core_message\api::add_members_to_conversation([$user1->id], $conversationid));
        $this->assertEquals(2,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test add_members_to_conversation for multiple users.
     */
    public function test_add_members_for_multiple_users() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::add_members_to_conversation([$user3->id, $user4->id], $conversationid));
        $this->assertEquals(4,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test add_members_to_conversation for multiple users, included non existing and current conversation members
     */
    public function test_add_members_for_multiple_not_valid_users() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        // Don't throw errors, but don't add as members users don't exist or are already conversation members.
        $this->assertNull(\core_message\api::add_members_to_conversation([$user3->id, $user1->id, 0], $conversationid));
        $this->assertEquals(3,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test remove_members_from_conversation for individual conversation.
     */
    public function test_remove_members_from_individual_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->expectException('moodle_exception');
        \core_message\api::remove_members_from_conversation([$user1->id], $conversationid);
    }

    /**
     * Test remove_members_from_conversation for existing conversation.
     */
    public function test_remove_members_from_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::remove_members_from_conversation([$user1->id], $conversationid));
        $this->assertEquals(1,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test remove_members_from_conversation for non existing conversation.
     */
    public function test_remove_members_from_no_existing_conversation() {
        $user1 = self::getDataGenerator()->create_user();

        // Throw dml_missing_record_exception for non existing conversation.
        $this->expectException('dml_missing_record_exception');
        \core_message\api::remove_members_from_conversation([$user1->id], 0);
    }

    /**
     * Test remove_members_from_conversation for non existing user.
     */
    public function test_remove_members_for_no_existing_user() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::remove_members_from_conversation([0], $conversationid));
        $this->assertEquals(2,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test remove_members_from_conversation for multiple users.
     */
    public function test_remove_members_for_multiple_users() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::add_members_to_conversation([$user3->id, $user4->id], $conversationid));
        $this->assertNull(\core_message\api::remove_members_from_conversation([$user3->id, $user4->id], $conversationid));
        $this->assertEquals(2,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test remove_members_from_conversation for multiple non valid users.
     */
    public function test_remove_members_for_multiple_no_valid_users() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();
        $user4 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::add_members_to_conversation([$user3->id], $conversationid));
        $this->assertNull(
            \core_message\api::remove_members_from_conversation([$user2->id, $user3->id, $user4->id, 0], $conversationid)
        );
        $this->assertEquals(1,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test count_conversation_members for empty conversation.
     */
    public function test_count_conversation_members_empty_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertNull(\core_message\api::remove_members_from_conversation([$user1->id, $user2->id], $conversationid));

        $this->assertEquals(0,
            \core_message\api::count_conversation_members($conversationid));
    }

    /**
     * Test can create a contact request.
     */
    public function test_can_create_contact_request() {
        global $CFG;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        // Disable messaging.
        $CFG->messaging = 0;
        $this->assertFalse(\core_message\api::can_create_contact($user1->id, $user2->id));

        // Re-enable messaging.
        $CFG->messaging = 1;

        // Allow users to message anyone site-wide.
        $CFG->messagingallusers = 1;
        $this->assertTrue(\core_message\api::can_create_contact($user1->id, $user2->id));

        // Disallow users from messaging anyone site-wide.
        $CFG->messagingallusers = 0;
        $this->assertFalse(\core_message\api::can_create_contact($user1->id, $user2->id));

        // Put the users in the same course so a contact request should be possible.
        $course = self::getDataGenerator()->create_course();
        $this->getDataGenerator()->enrol_user($user1->id, $course->id);
        $this->getDataGenerator()->enrol_user($user2->id, $course->id);
        $this->assertTrue(\core_message\api::can_create_contact($user1->id, $user2->id));
    }

    /**
     * Test creating a contact request.
     */
    public function test_create_contact_request() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::create_contact_request($user1->id, $user2->id);

        $request = $DB->get_records('message_contact_requests');

        $this->assertCount(1, $request);

        $request = reset($request);

        $this->assertEquals($user1->id, $request->userid);
        $this->assertEquals($user2->id, $request->requesteduserid);
    }

    /**
     * Test confirming a contact request.
     */
    public function test_confirm_contact_request() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::create_contact_request($user1->id, $user2->id);

        \core_message\api::confirm_contact_request($user1->id, $user2->id);

        $this->assertEquals(0, $DB->count_records('message_contact_requests'));

        $contact = $DB->get_records('message_contacts');

        $this->assertCount(1, $contact);

        $contact = reset($contact);

        $this->assertEquals($user1->id, $contact->userid);
        $this->assertEquals($user2->id, $contact->contactid);
    }

    /**
     * Test declining a contact request.
     */
    public function test_decline_contact_request() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::create_contact_request($user1->id, $user2->id);

        \core_message\api::decline_contact_request($user1->id, $user2->id);

        $this->assertEquals(0, $DB->count_records('message_contact_requests'));
        $this->assertEquals(0, $DB->count_records('message_contacts'));
    }

    /**
     * Test retrieving contact requests.
     */
    public function test_get_contact_requests() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        // Block one user, their request should not show up.
        \core_message\api::block_user($user1->id, $user3->id);

        \core_message\api::create_contact_request($user2->id, $user1->id);
        \core_message\api::create_contact_request($user3->id, $user1->id);

        $requests = \core_message\api::get_contact_requests($user1->id);

        $this->assertCount(1, $requests);

        $request = reset($requests);

        $this->assertEquals($user2->id, $request->id);
        $this->assertEquals($user2->picture, $request->picture);
        $this->assertEquals($user2->firstname, $request->firstname);
        $this->assertEquals($user2->lastname, $request->lastname);
        $this->assertEquals($user2->firstnamephonetic, $request->firstnamephonetic);
        $this->assertEquals($user2->lastnamephonetic, $request->lastnamephonetic);
        $this->assertEquals($user2->middlename, $request->middlename);
        $this->assertEquals($user2->alternatename, $request->alternatename);
        $this->assertEquals($user2->email, $request->email);
    }

    /**
     * Test adding contacts.
     */
    public function test_add_contact() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::add_contact($user1->id, $user2->id);

        $contact = $DB->get_records('message_contacts');

        $this->assertCount(1, $contact);

        $contact = reset($contact);

        $this->assertEquals($user1->id, $contact->userid);
        $this->assertEquals($user2->id, $contact->contactid);
    }

    /**
     * Test removing contacts.
     */
    public function test_remove_contact() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::add_contact($user1->id, $user2->id);
        \core_message\api::remove_contact($user1->id, $user2->id);

        $this->assertEquals(0, $DB->count_records('message_contacts'));
    }

    /**
     * Test blocking users.
     */
    public function test_block_user() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::block_user($user1->id, $user2->id);

        $blockedusers = $DB->get_records('message_users_blocked');

        $this->assertCount(1, $blockedusers);

        $blockeduser = reset($blockedusers);

        $this->assertEquals($user1->id, $blockeduser->userid);
        $this->assertEquals($user2->id, $blockeduser->blockeduserid);
    }

    /**
     * Test unblocking users.
     */
    public function test_unblock_user() {
        global $DB;

        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::block_user($user1->id, $user2->id);
        \core_message\api::unblock_user($user1->id, $user2->id);

        $this->assertEquals(0, $DB->count_records('message_users_blocked'));
    }

    /**
     * Test is contact check.
     */
    public function test_is_contact() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        \core_message\api::add_contact($user1->id, $user2->id);

        $this->assertTrue(\core_message\api::is_contact($user1->id, $user2->id));
        $this->assertTrue(\core_message\api::is_contact($user2->id, $user1->id));
        $this->assertFalse(\core_message\api::is_contact($user2->id, $user3->id));
    }

    /**
     * Test get contact.
     */
    public function test_get_contact() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        \core_message\api::add_contact($user1->id, $user2->id);

        $contact = \core_message\api::get_contact($user1->id, $user2->id);

        $this->assertEquals($user1->id, $contact->userid);
        $this->assertEquals($user2->id, $contact->contactid);
    }

    /**
     * Test is blocked checked.
     */
    public function test_is_blocked() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $this->assertFalse(\core_message\api::is_blocked($user1->id, $user2->id));
        $this->assertFalse(\core_message\api::is_blocked($user2->id, $user1->id));

        \core_message\api::block_user($user1->id, $user2->id);

        $this->assertTrue(\core_message\api::is_blocked($user1->id, $user2->id));
        $this->assertFalse(\core_message\api::is_blocked($user2->id, $user1->id));
    }

    /**
     * Test the contact request exist check.
     */
    public function test_does_contact_request_exist() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $this->assertFalse(\core_message\api::does_contact_request_exist($user1->id, $user2->id));
        $this->assertFalse(\core_message\api::does_contact_request_exist($user2->id, $user1->id));

        \core_message\api::create_contact_request($user1->id, $user2->id);

        $this->assertTrue(\core_message\api::does_contact_request_exist($user1->id, $user2->id));
        $this->assertTrue(\core_message\api::does_contact_request_exist($user2->id, $user1->id));
    }

    /**
     * Test the user in conversation check.
     */
    public function test_is_user_in_conversation() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertTrue(\core_message\api::is_user_in_conversation($user1->id, $conversationid));
    }

    /**
     * Test the user in conversation check when they are not.
     */
    public function test_is_user_in_conversation_when_not() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ]
        );
        $conversationid = $conversation->id;

        $this->assertFalse(\core_message\api::is_user_in_conversation($user3->id, $conversationid));
    }

    /**
     * Test can create a group conversation.
     */
    public function test_can_create_group_conversation() {
        global $CFG;

        $student = self::getDataGenerator()->create_user();
        $teacher = self::getDataGenerator()->create_user();
        $course = self::getDataGenerator()->create_course();

        $coursecontext = context_course::instance($course->id);

        $this->getDataGenerator()->enrol_user($student->id, $course->id);
        $this->getDataGenerator()->enrol_user($teacher->id, $course->id, 'editingteacher');

        // Disable messaging.
        $CFG->messaging = 0;
        $this->assertFalse(\core_message\api::can_create_group_conversation($student->id, $coursecontext));

        // Re-enable messaging.
        $CFG->messaging = 1;

        // Student shouldn't be able to.
        $this->assertFalse(\core_message\api::can_create_group_conversation($student->id, $coursecontext));

        // Teacher should.
        $this->assertTrue(\core_message\api::can_create_group_conversation($teacher->id, $coursecontext));
    }

    /**
     * Test creating an individual conversation.
     */
    public function test_create_conversation_individual() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            [
                $user1->id,
                $user2->id
            ],
            'A conversation name'
        );

        $this->assertEquals(\core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL, $conversation->type);
        $this->assertEquals('A conversation name', $conversation->name);
        $this->assertEquals(\core_message\helper::get_conversation_hash([$user1->id, $user2->id]), $conversation->convhash);

        $this->assertCount(2, $conversation->members);

        $member1 = array_shift($conversation->members);
        $member2 = array_shift($conversation->members);

        $this->assertEquals($user1->id, $member1->userid);
        $this->assertEquals($conversation->id, $member1->conversationid);

        $this->assertEquals($user2->id, $member2->userid);
        $this->assertEquals($conversation->id, $member2->conversationid);
    }

    /**
     * Test creating a group conversation.
     */
    public function test_create_conversation_group() {
        $user1 = self::getDataGenerator()->create_user();
        $user2 = self::getDataGenerator()->create_user();
        $user3 = self::getDataGenerator()->create_user();

        $conversation = \core_message\api::create_conversation(
            \core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP,
            [
                $user1->id,
                $user2->id,
                $user3->id
            ],
            'A conversation name'
        );

        $this->assertEquals(\core_message\api::MESSAGE_CONVERSATION_TYPE_GROUP, $conversation->type);
        $this->assertEquals('A conversation name', $conversation->name);
        $this->assertNull($conversation->convhash);

        $this->assertCount(3, $conversation->members);

        $member1 = array_shift($conversation->members);
        $member2 = array_shift($conversation->members);
        $member3 = array_shift($conversation->members);

        $this->assertEquals($user1->id, $member1->userid);
        $this->assertEquals($conversation->id, $member1->conversationid);

        $this->assertEquals($user2->id, $member2->userid);
        $this->assertEquals($conversation->id, $member2->conversationid);

        $this->assertEquals($user3->id, $member3->userid);
        $this->assertEquals($conversation->id, $member3->conversationid);
    }

    /**
     * Test creating an individual conversation with too many members.
     */
    public function test_create_conversation_individual_too_many_members() {
        $this->expectException('moodle_exception');
        \core_message\api::create_conversation(\core_message\api::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL, [1, 2, 3]);
    }

    /**
     * Comparison function for sorting contacts.
     *
     * @param stdClass $a
     * @param stdClass $b
     * @return bool
     */
    protected static function sort_contacts($a, $b) {
        return $a->userid > $b->userid;
    }
}
