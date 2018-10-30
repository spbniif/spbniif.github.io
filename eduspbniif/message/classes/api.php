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
 * Contains class used to return information to display for the message area.
 *
 * @package    core_message
 * @copyright  2016 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_message;

use core_favourites\local\entity\favourite;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/messagelib.php');

/**
 * Class used to return information to display for the message area.
 *
 * @copyright  2016 Mark Nelson <markn@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class api {

    /**
     * The action for reading a message.
     */
    const MESSAGE_ACTION_READ = 1;

    /**
     * The action for deleting a message.
     */
    const MESSAGE_ACTION_DELETED = 2;

    /**
     * The privacy setting for being messaged by anyone within courses user is member of.
     */
    const MESSAGE_PRIVACY_COURSEMEMBER = 0;

    /**
     * The privacy setting for being messaged only by contacts.
     */
    const MESSAGE_PRIVACY_ONLYCONTACTS = 1;

    /**
     * The privacy setting for being messaged by anyone on the site.
     */
    const MESSAGE_PRIVACY_SITE = 2;

    /**
     * An individual conversation.
     */
    const MESSAGE_CONVERSATION_TYPE_INDIVIDUAL = 1;

    /**
     * A group conversation.
     */
    const MESSAGE_CONVERSATION_TYPE_GROUP = 2;

    /**
     * Handles searching for messages in the message area.
     *
     * @param int $userid The user id doing the searching
     * @param string $search The string the user is searching
     * @param int $limitfrom
     * @param int $limitnum
     * @return array
     */
    public static function search_messages($userid, $search, $limitfrom = 0, $limitnum = 0) {
        global $DB;

        // Get the user fields we want.
        $ufields = \user_picture::fields('u', array('lastaccess'), 'userfrom_id', 'userfrom_');
        $ufields2 = \user_picture::fields('u2', array('lastaccess'), 'userto_id', 'userto_');

        $sql = "SELECT m.id, m.useridfrom, mcm.userid as useridto, m.subject, m.fullmessage, m.fullmessagehtml, m.fullmessageformat,
                       m.smallmessage, m.timecreated, 0 as isread, $ufields, mub.id as userfrom_blocked, $ufields2,
                       mub2.id as userto_blocked
                  FROM {messages} m
            INNER JOIN {user} u
                    ON u.id = m.useridfrom
            INNER JOIN {message_conversations} mc
                    ON mc.id = m.conversationid
            INNER JOIN {message_conversation_members} mcm
                    ON mcm.conversationid = m.conversationid
            INNER JOIN {user} u2
                    ON u2.id = mcm.userid
             LEFT JOIN {message_users_blocked} mub
                    ON (mub.blockeduserid = u.id AND mub.userid = ?)
             LEFT JOIN {message_users_blocked} mub2
                    ON (mub2.blockeduserid = u2.id AND mub2.userid = ?)
             LEFT JOIN {message_user_actions} mua
                    ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                 WHERE (m.useridfrom = ? OR mcm.userid = ?)
                   AND m.useridfrom != mcm.userid
                   AND u.deleted = 0
                   AND u2.deleted = 0
                   AND mua.id is NULL
                   AND " . $DB->sql_like('smallmessage', '?', false) . "
              ORDER BY timecreated DESC";

        $params = array($userid, $userid, $userid, self::MESSAGE_ACTION_DELETED, $userid, $userid, '%' . $search . '%');

        // Convert the messages into searchable contacts with their last message being the message that was searched.
        $conversations = array();
        if ($messages = $DB->get_records_sql($sql, $params, $limitfrom, $limitnum)) {
            foreach ($messages as $message) {
                $prefix = 'userfrom_';
                if ($userid == $message->useridfrom) {
                    $prefix = 'userto_';
                    // If it from the user, then mark it as read, even if it wasn't by the receiver.
                    $message->isread = true;
                }
                $blockedcol = $prefix . 'blocked';
                $message->blocked = $message->$blockedcol ? 1 : 0;

                $message->messageid = $message->id;
                $conversations[] = helper::create_contact($message, $prefix);
            }
        }

        return $conversations;
    }

    /**
     * Handles searching for user in a particular course in the message area.
     *
     * @param int $userid The user id doing the searching
     * @param int $courseid The id of the course we are searching in
     * @param string $search The string the user is searching
     * @param int $limitfrom
     * @param int $limitnum
     * @return array
     */
    public static function search_users_in_course($userid, $courseid, $search, $limitfrom = 0, $limitnum = 0) {
        global $DB;

        // Get all the users in the course.
        list($esql, $params) = get_enrolled_sql(\context_course::instance($courseid), '', 0, true);
        $sql = "SELECT u.*, mub.id as isblocked
                  FROM {user} u
                  JOIN ($esql) je
                    ON je.id = u.id
             LEFT JOIN {message_users_blocked} mub
                    ON (mub.blockeduserid = u.id AND mub.userid = :userid)
                 WHERE u.deleted = 0";
        // Add more conditions.
        $fullname = $DB->sql_fullname();
        $sql .= " AND u.id != :userid2
                  AND " . $DB->sql_like($fullname, ':search', false) . "
             ORDER BY " . $DB->sql_fullname();
        $params = array_merge(array('userid' => $userid, 'userid2' => $userid, 'search' => '%' . $search . '%'), $params);

        // Convert all the user records into contacts.
        $contacts = array();
        if ($users = $DB->get_records_sql($sql, $params, $limitfrom, $limitnum)) {
            foreach ($users as $user) {
                $user->blocked = $user->isblocked ? 1 : 0;
                $contacts[] = helper::create_contact($user);
            }
        }

        return $contacts;
    }

    /**
     * Handles searching for user in the message area.
     *
     * @param int $userid The user id doing the searching
     * @param string $search The string the user is searching
     * @param int $limitnum
     * @return array
     */
    public static function search_users($userid, $search, $limitnum = 0) {
        global $CFG, $DB;

        // Used to search for contacts.
        $fullname = $DB->sql_fullname();
        $ufields = \user_picture::fields('u', array('lastaccess'));

        // Users not to include.
        $excludeusers = array($userid, $CFG->siteguest);
        list($exclude, $excludeparams) = $DB->get_in_or_equal($excludeusers, SQL_PARAMS_NAMED, 'param', false);

        // Ok, let's search for contacts first.
        $contacts = array();
        $sql = "SELECT $ufields, mub.id as isuserblocked
                  FROM {user} u
                  JOIN {message_contacts} mc
                    ON u.id = mc.contactid
             LEFT JOIN {message_users_blocked} mub
                    ON (mub.userid = :userid2 AND mub.blockeduserid = u.id)
                 WHERE mc.userid = :userid
                   AND u.deleted = 0
                   AND u.confirmed = 1
                   AND " . $DB->sql_like($fullname, ':search', false) . "
                   AND u.id $exclude
              ORDER BY " . $DB->sql_fullname();
        if ($users = $DB->get_records_sql($sql, array('userid' => $userid, 'userid2' => $userid,
                'search' => '%' . $search . '%') + $excludeparams, 0, $limitnum)) {
            foreach ($users as $user) {
                $user->blocked = $user->isuserblocked ? 1 : 0;
                $contacts[] = helper::create_contact($user);
            }
        }

        // Now, let's get the courses.
        // Make sure to limit searches to enrolled courses.
        $enrolledcourses = enrol_get_my_courses(array('id', 'cacherev'));
        $courses = array();
        // Really we want the user to be able to view the participants if they have the capability
        // 'moodle/course:viewparticipants' or 'moodle/course:enrolreview', but since the search_courses function
        // only takes required parameters we can't. However, the chance of a user having 'moodle/course:enrolreview' but
        // *not* 'moodle/course:viewparticipants' are pretty much zero, so it is not worth addressing.
        if ($arrcourses = \core_course_category::search_courses(array('search' => $search), array('limit' => $limitnum),
                array('moodle/course:viewparticipants'))) {
            foreach ($arrcourses as $course) {
                if (isset($enrolledcourses[$course->id])) {
                    $data = new \stdClass();
                    $data->id = $course->id;
                    $data->shortname = $course->shortname;
                    $data->fullname = $course->fullname;
                    $courses[] = $data;
                }
            }
        }

        // Let's get those non-contacts. Toast them gears boi.
        // Note - you can only block contacts, so these users will not be blocked, so no need to get that
        // extra detail from the database.
        $noncontacts = array();
        $sql = "SELECT $ufields
                  FROM {user} u
                 WHERE u.deleted = 0
                   AND u.confirmed = 1
                   AND " . $DB->sql_like($fullname, ':search', false) . "
                   AND u.id $exclude
                   AND u.id NOT IN (SELECT contactid
                                      FROM {message_contacts}
                                     WHERE userid = :userid)
              ORDER BY " . $DB->sql_fullname();
        if ($users = $DB->get_records_sql($sql,  array('userid' => $userid, 'search' => '%' . $search . '%') + $excludeparams,
                0, $limitnum)) {
            foreach ($users as $user) {
                $noncontacts[] = helper::create_contact($user);
            }
        }

        return array($contacts, $courses, $noncontacts);
    }

    /**
     * Returns the contacts and their conversation to display in the contacts area.
     *
     * ** WARNING **
     * It is HIGHLY recommended to use a sensible limit when calling this function. Trying
     * to retrieve too much information in a single call will cause performance problems.
     * ** WARNING **
     *
     * This function has specifically been altered to break each of the data sets it
     * requires into separate database calls. This is to avoid the performance problems
     * observed when attempting to join large data sets (e.g. the message tables and
     * the user table).
     *
     * While it is possible to gather the data in a single query, and it may even be
     * more efficient with a correctly tuned database, we have opted to trade off some of
     * the benefits of a single query in order to ensure this function will work on
     * most databases with default tunings and with large data sets.
     *
     * @param int $userid The user id
     * @param int $limitfrom
     * @param int $limitnum
     * @param int $type the conversation type.
     * @param bool $favouritesonly whether to retrieve only the favourite conversations for the user, or not.
     * @return array
     */
    public static function get_conversations($userid, $limitfrom = 0, $limitnum = 20, int $type = null,
            bool $favouritesonly = false) {
        global $DB;

        $favouritesql = "";
        $favouriteparams = [];
        if ($favouritesonly) {
            // Ask the favourites subsystem for the user's favourite conversations.
            $service = \core_favourites\service_factory::get_service_for_user_context(\context_user::instance($userid));
            $favourites = $service->find_favourites_by_type('core_message', 'message_conversations');
            if (empty($favourites)) {
                return []; // No favourited conversations, so return none.
            }
            $favids = array_values(array_map(function ($fav) {
                return $fav->itemid;
            }, $favourites));
            list ($insql, $inparams) = $DB->get_in_or_equal($favids, SQL_PARAMS_NAMED, 'favouriteids');
            $favouritesql = " AND m.conversationid {$insql} ";
            $favouriteparams = $inparams;
        }

        // Get the last message from each conversation that the user belongs to.
        $sql = "SELECT m.id, m.conversationid, m.useridfrom, mcm2.userid as useridto, m.smallmessage, m.timecreated
                  FROM {messages} m
            INNER JOIN (
                          SELECT MAX(m.id) AS messageid
                            FROM {messages} m
                      INNER JOIN (
                                      SELECT m.conversationid, MAX(m.timecreated) as maxtime
                                        FROM {messages} m
                                  INNER JOIN {message_conversation_members} mcm
                                          ON mcm.conversationid = m.conversationid
                                   LEFT JOIN {message_user_actions} mua
                                          ON (mua.messageid = m.id AND mua.userid = :userid AND mua.action = :action)
                                       WHERE mua.id is NULL
                                         AND mcm.userid = :userid2
                                    GROUP BY m.conversationid
                                 ) maxmessage
                               ON maxmessage.maxtime = m.timecreated AND maxmessage.conversationid = m.conversationid
                         GROUP BY m.conversationid
                       ) lastmessage
                    ON lastmessage.messageid = m.id
            INNER JOIN {message_conversation_members} mcm
                    ON mcm.conversationid = m.conversationid
            INNER JOIN {message_conversation_members} mcm2
                    ON mcm2.conversationid = m.conversationid
                 WHERE mcm.userid = m.useridfrom
                   AND mcm.id != mcm2.id $favouritesql
              ORDER BY m.timecreated DESC";

        $params = array_merge($favouriteparams, ['userid' => $userid, 'action' => self::MESSAGE_ACTION_DELETED,
            'userid2' => $userid]);
        $messageset = $DB->get_recordset_sql($sql, $params, $limitfrom, $limitnum);

        $messages = [];
        foreach ($messageset as $message) {
            $messages[$message->id] = $message;
        }
        $messageset->close();

        // If there are no messages return early.
        if (empty($messages)) {
            return [];
        }

        // We need to pull out the list of other users that are part of each of these conversations. This
        // needs to be done in a separate query to avoid doing a join on the messages tables and the user
        // tables because on large sites these tables are massive which results in extremely slow
        // performance (typically due to join buffer exhaustion).
        $otheruserids = array_map(function($message) use ($userid) {
            return ($message->useridfrom == $userid) ? $message->useridto : $message->useridfrom;
        }, array_values($messages));

        // Ok, let's get the other members in the conversations.
        list($useridsql, $usersparams) = $DB->get_in_or_equal($otheruserids);
        $userfields = \user_picture::fields('u', array('lastaccess'));
        $userssql = "SELECT $userfields
                       FROM {user} u
                      WHERE id $useridsql
                        AND deleted = 0";
        $otherusers = $DB->get_records_sql($userssql, $usersparams);

        // If there are no other users (user may have been deleted), then do not continue.
        if (empty($otherusers)) {
            return [];
        }

        $contactssql = "SELECT contactid
                          FROM {message_contacts}
                         WHERE userid = ?
                           AND contactid $useridsql";
        $contacts = $DB->get_records_sql($contactssql, array_merge([$userid], $usersparams));

        // Finally, let's get the unread messages count for this user so that we can add them
        // to the conversation. Remember we need to ignore the messages the user sent.
        $unreadcountssql = 'SELECT m.useridfrom, count(m.id) as count
                              FROM {messages} m
                        INNER JOIN {message_conversations} mc
                                ON mc.id = m.conversationid
                        INNER JOIN {message_conversation_members} mcm
                                ON m.conversationid = mcm.conversationid
                         LEFT JOIN {message_user_actions} mua
                                ON (mua.messageid = m.id AND mua.userid = ? AND
                                   (mua.action = ? OR mua.action = ?))
                             WHERE mcm.userid = ?
                               AND m.useridfrom != ?
                               AND mua.id is NULL
                          GROUP BY useridfrom';
        $unreadcounts = $DB->get_records_sql($unreadcountssql, [$userid, self::MESSAGE_ACTION_READ, self::MESSAGE_ACTION_DELETED,
            $userid, $userid]);

        // Get rid of the table prefix.
        $userfields = str_replace('u.', '', $userfields);
        $userproperties = explode(',', $userfields);
        $arrconversations = array();
        foreach ($messages as $message) {
            $conversation = new \stdClass();
            $otheruserid = ($message->useridfrom == $userid) ? $message->useridto : $message->useridfrom;
            $otheruser = isset($otherusers[$otheruserid]) ? $otherusers[$otheruserid] : null;
            $contact = isset($contacts[$otheruserid]) ? $contacts[$otheruserid] : null;

            // It's possible the other user was deleted, so, skip.
            if (is_null($otheruser)) {
                continue;
            }

            // Add the other user's information to the conversation, if we have one.
            foreach ($userproperties as $prop) {
                $conversation->$prop = ($otheruser) ? $otheruser->$prop : null;
            }

            // Add the contact's information, if we have one.
            $conversation->blocked = ($contact) ? $contact->blocked : null;

            // Add the message information.
            $conversation->messageid = $message->id;
            $conversation->smallmessage = $message->smallmessage;
            $conversation->useridfrom = $message->useridfrom;

            // Only consider it unread if $user has unread messages.
            if (isset($unreadcounts[$otheruserid])) {
                $conversation->isread = false;
                $conversation->unreadcount = $unreadcounts[$otheruserid]->count;
            } else {
                $conversation->isread = true;
            }

            $arrconversations[$otheruserid] = helper::create_contact($conversation);
        }

        return $arrconversations;
    }

    /**
     * Mark a conversation as a favourite for the given user.
     *
     * @param int $conversationid the id of the conversation to mark as a favourite.
     * @param int $userid the id of the user to whom the favourite belongs.
     * @return favourite the favourite object.
     * @throws \moodle_exception if the user or conversation don't exist.
     */
    public static function set_favourite_conversation(int $conversationid, int $userid) : favourite {
        if (!self::is_user_in_conversation($userid, $conversationid)) {
            throw new \moodle_exception("Conversation doesn't exist or user is not a member");
        }
        $ufservice = \core_favourites\service_factory::get_service_for_user_context(\context_user::instance($userid));
        return $ufservice->create_favourite('core_message', 'message_conversations', $conversationid, \context_system::instance());
    }

    /**
     * Unset a conversation as a favourite for the given user.
     *
     * @param int $conversationid the id of the conversation to unset as a favourite.
     * @param int $userid the id to whom the favourite belongs.
     * @throws \moodle_exception if the favourite does not exist for the user.
     */
    public static function unset_favourite_conversation(int $conversationid, int $userid) {
        $ufservice = \core_favourites\service_factory::get_service_for_user_context(\context_user::instance($userid));
        $ufservice->delete_favourite('core_message', 'message_conversations', $conversationid, \context_system::instance());
    }

    /**
     * Returns the contacts to display in the contacts area.
     *
     * @param int $userid The user id
     * @param int $limitfrom
     * @param int $limitnum
     * @return array
     */
    public static function get_contacts($userid, $limitfrom = 0, $limitnum = 0) {
        global $DB;

        $contactids = [];
        $sql = "SELECT mc.*
                  FROM {message_contacts} mc
                 WHERE mc.userid = ? OR mc.contactid = ?
              ORDER BY timecreated DESC";
        if ($contacts = $DB->get_records_sql($sql, [$userid, $userid], $limitfrom, $limitnum)) {
            foreach ($contacts as $contact) {
                if ($userid == $contact->userid) {
                    $contactids[] = $contact->contactid;
                } else {
                    $contactids[] = $contact->userid;
                }
            }
        }

        if (!empty($contactids)) {
            list($insql, $inparams) = $DB->get_in_or_equal($contactids);

            $sql = "SELECT u.*, mub.id as isblocked
                      FROM {user} u
                 LEFT JOIN {message_users_blocked} mub
                        ON u.id = mub.blockeduserid
                     WHERE u.id $insql";
            if ($contacts = $DB->get_records_sql($sql, $inparams)) {
                $arrcontacts = [];
                foreach ($contacts as $contact) {
                    $contact->blocked = $contact->isblocked ? 1 : 0;
                    $arrcontacts[] = helper::create_contact($contact);
                }

                return $arrcontacts;
            }
        }

        return [];
    }

    /**
     * Returns the an array of the users the given user is in a conversation
     * with who are a contact and the number of unread messages.
     *
     * @param int $userid The user id
     * @param int $limitfrom
     * @param int $limitnum
     * @return array
     */
    public static function get_contacts_with_unread_message_count($userid, $limitfrom = 0, $limitnum = 0) {
        global $DB;

        $userfields = \user_picture::fields('u', array('lastaccess'));
        $unreadcountssql = "SELECT $userfields, count(m.id) as messagecount
                              FROM {message_contacts} mc
                        INNER JOIN {user} u
                                ON (u.id = mc.contactid OR u.id = mc.userid)
                         LEFT JOIN {messages} m
                                ON ((m.useridfrom = mc.contactid OR m.useridfrom = mc.userid) AND m.useridfrom != ?)
                         LEFT JOIN {message_conversation_members} mcm
                                ON mcm.conversationid = m.conversationid AND mcm.userid = ? AND mcm.userid != m.useridfrom
                         LEFT JOIN {message_user_actions} mua
                                ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                         LEFT JOIN {message_users_blocked} mub
                                ON (mub.userid = ? AND mub.blockeduserid = u.id)
                             WHERE mua.id is NULL
                               AND mub.id is NULL
                               AND (mc.userid = ? OR mc.contactid = ?)
                               AND u.id != ?
                               AND u.deleted = 0
                          GROUP BY $userfields";

        return $DB->get_records_sql($unreadcountssql, [$userid, $userid, $userid, self::MESSAGE_ACTION_READ,
            $userid, $userid, $userid, $userid], $limitfrom, $limitnum);
    }

    /**
     * Returns the an array of the users the given user is in a conversation
     * with who are not a contact and the number of unread messages.
     *
     * @param int $userid The user id
     * @param int $limitfrom
     * @param int $limitnum
     * @return array
     */
    public static function get_non_contacts_with_unread_message_count($userid, $limitfrom = 0, $limitnum = 0) {
        global $DB;

        $userfields = \user_picture::fields('u', array('lastaccess'));
        $unreadcountssql = "SELECT $userfields, count(m.id) as messagecount
                              FROM {user} u
                        INNER JOIN {messages} m
                                ON m.useridfrom = u.id
                        INNER JOIN {message_conversation_members} mcm
                                ON mcm.conversationid = m.conversationid
                         LEFT JOIN {message_user_actions} mua
                                ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                         LEFT JOIN {message_contacts} mc
                                ON (mc.userid = ? AND mc.contactid = u.id)
                         LEFT JOIN {message_users_blocked} mub
                                ON (mub.userid = ? AND mub.blockeduserid = u.id)
                             WHERE mcm.userid = ?
                               AND mcm.userid != m.useridfrom
                               AND mua.id is NULL
                               AND mub.id is NULL
                               AND mc.id is NULL
                               AND u.deleted = 0
                          GROUP BY $userfields";

        return $DB->get_records_sql($unreadcountssql, [$userid, self::MESSAGE_ACTION_READ, $userid, $userid, $userid],
            $limitfrom, $limitnum);
    }

    /**
     * Returns the messages to display in the message area.
     *
     * @param int $userid the current user
     * @param int $otheruserid the other user
     * @param int $limitfrom
     * @param int $limitnum
     * @param string $sort
     * @param int $timefrom the time from the message being sent
     * @param int $timeto the time up until the message being sent
     * @return array
     */
    public static function get_messages($userid, $otheruserid, $limitfrom = 0, $limitnum = 0,
        $sort = 'timecreated ASC', $timefrom = 0, $timeto = 0) {

        if (!empty($timefrom)) {
            // Check the cache to see if we even need to do a DB query.
            $cache = \cache::make('core', 'message_time_last_message_between_users');
            $key = helper::get_last_message_time_created_cache_key($otheruserid, $userid);
            $lastcreated = $cache->get($key);

            // The last known message time is earlier than the one being requested so we can
            // just return an empty result set rather than having to query the DB.
            if ($lastcreated && $lastcreated < $timefrom) {
                return [];
            }
        }

        $arrmessages = array();
        if ($messages = helper::get_messages($userid, $otheruserid, 0, $limitfrom, $limitnum,
                                             $sort, $timefrom, $timeto)) {

            $arrmessages = helper::create_messages($userid, $messages);
        }

        return $arrmessages;
    }

    /**
     * Returns the most recent message between two users.
     *
     * @param int $userid the current user
     * @param int $otheruserid the other user
     * @return \stdClass|null
     */
    public static function get_most_recent_message($userid, $otheruserid) {
        // We want two messages here so we get an accurate 'blocktime' value.
        if ($messages = helper::get_messages($userid, $otheruserid, 0, 0, 2, 'timecreated DESC')) {
            // Swap the order so we now have them in historical order.
            $messages = array_reverse($messages);
            $arrmessages = helper::create_messages($userid, $messages);
            return array_pop($arrmessages);
        }

        return null;
    }

    /**
     * Returns the profile information for a contact for a user.
     *
     * @param int $userid The user id
     * @param int $otheruserid The id of the user whose profile we want to view.
     * @return \stdClass
     */
    public static function get_profile($userid, $otheruserid) {
        global $CFG, $PAGE;

        require_once($CFG->dirroot . '/user/lib.php');

        $user = \core_user::get_user($otheruserid, '*', MUST_EXIST);

        // Create the data we are going to pass to the renderable.
        $data = new \stdClass();
        $data->userid = $otheruserid;
        $data->fullname = fullname($user);
        $data->city = '';
        $data->country = '';
        $data->email = '';
        $data->isonline = null;
        // Get the user picture data - messaging has always shown these to the user.
        $userpicture = new \user_picture($user);
        $userpicture->size = 1; // Size f1.
        $data->profileimageurl = $userpicture->get_url($PAGE)->out(false);
        $userpicture->size = 0; // Size f2.
        $data->profileimageurlsmall = $userpicture->get_url($PAGE)->out(false);

        $userfields = user_get_user_details($user, null, array('city', 'country', 'email', 'lastaccess'));
        if ($userfields) {
            if (isset($userfields['city'])) {
                $data->city = $userfields['city'];
            }
            if (isset($userfields['country'])) {
                $data->country = $userfields['country'];
            }
            if (isset($userfields['email'])) {
                $data->email = $userfields['email'];
            }
            if (isset($userfields['lastaccess'])) {
                $data->isonline = helper::is_online($userfields['lastaccess']);
            }
        }

        $data->isblocked = self::is_blocked($userid, $otheruserid);
        $data->iscontact = self::is_contact($userid, $otheruserid);

        return $data;
    }

    /**
     * Checks if a user can delete messages they have either received or sent.
     *
     * @param int $userid The user id of who we want to delete the messages for (this may be done by the admin
     *  but will still seem as if it was by the user)
     * @param int $conversationid The id of the conversation
     * @return bool Returns true if a user can delete the conversation, false otherwise.
     */
    public static function can_delete_conversation(int $userid, int $conversationid = null) : bool {
        global $USER;

        if (is_null($conversationid)) {
            debugging('\core_message\api::can_delete_conversation() now expects a \'conversationid\' to be passed.',
                DEBUG_DEVELOPER);
            return false;
        }

        $systemcontext = \context_system::instance();

        if (has_capability('moodle/site:deleteanymessage', $systemcontext)) {
            return true;
        }

        if (!self::is_user_in_conversation($userid, $conversationid)) {
            return false;
        }

        if (has_capability('moodle/site:deleteownmessage', $systemcontext) &&
                $USER->id == $userid) {
            return true;
        }

        return false;
    }

    /**
     * Deletes a conversation.
     *
     * This function does not verify any permissions.
     *
     * @deprecated since 3.6
     * @param int $userid The user id of who we want to delete the messages for (this may be done by the admin
     *  but will still seem as if it was by the user)
     * @param int $otheruserid The id of the other user in the conversation
     * @return bool
     */
    public static function delete_conversation($userid, $otheruserid) {
        debugging('\core_message\api::delete_conversation() is deprecated, please use ' .
            '\core_message\api::delete_conversation_by_id() instead.', DEBUG_DEVELOPER);

        $conversationid = self::get_conversation_between_users([$userid, $otheruserid]);

        // If there is no conversation, there is nothing to do.
        if (!$conversationid) {
            return true;
        }

        self::delete_conversation_by_id($userid, $conversationid);

        return true;
    }

    /**
     * Deletes a conversation for a specified user.
     *
     * This function does not verify any permissions.
     *
     * @param int $userid The user id of who we want to delete the messages for (this may be done by the admin
     *  but will still seem as if it was by the user)
     * @param int $conversationid The id of the other user in the conversation
     */
    public static function delete_conversation_by_id(int $userid, int $conversationid) {
        global $DB, $USER;

        // Get all messages belonging to this conversation that have not already been deleted by this user.
        $sql = "SELECT m.*
                 FROM {messages} m
           INNER JOIN {message_conversations} mc
                   ON m.conversationid = mc.id
            LEFT JOIN {message_user_actions} mua
                   ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                WHERE mua.id is NULL
                  AND mc.id = ?
             ORDER BY m.timecreated ASC";
        $messages = $DB->get_records_sql($sql, [$userid, self::MESSAGE_ACTION_DELETED, $conversationid]);

        // Ok, mark these as deleted.
        foreach ($messages as $message) {
            $mua = new \stdClass();
            $mua->userid = $userid;
            $mua->messageid = $message->id;
            $mua->action = self::MESSAGE_ACTION_DELETED;
            $mua->timecreated = time();
            $mua->id = $DB->insert_record('message_user_actions', $mua);

            \core\event\message_deleted::create_from_ids($userid, $USER->id,
                $message->id, $mua->id)->trigger();
        }
    }

    /**
     * Returns the count of unread conversations (collection of messages from a single user) for
     * the given user.
     *
     * @param \stdClass $user the user who's conversations should be counted
     * @return int the count of the user's unread conversations
     */
    public static function count_unread_conversations($user = null) {
        global $USER, $DB;

        if (empty($user)) {
            $user = $USER;
        }

        $sql = "SELECT COUNT(DISTINCT(m.conversationid))
                  FROM {messages} m
            INNER JOIN {message_conversations} mc
                    ON m.conversationid = mc.id
            INNER JOIN {message_conversation_members} mcm
                    ON mc.id = mcm.conversationid
             LEFT JOIN {message_user_actions} mua
                    ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                 WHERE mcm.userid = ?
                   AND mcm.userid != m.useridfrom
                   AND mua.id is NULL";

        return $DB->count_records_sql($sql, [$user->id, self::MESSAGE_ACTION_READ, $user->id]);
    }

    /**
     * Checks if a user can mark all messages as read.
     *
     * @param int $userid The user id of who we want to mark the messages for
     * @param int $conversationid The id of the conversation
     * @return bool true if user is permitted, false otherwise
     * @since 3.6
     */
    public static function can_mark_all_messages_as_read(int $userid, int $conversationid) : bool {
        global $USER;

        $systemcontext = \context_system::instance();

        if (has_capability('moodle/site:readallmessages', $systemcontext)) {
            return true;
        }

        if (!self::is_user_in_conversation($userid, $conversationid)) {
            return false;
        }

        if ($USER->id == $userid) {
            return true;
        }

        return false;
    }

    /**
     * Marks all messages being sent to a user in a particular conversation.
     *
     * If $conversationdid is null then it marks all messages as read sent to $userid.
     *
     * @param int $userid
     * @param int|null $conversationid The conversation the messages belong to mark as read, if null mark all
     */
    public static function mark_all_messages_as_read($userid, $conversationid = null) {
        global $DB;

        $messagesql = "SELECT m.*
                         FROM {messages} m
                   INNER JOIN {message_conversations} mc
                           ON mc.id = m.conversationid
                   INNER JOIN {message_conversation_members} mcm
                           ON mcm.conversationid = mc.id
                    LEFT JOIN {message_user_actions} mua
                           ON (mua.messageid = m.id AND mua.userid = ? AND mua.action = ?)
                        WHERE mua.id is NULL
                          AND mcm.userid = ?
                          AND m.useridfrom != ?";
        $messageparams = [];
        $messageparams[] = $userid;
        $messageparams[] = self::MESSAGE_ACTION_READ;
        $messageparams[] = $userid;
        $messageparams[] = $userid;
        if (!is_null($conversationid)) {
            $messagesql .= " AND mc.id = ?";
            $messageparams[] = $conversationid;
        }

        $messages = $DB->get_recordset_sql($messagesql, $messageparams);
        foreach ($messages as $message) {
            self::mark_message_as_read($userid, $message);
        }
        $messages->close();
    }

    /**
     * Marks all notifications being sent from one user to another user as read.
     *
     * If the from user is null then it marks all notifications as read sent to the to user.
     *
     * @param int $touserid the id of the message recipient
     * @param int|null $fromuserid the id of the message sender, null if all messages
     * @return void
     */
    public static function mark_all_notifications_as_read($touserid, $fromuserid = null) {
        global $DB;

        $notificationsql = "SELECT n.*
                              FROM {notifications} n
                             WHERE useridto = ?
                               AND timeread is NULL";
        $notificationsparams = [$touserid];
        if (!empty($fromuserid)) {
            $notificationsql .= " AND useridfrom = ?";
            $notificationsparams[] = $fromuserid;
        }

        $notifications = $DB->get_recordset_sql($notificationsql, $notificationsparams);
        foreach ($notifications as $notification) {
            self::mark_notification_as_read($notification);
        }
        $notifications->close();
    }

    /**
     * Marks ALL messages being sent from $fromuserid to $touserid as read.
     *
     * Can be filtered by type.
     *
     * @deprecated since 3.5
     * @param int $touserid the id of the message recipient
     * @param int $fromuserid the id of the message sender
     * @param string $type filter the messages by type, either MESSAGE_TYPE_NOTIFICATION, MESSAGE_TYPE_MESSAGE or '' for all.
     * @return void
     */
    public static function mark_all_read_for_user($touserid, $fromuserid = 0, $type = '') {
        debugging('\core_message\api::mark_all_read_for_user is deprecated. Please either use ' .
            '\core_message\api::mark_all_notifications_read_for_user or \core_message\api::mark_all_messages_read_for_user',
            DEBUG_DEVELOPER);

        $type = strtolower($type);

        $conversationid = null;
        $ignoremessages = false;
        if (!empty($fromuserid)) {
            $conversationid = self::get_conversation_between_users([$touserid, $fromuserid]);
            if (!$conversationid) { // If there is no conversation between the users then there are no messages to mark.
                $ignoremessages = true;
            }
        }

        if (!empty($type)) {
            if ($type == MESSAGE_TYPE_NOTIFICATION) {
                self::mark_all_notifications_as_read($touserid, $fromuserid);
            } else if ($type == MESSAGE_TYPE_MESSAGE) {
                if (!$ignoremessages) {
                    self::mark_all_messages_as_read($touserid, $conversationid);
                }
            }
        } else { // We want both.
            self::mark_all_notifications_as_read($touserid, $fromuserid);
            if (!$ignoremessages) {
                self::mark_all_messages_as_read($touserid, $conversationid);
            }
        }
    }

    /**
     * Returns message preferences.
     *
     * @param array $processors
     * @param array $providers
     * @param \stdClass $user
     * @return \stdClass
     * @since 3.2
     */
    public static function get_all_message_preferences($processors, $providers, $user) {
        $preferences = helper::get_providers_preferences($providers, $user->id);
        $preferences->userdefaultemail = $user->email; // May be displayed by the email processor.

        // For every processors put its options on the form (need to get function from processor's lib.php).
        foreach ($processors as $processor) {
            $processor->object->load_data($preferences, $user->id);
        }

        // Load general messaging preferences.
        $preferences->blocknoncontacts = self::get_user_privacy_messaging_preference($user->id);
        $preferences->mailformat = $user->mailformat;
        $preferences->mailcharset = get_user_preferences('mailcharset', '', $user->id);

        return $preferences;
    }

    /**
     * Count the number of users blocked by a user.
     *
     * @param \stdClass $user The user object
     * @return int the number of blocked users
     */
    public static function count_blocked_users($user = null) {
        global $USER, $DB;

        if (empty($user)) {
            $user = $USER;
        }

        $sql = "SELECT count(mub.id)
                  FROM {message_users_blocked} mub
                 WHERE mub.userid = :userid";
        return $DB->count_records_sql($sql, array('userid' => $user->id));
    }

    /**
     * Determines if a user is permitted to send another user a private message.
     * If no sender is provided then it defaults to the logged in user.
     *
     * @param \stdClass $recipient The user object.
     * @param \stdClass|null $sender The user object.
     * @return bool true if user is permitted, false otherwise.
     */
    public static function can_post_message($recipient, $sender = null) {
        global $USER;

        if (is_null($sender)) {
            // The message is from the logged in user, unless otherwise specified.
            $sender = $USER;
        }

        $systemcontext = \context_system::instance();
        if (!has_capability('moodle/site:sendmessage', $systemcontext, $sender)) {
            return false;
        }

        if (has_capability('moodle/site:readallmessages', $systemcontext, $sender->id)) {
            return true;
        }

        // Check if the recipient can be messaged by the sender.
        return (self::can_contact_user($recipient, $sender));
    }

    /**
     * Get the messaging preference for a user.
     * If the user has not any messaging privacy preference:
     * - When $CFG->messagingallusers = false the default user preference is MESSAGE_PRIVACY_COURSEMEMBER.
     * - When $CFG->messagingallusers = true the default user preference is MESSAGE_PRIVACY_SITE.
     *
     * @param  int    $userid The user identifier.
     * @return int    The default messaging preference.
     */
    public static function get_user_privacy_messaging_preference(int $userid) : int {
        global $CFG;

        // When $CFG->messagingallusers is enabled, default value for the messaging preference will be "Anyone on the site";
        // otherwise, the default value will be "My contacts and anyone in my courses".
        if (empty($CFG->messagingallusers)) {
            $defaultprefvalue = self::MESSAGE_PRIVACY_COURSEMEMBER;
        } else {
            $defaultprefvalue = self::MESSAGE_PRIVACY_SITE;
        }
        $privacypreference = get_user_preferences('message_blocknoncontacts', $defaultprefvalue, $userid);

        // When the $CFG->messagingallusers privacy setting is disabled, MESSAGE_PRIVACY_SITE is
        // also disabled, so it has to be replaced to MESSAGE_PRIVACY_COURSEMEMBER.
        if (empty($CFG->messagingallusers) && $privacypreference == self::MESSAGE_PRIVACY_SITE) {
            $privacypreference = self::MESSAGE_PRIVACY_COURSEMEMBER;
        }

        return $privacypreference;
    }

    /**
     * Checks if the recipient is allowing messages from users that aren't a
     * contact. If not then it checks to make sure the sender is in the
     * recipient's contacts.
     *
     * @deprecated since 3.6
     * @param \stdClass $recipient The user object.
     * @param \stdClass|null $sender The user object.
     * @return bool true if $sender is blocked, false otherwise.
     */
    public static function is_user_non_contact_blocked($recipient, $sender = null) {
        debugging('\core_message\api::is_user_non_contact_blocked() is deprecated', DEBUG_DEVELOPER);

        global $USER, $CFG;

        if (is_null($sender)) {
            // The message is from the logged in user, unless otherwise specified.
            $sender = $USER;
        }

        $privacypreference = self::get_user_privacy_messaging_preference($recipient->id);
        switch ($privacypreference) {
            case self::MESSAGE_PRIVACY_SITE:
                if (!empty($CFG->messagingallusers)) {
                    // Users can be messaged without being contacts or members of the same course.
                    break;
                }
                // When the $CFG->messagingallusers privacy setting is disabled, continue with the next
                // case, because MESSAGE_PRIVACY_SITE is replaced to MESSAGE_PRIVACY_COURSEMEMBER.
            case self::MESSAGE_PRIVACY_COURSEMEMBER:
                // Confirm the sender and the recipient are both members of the same course.
                if (enrol_sharing_course($recipient, $sender)) {
                    // All good, the recipient and the sender are members of the same course.
                    return false;
                }
            case self::MESSAGE_PRIVACY_ONLYCONTACTS:
                // True if they aren't contacts (they can't send a message because of the privacy settings), false otherwise.
                return !self::is_contact($sender->id, $recipient->id);
        }

        return false;
    }

    /**
     * Checks if the recipient has specifically blocked the sending user.
     *
     * Note: This function will always return false if the sender has the
     * readallmessages capability at the system context level.
     *
     * @deprecated since 3.6
     * @param int $recipientid User ID of the recipient.
     * @param int $senderid User ID of the sender.
     * @return bool true if $sender is blocked, false otherwise.
     */
    public static function is_user_blocked($recipientid, $senderid = null) {
        debugging('\core_message\api::is_user_blocked is deprecated and should not be used.',
            DEBUG_DEVELOPER);

        global $USER;

        if (is_null($senderid)) {
            // The message is from the logged in user, unless otherwise specified.
            $senderid = $USER->id;
        }

        $systemcontext = \context_system::instance();
        if (has_capability('moodle/site:readallmessages', $systemcontext, $senderid)) {
            return false;
        }

        if (self::is_blocked($recipientid, $senderid)) {
            return true;
        }

        return false;
    }

    /**
     * Get specified message processor, validate corresponding plugin existence and
     * system configuration.
     *
     * @param string $name  Name of the processor.
     * @param bool $ready only return ready-to-use processors.
     * @return mixed $processor if processor present else empty array.
     * @since Moodle 3.2
     */
    public static function get_message_processor($name, $ready = false) {
        global $DB, $CFG;

        $processor = $DB->get_record('message_processors', array('name' => $name));
        if (empty($processor)) {
            // Processor not found, return.
            return array();
        }

        $processor = self::get_processed_processor_object($processor);
        if ($ready) {
            if ($processor->enabled && $processor->configured) {
                return $processor;
            } else {
                return array();
            }
        } else {
            return $processor;
        }
    }

    /**
     * Returns weather a given processor is enabled or not.
     * Note:- This doesn't check if the processor is configured or not.
     *
     * @param string $name Name of the processor
     * @return bool
     */
    public static function is_processor_enabled($name) {

        $cache = \cache::make('core', 'message_processors_enabled');
        $status = $cache->get($name);

        if ($status === false) {
            $processor = self::get_message_processor($name);
            if (!empty($processor)) {
                $cache->set($name, $processor->enabled);
                return $processor->enabled;
            } else {
                return false;
            }
        }

        return $status;
    }

    /**
     * Set status of a processor.
     *
     * @param \stdClass $processor processor record.
     * @param 0|1 $enabled 0 or 1 to set the processor status.
     * @return bool
     * @since Moodle 3.2
     */
    public static function update_processor_status($processor, $enabled) {
        global $DB;
        $cache = \cache::make('core', 'message_processors_enabled');
        $cache->delete($processor->name);
        return $DB->set_field('message_processors', 'enabled', $enabled, array('id' => $processor->id));
    }

    /**
     * Given a processor object, loads information about it's settings and configurations.
     * This is not a public api, instead use @see \core_message\api::get_message_processor()
     * or @see \get_message_processors()
     *
     * @param \stdClass $processor processor object
     * @return \stdClass processed processor object
     * @since Moodle 3.2
     */
    public static function get_processed_processor_object(\stdClass $processor) {
        global $CFG;

        $processorfile = $CFG->dirroot. '/message/output/'.$processor->name.'/message_output_'.$processor->name.'.php';
        if (is_readable($processorfile)) {
            include_once($processorfile);
            $processclass = 'message_output_' . $processor->name;
            if (class_exists($processclass)) {
                $pclass = new $processclass();
                $processor->object = $pclass;
                $processor->configured = 0;
                if ($pclass->is_system_configured()) {
                    $processor->configured = 1;
                }
                $processor->hassettings = 0;
                if (is_readable($CFG->dirroot.'/message/output/'.$processor->name.'/settings.php')) {
                    $processor->hassettings = 1;
                }
                $processor->available = 1;
            } else {
                print_error('errorcallingprocessor', 'message');
            }
        } else {
            $processor->available = 0;
        }
        return $processor;
    }

    /**
     * Retrieve users blocked by $user1
     *
     * @param int $userid The user id of the user whos blocked users we are returning
     * @return array the users blocked
     */
    public static function get_blocked_users($userid) {
        global $DB;

        $userfields = \user_picture::fields('u', array('lastaccess'));
        $blockeduserssql = "SELECT $userfields
                              FROM {message_users_blocked} mub
                        INNER JOIN {user} u
                                ON u.id = mub.blockeduserid
                             WHERE u.deleted = 0
                               AND mub.userid = ?
                          GROUP BY $userfields
                          ORDER BY u.firstname ASC";
        return $DB->get_records_sql($blockeduserssql, [$userid]);
    }

    /**
     * Mark a single message as read.
     *
     * @param int $userid The user id who marked the message as read
     * @param \stdClass $message The message
     * @param int|null $timeread The time the message was marked as read, if null will default to time()
     */
    public static function mark_message_as_read($userid, $message, $timeread = null) {
        global $DB;

        if (is_null($timeread)) {
            $timeread = time();
        }

        $mua = new \stdClass();
        $mua->userid = $userid;
        $mua->messageid = $message->id;
        $mua->action = self::MESSAGE_ACTION_READ;
        $mua->timecreated = $timeread;
        $mua->id = $DB->insert_record('message_user_actions', $mua);

        // Get the context for the user who received the message.
        $context = \context_user::instance($userid, IGNORE_MISSING);
        // If the user no longer exists the context value will be false, in this case use the system context.
        if ($context === false) {
            $context = \context_system::instance();
        }

        // Trigger event for reading a message.
        $event = \core\event\message_viewed::create(array(
            'objectid' => $mua->id,
            'userid' => $userid, // Using the user who read the message as they are the ones performing the action.
            'context' => $context,
            'relateduserid' => $message->useridfrom,
            'other' => array(
                'messageid' => $message->id
            )
        ));
        $event->trigger();
    }

    /**
     * Mark a single notification as read.
     *
     * @param \stdClass $notification The notification
     * @param int|null $timeread The time the message was marked as read, if null will default to time()
     */
    public static function mark_notification_as_read($notification, $timeread = null) {
        global $DB;

        if (is_null($timeread)) {
            $timeread = time();
        }

        if (is_null($notification->timeread)) {
            $updatenotification = new \stdClass();
            $updatenotification->id = $notification->id;
            $updatenotification->timeread = $timeread;

            $DB->update_record('notifications', $updatenotification);

            // Trigger event for reading a notification.
            \core\event\notification_viewed::create_from_ids(
                $notification->useridfrom,
                $notification->useridto,
                $notification->id
            )->trigger();
        }
    }

    /**
     * Checks if a user can delete a message.
     *
     * @param int $userid the user id of who we want to delete the message for (this may be done by the admin
     *  but will still seem as if it was by the user)
     * @param int $messageid The message id
     * @return bool Returns true if a user can delete the message, false otherwise.
     */
    public static function can_delete_message($userid, $messageid) {
        global $DB, $USER;

        $systemcontext = \context_system::instance();

        $conversationid = $DB->get_field('messages', 'conversationid', ['id' => $messageid], MUST_EXIST);

        if (has_capability('moodle/site:deleteanymessage', $systemcontext)) {
            return true;
        }

        if (!self::is_user_in_conversation($userid, $conversationid)) {
            return false;
        }

        if (has_capability('moodle/site:deleteownmessage', $systemcontext) &&
                $USER->id == $userid) {
            return true;
        }

        return false;
    }

    /**
     * Deletes a message.
     *
     * This function does not verify any permissions.
     *
     * @param int $userid the user id of who we want to delete the message for (this may be done by the admin
     *  but will still seem as if it was by the user)
     * @param int $messageid The message id
     * @return bool
     */
    public static function delete_message($userid, $messageid) {
        global $DB, $USER;

        if (!$DB->record_exists('messages', ['id' => $messageid])) {
            return false;
        }

        // Check if the user has already deleted this message.
        if (!$DB->record_exists('message_user_actions', ['userid' => $userid,
                'messageid' => $messageid, 'action' => self::MESSAGE_ACTION_DELETED])) {
            $mua = new \stdClass();
            $mua->userid = $userid;
            $mua->messageid = $messageid;
            $mua->action = self::MESSAGE_ACTION_DELETED;
            $mua->timecreated = time();
            $mua->id = $DB->insert_record('message_user_actions', $mua);

            // Trigger event for deleting a message.
            \core\event\message_deleted::create_from_ids($userid, $USER->id,
                $messageid, $mua->id)->trigger();

            return true;
        }

        return false;
    }

    /**
     * Returns the conversation between two users.
     *
     * @param array $userids
     * @return int|bool The id of the conversation, false if not found
     */
    public static function get_conversation_between_users(array $userids) {
        global $DB;

        $hash = helper::get_conversation_hash($userids);

        $params = [
            'type' => self::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL,
            'convhash' => $hash
        ];
        if ($conversation = $DB->get_record('message_conversations', $params)) {
            return $conversation->id;
        }

        return false;
    }

    /**
     * Creates a conversation between two users.
     *
     * @deprecated since 3.6
     * @param array $userids
     * @return int The id of the conversation
     */
    public static function create_conversation_between_users(array $userids) {
        debugging('\core_message\api::create_conversation_between_users is deprecated, please use ' .
            '\core_message\api::create_conversation instead.', DEBUG_DEVELOPER);

        // This method was always used for individual conversations.
        $conversation = self::create_conversation(self::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL, $userids);

        return $conversation->id;
    }

    /**
     * Creates a conversation with selected users and messages.
     *
     * @param int $type The type of conversation
     * @param int[] $userids The array of users to add to the conversation
     * @param string $name The name of the conversation
     * @return \stdClass
     */
    public static function create_conversation(int $type, array $userids, string $name = null) {
        global $DB;

        // Sanity check.
        if ($type == self::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL) {
            if (count($userids) > 2) {
                throw new \moodle_exception('An individual conversation can not have more than two users.');
            }
        }

        $conversation = new \stdClass();
        $conversation->type = $type;
        $conversation->name = $name;
        $conversation->convhash = null;
        if ($type == self::MESSAGE_CONVERSATION_TYPE_INDIVIDUAL) {
            $conversation->convhash = helper::get_conversation_hash($userids);
        }
        $conversation->timecreated = time();
        $conversation->id = $DB->insert_record('message_conversations', $conversation);

        // Add users to this conversation.
        $arrmembers = [];
        foreach ($userids as $userid) {
            $member = new \stdClass();
            $member->conversationid = $conversation->id;
            $member->userid = $userid;
            $member->timecreated = time();
            $member->id = $DB->insert_record('message_conversation_members', $member);

            $arrmembers[] = $member;
        }

        $conversation->members = $arrmembers;

        return $conversation;
    }

    /**
     * Checks if a user can create a group conversation.
     *
     * @param int $userid The id of the user attempting to create the conversation
     * @param \context $context The context they are creating the conversation from, most likely course context
     * @return bool
     */
    public static function can_create_group_conversation(int $userid, \context $context) : bool {
        global $CFG;

        // If we can't message at all, then we can't create a conversation.
        if (empty($CFG->messaging)) {
            return false;
        }

        // We need to check they have the capability to create the conversation.
        return has_capability('moodle/course:creategroupconversations', $context, $userid);
    }

    /**
     * Checks if a user can create a contact request.
     *
     * @param int $userid The id of the user who is creating the contact request
     * @param int $requesteduserid The id of the user being requested
     * @return bool
     */
    public static function can_create_contact(int $userid, int $requesteduserid) : bool {
        global $CFG;

        // If we can't message at all, then we can't create a contact.
        if (empty($CFG->messaging)) {
            return false;
        }

        // If we can message anyone on the site then we can create a contact.
        if ($CFG->messagingallusers) {
            return true;
        }

        // We need to check if they are in the same course.
        return enrol_sharing_course($userid, $requesteduserid);
    }

    /**
     * Handles creating a contact request.
     *
     * @param int $userid The id of the user who is creating the contact request
     * @param int $requesteduserid The id of the user being requested
     */
    public static function create_contact_request(int $userid, int $requesteduserid) {
        global $DB;

        $request = new \stdClass();
        $request->userid = $userid;
        $request->requesteduserid = $requesteduserid;
        $request->timecreated = time();

        $DB->insert_record('message_contact_requests', $request);

        // Send a notification.
        $userfrom = \core_user::get_user($userid);
        $userfromfullname = fullname($userfrom);
        $userto = \core_user::get_user($requesteduserid);
        $url = new \moodle_url('/message/pendingcontactrequests.php');

        $subject = get_string('messagecontactrequestsnotificationsubject', 'core_message', $userfromfullname);
        $fullmessage = get_string('messagecontactrequestsnotification', 'core_message', $userfromfullname);

        $message = new \core\message\message();
        $message->courseid = SITEID;
        $message->component = 'moodle';
        $message->name = 'messagecontactrequests';
        $message->notification = 1;
        $message->userfrom = $userfrom;
        $message->userto = $userto;
        $message->subject = $subject;
        $message->fullmessage = text_to_html($fullmessage);
        $message->fullmessageformat = FORMAT_HTML;
        $message->fullmessagehtml = $fullmessage;
        $message->smallmessage = '';
        $message->contexturl = $url->out(false);

        message_send($message);
    }


    /**
     * Handles confirming a contact request.
     *
     * @param int $userid The id of the user who created the contact request
     * @param int $requesteduserid The id of the user confirming the request
     */
    public static function confirm_contact_request(int $userid, int $requesteduserid) {
        global $DB;

        if ($request = $DB->get_record('message_contact_requests', ['userid' => $userid,
                'requesteduserid' => $requesteduserid])) {
            self::add_contact($userid, $requesteduserid);

            $DB->delete_records('message_contact_requests', ['id' => $request->id]);
        }
    }

    /**
     * Handles declining a contact request.
     *
     * @param int $userid The id of the user who created the contact request
     * @param int $requesteduserid The id of the user declining the request
     */
    public static function decline_contact_request(int $userid, int $requesteduserid) {
        global $DB;

        if ($request = $DB->get_record('message_contact_requests', ['userid' => $userid,
                'requesteduserid' => $requesteduserid])) {
            $DB->delete_records('message_contact_requests', ['id' => $request->id]);
        }
    }

    /**
     * Handles returning the contact requests for a user.
     *
     * This also includes the user data necessary to display information
     * about the user.
     *
     * It will not include blocked users.
     *
     * @param int $userid
     * @return array The list of contact requests
     */
    public static function get_contact_requests(int $userid) : array {
        global $DB;

        // Used to search for contacts.
        $ufields = \user_picture::fields('u');

        $sql = "SELECT $ufields, mcr.id as contactrequestid
                  FROM {user} u
                  JOIN {message_contact_requests} mcr
                    ON u.id = mcr.userid
             LEFT JOIN {message_users_blocked} mub
                    ON (mub.userid = ? AND mub.blockeduserid = u.id)
                 WHERE mcr.requesteduserid = ?
                   AND u.deleted = 0
                   AND mub.id is NULL
              ORDER BY mcr.timecreated DESC";

        return $DB->get_records_sql($sql, [$userid, $userid]);
    }

    /**
     * Handles adding a contact.
     *
     * @param int $userid The id of the user who requested to be a contact
     * @param int $contactid The id of the contact
     */
    public static function add_contact(int $userid, int $contactid) {
        global $DB;

        $messagecontact = new \stdClass();
        $messagecontact->userid = $userid;
        $messagecontact->contactid = $contactid;
        $messagecontact->timecreated = time();
        $messagecontact->id = $DB->insert_record('message_contacts', $messagecontact);

        $eventparams = [
            'objectid' => $messagecontact->id,
            'userid' => $userid,
            'relateduserid' => $contactid,
            'context' => \context_user::instance($userid)
        ];
        $event = \core\event\message_contact_added::create($eventparams);
        $event->add_record_snapshot('message_contacts', $messagecontact);
        $event->trigger();
    }

    /**
     * Handles removing a contact.
     *
     * @param int $userid The id of the user who is removing a user as a contact
     * @param int $contactid The id of the user to be removed as a contact
     */
    public static function remove_contact(int $userid, int $contactid) {
        global $DB;

        if ($contact = self::get_contact($userid, $contactid)) {
            $DB->delete_records('message_contacts', ['id' => $contact->id]);

            $event = \core\event\message_contact_removed::create(array(
                'objectid' => $contact->id,
                'userid' => $userid,
                'relateduserid' => $contactid,
                'context' => \context_user::instance($userid)
            ));
            $event->add_record_snapshot('message_contacts', $contact);
            $event->trigger();
        }
    }

    /**
     * Handles blocking a user.
     *
     * @param int $userid The id of the user who is blocking
     * @param int $usertoblockid The id of the user being blocked
     */
    public static function block_user(int $userid, int $usertoblockid) {
        global $DB;

        $blocked = new \stdClass();
        $blocked->userid = $userid;
        $blocked->blockeduserid = $usertoblockid;
        $blocked->timecreated = time();
        $blocked->id = $DB->insert_record('message_users_blocked', $blocked);

        // Trigger event for blocking a contact.
        $event = \core\event\message_user_blocked::create(array(
            'objectid' => $blocked->id,
            'userid' => $userid,
            'relateduserid' => $usertoblockid,
            'context' => \context_user::instance($userid)
        ));
        $event->add_record_snapshot('message_users_blocked', $blocked);
        $event->trigger();
    }

    /**
     * Handles unblocking a user.
     *
     * @param int $userid The id of the user who is unblocking
     * @param int $usertounblockid The id of the user being unblocked
     */
    public static function unblock_user(int $userid, int $usertounblockid) {
        global $DB;

        if ($blockeduser = $DB->get_record('message_users_blocked',
                ['userid' => $userid, 'blockeduserid' => $usertounblockid])) {
            $DB->delete_records('message_users_blocked', ['id' => $blockeduser->id]);

            // Trigger event for unblocking a contact.
            $event = \core\event\message_user_unblocked::create(array(
                'objectid' => $blockeduser->id,
                'userid' => $userid,
                'relateduserid' => $usertounblockid,
                'context' => \context_user::instance($userid)
            ));
            $event->add_record_snapshot('message_users_blocked', $blockeduser);
            $event->trigger();
        }
    }

    /**
     * Checks if users are already contacts.
     *
     * @param int $userid The id of one of the users
     * @param int $contactid The id of the other user
     * @return bool Returns true if they are a contact, false otherwise
     */
    public static function is_contact(int $userid, int $contactid) : bool {
        global $DB;

        $sql = "SELECT id
                  FROM {message_contacts} mc
                 WHERE (mc.userid = ? AND mc.contactid = ?)
                    OR (mc.userid = ? AND mc.contactid = ?)";
        return $DB->record_exists_sql($sql, [$userid, $contactid, $contactid, $userid]);
    }

    /**
     * Returns the row in the database table message_contacts that represents the contact between two people.
     *
     * @param int $userid The id of one of the users
     * @param int $contactid The id of the other user
     * @return mixed A fieldset object containing the record, false otherwise
     */
    public static function get_contact(int $userid, int $contactid) {
        global $DB;

        $sql = "SELECT mc.*
                  FROM {message_contacts} mc
                 WHERE (mc.userid = ? AND mc.contactid = ?)
                    OR (mc.userid = ? AND mc.contactid = ?)";
        return $DB->get_record_sql($sql, [$userid, $contactid, $contactid, $userid]);
    }

    /**
     * Checks if a user is already blocked.
     *
     * @param int $userid
     * @param int $blockeduserid
     * @return bool Returns true if they are a blocked, false otherwise
     */
    public static function is_blocked(int $userid, int $blockeduserid) : bool {
        global $DB;

        return $DB->record_exists('message_users_blocked', ['userid' => $userid, 'blockeduserid' => $blockeduserid]);
    }

    /**
     * Checks if a contact request already exists between users.
     *
     * @param int $userid The id of the user who is creating the contact request
     * @param int $requesteduserid The id of the user being requested
     * @return bool Returns true if a contact request exists, false otherwise
     */
    public static function does_contact_request_exist(int $userid, int $requesteduserid) : bool {
        global $DB;

        $sql = "SELECT id
                  FROM {message_contact_requests} mcr
                 WHERE (mcr.userid = ? AND mcr.requesteduserid = ?)
                    OR (mcr.userid = ? AND mcr.requesteduserid = ?)";
        return $DB->record_exists_sql($sql, [$userid, $requesteduserid, $requesteduserid, $userid]);
    }

    /**
     * Checks if a user is already in a conversation.
     *
     * @param int $userid The id of the user we want to check if they are in a group
     * @param int $conversationid The id of the conversation
     * @return bool Returns true if a contact request exists, false otherwise
     */
    public static function is_user_in_conversation(int $userid, int $conversationid) : bool {
        global $DB;

        return $DB->record_exists('message_conversation_members', ['conversationid' => $conversationid,
            'userid' => $userid]);
    }

    /**
     * Checks if the sender can message the recipient.
     *
     * @param \stdClass $recipient The user object.
     * @param \stdClass $sender The user object.
     * @return bool true if recipient hasn't blocked sender and sender can contact to recipient, false otherwise.
     */
    protected static function can_contact_user(\stdClass $recipient, \stdClass $sender) : bool {
        if (has_capability('moodle/site:messageanyuser', \context_system::instance(), $sender->id)) {
            // The sender has the ability to contact any user across the entire site.
            return true;
        }

        // The initial value of $cancontact is null to indicate that a value has not been determined.
        $cancontact = null;

        if (self::is_blocked($recipient->id, $sender->id)) {
            // The recipient has specifically blocked this sender.
            $cancontact = false;
        }

        $sharedcourses = null;
        if (null === $cancontact) {
            // There are three user preference options:
            // - Site: Allow anyone not explicitly blocked to contact me;
            // - Course members: Allow anyone I am in a course with to contact me; and
            // - Contacts: Only allow my contacts to contact me.
            //
            // The Site option is only possible when the messagingallusers site setting is also enabled.

            $privacypreference = self::get_user_privacy_messaging_preference($recipient->id);
            if (self::MESSAGE_PRIVACY_SITE === $privacypreference) {
                // The user preference is to allow any user to contact them.
                // No need to check anything else.
                $cancontact = true;
            } else {
                // This user only allows their own contacts, and possibly course peers, to contact them.
                // If the users are contacts then we can avoid the more expensive shared courses check.
                $cancontact = self::is_contact($sender->id, $recipient->id);

                if (!$cancontact && self::MESSAGE_PRIVACY_COURSEMEMBER === $privacypreference) {
                    // The users are not contacts and the user allows course member messaging.
                    // Check whether these two users share any course together.
                    $sharedcourses = enrol_get_shared_courses($recipient->id, $sender->id, true);
                    $cancontact = (!empty($sharedcourses));
                }
            }
        }

        if (false === $cancontact) {
            // At the moment the users cannot contact one another.
            // Check whether the messageanyuser capability applies in any of the shared courses.
            // This is intended to allow teachers to message students regardless of message settings.

            // Note: You cannot use empty($sharedcourses) here because this may be an empty array.
            if (null === $sharedcourses) {
                $sharedcourses = enrol_get_shared_courses($recipient->id, $sender->id, true);
            }

            foreach ($sharedcourses as $course) {
                // Note: enrol_get_shared_courses will preload any shared context.
                if (has_capability('moodle/site:messageanyuser', \context_course::instance($course->id), $sender->id)) {
                    $cancontact = true;
                    break;
                }
            }
        }

        return $cancontact;
    }

    /**
     * Add some new members to an existing conversation.
     *
     * @param array $userids User ids array to add as members.
     * @param int $convid The conversation id. Must exists.
     * @throws \dml_missing_record_exception If convid conversation doesn't exist
     * @throws \dml_exception If there is a database error
     * @throws \moodle_exception If trying to add a member(s) to a non-group conversation
     */
    public static function add_members_to_conversation(array $userids, int $convid) {
        global $DB;

        $conversation = $DB->get_record('message_conversations', ['id' => $convid], '*', MUST_EXIST);

        // We can only add members to a group conversation.
        if ($conversation->type != self::MESSAGE_CONVERSATION_TYPE_GROUP) {
            throw new \moodle_exception('You can not add members to a non-group conversation.');
        }

        // Be sure we are not trying to add a non existing user to the conversation. Work only with existing users.
        list($useridcondition, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
        $existingusers = $DB->get_fieldset_select('user', 'id', "id $useridcondition", $params);

        // Be sure we are not adding a user is already member of the conversation. Take all the members.
        $memberuserids = array_values($DB->get_records_menu(
            'message_conversation_members', ['conversationid' => $convid], 'id', 'id, userid')
        );

        // Work with existing new members.
        $members = array();
        $newuserids = array_diff($existingusers, $memberuserids);
        foreach ($newuserids as $userid) {
            $member = new \stdClass();
            $member->conversationid = $convid;
            $member->userid = $userid;
            $member->timecreated = time();
            $members[] = $member;
        }

        $DB->insert_records('message_conversation_members', $members);
    }

    /**
     * Remove some members from an existing conversation.
     *
     * @param array $userids The user ids to remove from conversation members.
     * @param int $convid The conversation id. Must exists.
     * @throws \dml_exception
     * @throws \moodle_exception If trying to remove a member(s) from a non-group conversation
     */
    public static function remove_members_from_conversation(array $userids, int $convid) {
        global $DB;

        $conversation = $DB->get_record('message_conversations', ['id' => $convid], '*', MUST_EXIST);

        if ($conversation->type != self::MESSAGE_CONVERSATION_TYPE_GROUP) {
            throw new \moodle_exception('You can not remove members from a non-group conversation.');
        }

        list($useridcondition, $params) = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
        $params['convid'] = $convid;

        $DB->delete_records_select('message_conversation_members',
            "conversationid = :convid AND userid $useridcondition", $params);
    }

    /**
     * Count conversation members.
     *
     * @param int $convid The conversation id.
     * @return int Number of conversation members.
     * @throws \dml_exception
     */
    public static function count_conversation_members(int $convid) : int {
        global $DB;

        return $DB->count_records('message_conversation_members', ['conversationid' => $convid]);
    }
}
