<?php
namespace local_ldap_connection\task;

defined('MOODLE_INTERNAL') || die();

class suspend_inactive_users extends \core\task\scheduled_task {
    public function get_name() {
        return get_string('suspend_inactive_users', 'local_LDAP_connection');
    }

    public function execute() {
        global $DB;


        $ninety_days_ago = time() - (90 * 24 * 60 * 60); // Dit is onze tijd - 90 dagen in unix tijd

        // Try om foutmeldingen af te vangen
        try {

            // Ophalen van de gebruikers die langer dan 90 dagen geleden zijn ingelogd. En nog niet zijn gedeactiveerd.
            $users = $DB->get_records_select('user', 'lastaccess < :lastaccess AND suspended = 0', array('lastaccess' => $ninety_days_ago));
            mtrace("{$users[0]}");
            // Het ophalen van alle id's van de gebruikers uit de $users lijst
            $user_ids = array_keys($users);

            // Als de lijst met gebruikers niet leeg is de bulk aanpassing doen
            if (!empty($users)) {

                // Converteer de lijst met indexen naar een lijst dat te gebruiken is door sql -> (1,2,3,4,...)
                list($in_sql, $params) = $DB->get_in_or_equal($user_ids);

                // Bulk-updaten van de gebruikers
                 $sql = "UPDATE {user} SET suspended = 1 WHERE id $in_sql";
                 $DB->execute($sql, $params);

                 mtrace("Aanpassen van de gebruikers was succesvol");

            }
            else {

                // Als de lijst wel leeg is niks doen
                mtrace("Geen gebruikers gevonden die in aanmerking komen");

            }
        }
        catch (dml_exception $e) {

            mtrace("Fout bij het bijwerken van gebruikers: " . $e->getMessage());

        }
    }
}
