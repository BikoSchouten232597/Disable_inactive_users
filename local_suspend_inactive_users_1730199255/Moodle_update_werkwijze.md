# Werkwijze bij een Moodle update
Als moodle een update uitvoert dienen de volgende punten gecontroleerd te worden voor het blijven functioneren van de plugin.

## 1.  Controleer Compatibiliteit van de Plugin.
Controleer of de volgende functies nog worden ondersteund door de [Moodle Data Manipulation API.](https://moodledev.io/docs/4.4/apis/core/dml)   :
- get_records_select()
- get_in_or_equal()
- execute()

## 2. Controleer de Cron taak.
- Ga naar www.jouwmoodlesite.com/admin/tool/task/scheduledtasks.php en kijk of de taak nog in de lijst voorkomt.
- (Indien mogelijk) Voer de taak handmatig uit en controleer de logs op foutmeldingen.
