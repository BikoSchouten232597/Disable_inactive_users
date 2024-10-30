# Functioneel Ontwerp - LDAP Connection Plugin

## 1. Inleiding

De LDAP Connection plugin is een Moodle-plugin voor het beheer van gebruikers. Door deze plugin wordt gecontroleerd welke gebruikers al langere tijd inactief zijn, en gebruikers die meer dan 90 dagen niet hebben ingelogd, worden automatisch op inactief gezet. Dit helpt om de gebruikersadministratie up-to-date te houden en het aantal actieve gebruikers overzichtelijk te beheren.

## 2. Doelstellingen van de Plugin

- Het automatisch deactiveren van gebruikers die een bepaalde periode inactief zijn, waardoor de Moodle-administratie eenvoudiger te beheren is.
- Periodieke controle van inactieve gebruikers zonder handmatige ingrepen van beheerders.
- Een flexibel systeem dat beheerders toelaat de frequentie van deze controle aan te passen.

## 3. Gebruikersrollen en Rechten

- **Beheerders**:
  - Hebben toegang tot het configureren van de plugin, inclusief het instellen van de frequentie waarmee de cron-taak wordt uitgevoerd.
  - Kunnen logbestanden bekijken voor feedback over welke gebruikers geschorst zijn door de plugin.
- **Gebruikers**:
  - Gebruikers worden passief beïnvloed door de plugin; zij hebben geen toegang tot instellingen maar kunnen geschorst worden indien zij 90 dagen of langer inactief zijn.

## 4. Hoofdfuncties en Functionaliteiten

### 4.1 Cron-taak voor Inactieve Gebruikers

- **Omschrijving**: De plugin bevat een cron-taak die periodiek wordt uitgevoerd en controleert welke gebruikers al langer dan 90 dagen niet hebben ingelogd.
- **Actie**: Gebruikers die meer dan 90 dagen inactief zijn en nog niet zijn geschorst, worden automatisch geschorst door de plugin.
- **Frequentie**: Standaard wordt de taak maandelijks uitgevoerd op de eerste van de maand. Beheerders kunnen de frequentie aanpassen via de `tasks.php` configuratie.

### 4.2 Logging en Feedback

- **Omschrijving**: Bij elke uitvoering van de cron-taak genereert de plugin logberichten voor feedback en inzicht.
- **Acties**:
  - Bij een succesvolle uitvoering: geeft een logbericht aan hoeveel en welke gebruikers zijn bijgewerkt.
  - Bij een foutmelding: logt de plugin de foutmelding, zodat de beheerder het probleem kan onderzoeken.

### 4.3 Aanpasbare Frequentie

- **Omschrijving**: De plugin maakt het mogelijk om de frequentie van de cron-taak aan te passen aan de behoeften van de organisatie.
- **Acties**:
  - Beheerders kunnen de instellingen in `tasks.php` wijzigen om de taak bijvoorbeeld wekelijks of maandelijks uit te voeren. Of op de website van Moodle onder server > scheduled tasks en dan het tandwieljte bij de juiste taak (LDAP connection plugin)

## 5. Technische Randvoorwaarden

- **Moodle Versie**: De plugin is compatibel met de laatste Moodle-versie
- **Database**: Ondersteuning voor de Moodle Database API voor compatibiliteit met verschillende databases.

## 6. Gebruiksscenario's

### 6.1 Scenario 1: Maandelijkse Controle van Inactieve Gebruikers

1. **Trigger**: De cron-taak draait elke 1e van de maand om middernacht.
2. **Voorwaarden**: Er zijn gebruikers in het systeem die langer dan 90 dagen niet hebben ingelogd en nog niet geschorst zijn.
3. **Actie**: De plugin controleert alle gebruikers, selecteert degenen die 90 dagen inactief zijn en zet hun `suspended`-status op `1`.
4. **Resultaat**: Alle gebruikers die inactief zijn voor meer dan 90 dagen worden geschorst en beheerders ontvangen feedback via de logbestanden.

### 6.2 Scenario 2: Foutmelding bij Uitvoering van de Taak

1. **Trigger**: De cron-taak draait op een ingesteld tijdstip.
2. **Voorwaarden**: Een databasefout of andere uitzondering voorkomt dat de taak succesvol wordt uitgevoerd.
3. **Actie**: De plugin vangt de foutmelding op in een `try-catch` blok en logt de foutmelding.
4. **Resultaat**: De beheerder ontvangt feedback over de fout via de Moodle-logs of de cron-uitvoer.

## 7. Functionele Eisen

- **Automatische schorsing van inactieve gebruikers**: De plugin moet gebruikers automatisch schorsen na 90 dagen inactiviteit.
- **Flexibele frequentie-instelling**: Beheerders moeten de mogelijkheid hebben om de cron-frequentie aan te passen.
- **Logging**: De plugin moet logmeldingen genereren voor succesvolle en mislukte taken.

## 8. Niet-Functionele Eisen

- **Prestaties**: De taak moet efficiënt omgaan met grote aantallen gebruikers.
- **Veiligheid**: De plugin maakt gebruik van de Moodle Database API om SQL-injectie te voorkomen.
- **Compatibiliteit**: De plugin moet werken op alle door Moodle ondersteunde databases en PHP-versies.
