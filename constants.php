<?php
// Conversioni di uso comune
// Inizio
  // Nomi dei giorni
  $days = array(
    "Domenica",
    "Lunedì",
    "Martedì",
    "Mercoledì",
    "Giovedì",
    "Venerdì",
    "Sabato"
  );

  // Nomi dei giorni (3 caratteri)
  $days_short = array("Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom");

  // Sostantivi divisi per maschili e femminili
  $female_words = array(
    "activity",
    "club",
    "game",
    "image",
    "party",
    "roster",
    "team",
    "town"
  );

  // Estensioni dei file ammessi
  $file_extensions = array(
    "image" => ["jpg", "jpeg", "png", "gif", "bmp", "tiff", "svg"],
    "video" => ["mp4", "avi", "mov", "wmv", "flv", "mkv", "webm"],
    "audio" => ["mp3", "wav", "ogg", "flac", "aac", "wma", "m4a"]
  );

  // Generale
  $lang_it = array(
    "account" => "Profilo",
    "accounts" => "Profili",
    "activity" => "Attività",
    "activities" => "Attività",
    "admin" => "Amministratore",
    "all" => "Tutto",
    "all m s" => "Tutto",
    "all f s" => "Tutta",
    "all m p" => "Tutti",
    "all f p" => "Tutte",
    "athlete" => "Atleta",
    "athletes" => "Atleti",
    "assistant" => "Assistente",
    "assistants" => "Assistenti",
    "associated teams" => "Squadre associate",
    "athletic" => "Atletico",
    "book" => "Segreteria",
    "brainstorming" => "Riunione societaria",
    "calendar" => "Calendario",
    "carried out m s" => "Effettuato",
    "carried out f s" => "Effettuata",
    "carried out m p" => "Effettuati",
    "carried out f p" => "Effettuate",
    "championship" => "Campionato",
    "championships" => "Campionati",
    "club" => "Società",
    "clubs" => "Società",
    "coach" => "Coach",
    "coaches" => "Coaches",
    "contact details" => "Recapiti",
    "cup" => "Coppa",
    "cups" => "Coppe",
    "current month" => "Corrente mese",
    "current week" => "Settimana corrente",
    "date" => "Data",
    "date_on" => "Data",
    "dates" => "Date",
    "delete" => "Elimina",
    "document" => "Documento",
    "documents" => "Documenti",
    "documentation" => "Documentazione",
    "edit" => "Modifica",
    "event" => "Evento",
    "events" => "Eventi",
    "field" => "Campo di gioco",
    "fields" => "Campi di gioco",
    "file" => "Documento",
    "files" => "Documenti",
    "first f s" => "Prima",
    "first m s" => "Primo",
    "first f p" => "Prime",
    "first m p" => "Primi",
    "friendly" => "Amichevole",
    "friendlys" => "Amichevoli",
    "from start season" => "Da inizio stagione",
    "game" => "Partita",
    "games" => "Partite",
    "handled m s" => "Gestito",
    "handled f s" => "Gestita",
    "handled m p" => "Gestiti",
    "handled f p" => "Gestite",
    "image" => "Immagine",
    "images" => "Immagini",
    "late" => "Ritardo",
    "lates" => "Ritardi",
    "manager" => "Dirigente",
    "managers" => "Dirigenti",
    "main data" => "Dati principali",
    "media" => "Media",
    "meeting" => "Meeting",
    "missing" => "Assente",
    "missings" => "Assenze",
    "morning" => "Mattina",
    "name" => "Nome",
    "names" => "Nomi",
    "name-last" => "Cognome",
    "name-first" => "Nome",
    "only events" => "Solo eventi",
    "only games" => "Solo partite",
    "only trainings" => "Solo allenamenti",
    "other f" => "Altra",
    "other m" => "Altro",
    "others f" => "Altre",
    "others m" => "Altri",
    "party" => "Festa",
    "parties" => "Feste",
    "per percentage" => "%",
    "period" => "Periodo",
    "personal data" => "Dati anagrafici",
    "player f" => "Giocatrice",
    "player" => "Giocatore",
    "players f" => "Giocatrici",
    "players" => "Giocatori",
    "presence" => "Presenza",
    "presences" => "Presenze",
    "presences_event" => "Presenze evento",
    "presences_game" => "Presenze partita",
    "presences_training" => "Presenze allenamento",
    "present" => "Presente",
    "preview month" => "Mese precedente",
    "other" => "Altro",
    "others" => "Altri",
    "ranking" => "Classifica",
    "registry" => "Anagrafica",
    "report" => "Report",
    "report_payments" => "Pagamenti",
    "report_presences" => "Statistiche",
    "report_qualifications" => "Idoneità",
    "roster" => "Formazione",
    "rosters" => "Formazioni",
    "scheduled m s" => "Programmato",
    "scheduled f s" => "Programmata",
    "scheduled m p" => "Programmati",
    "scheduled f p" => "Programmate",
    "screen" => "Schermo",
    "screens" => "Schermi",
    "season" => "Stagione",
    "seasons" => "Stagioni",
    "sport agg m s" => "Sportivo",
    "staff" => "Staff",
    "team" => "Squadra",
    "teams" => "Squadre",
    "technique" => "Tecnico",
    "time" => "Orario",
    "time start" => "Orario di inizio",
    "time stop" => "Orario di fine",
    "total" => "Totale",
    "town" => "Città",
    "training" => "Allenamento",
    "trainings" => "Allenamenti",
    "trophy" => "Torneo",
    "trophies" => "Tornei",
    "type", "Tipo",
    "video" => "Video",
    "videos" => "Video"
  );

  // Mesi
  $months = array(
    "Gennaio",
    "Febbraio",
    "Marzo",
    "Aprile",
    "Maggio",
    "Giugno",
    "Luglio",
    "Agosto",
    "Settembre",
    "Ottobre",
    "Novembre",
    "Dicembre"
  );

  // Ordine visualizzazione dei settori
  $sector_order = array("senior", "youth", "minibasket");

  // Chiave = valore
  $team_category_values = array(
    'Amatoriale',
    'Pulcini',
    'Scoiattoli',
    'Aquilotti',
    'Esordienti',
    'Under 13',
    'Under 14',
    'Under 15',
    'Under 16',
    'Under 17',
    'Under 18',
    'Under 19',
    'Under 20',
    'Senior'
  );

  // Chiave = valore
  $team_level_values = array(
    'Campino',
    'Arci/Uisp',
    'Unica',
    'Silver',
    'Gold',
    'Elite',
    'Eccellenza',
    'Divisione 4',
    'Divisione 3',
    'Divisione 2',
    'Divisione 1',
    'Serie C',
    'Serie B i',
    'Serie B n',
    'Serie A2',
    'Serie A'
  );

  // Chiave = valore
  $team_composition_values = array(
    'carrozzina',
    'femminile',
    'mista',
    'maschile'
  );

  // Aree e Sezioni
  $vb = array(
    "activity" => array("event", "game", "training"),
    "book" => array("account", "club", "field", "team"),
    "media" => array("file", "image", "screen", "video"),
    "report" => array("report_qualifications", "report_presences", "report_payments")
  );
// Fine

  // Parametri dei btn-icon
  $btn_params = array(
    "new" => array("color" => "success", "icon_class" => "bi bi-plus-lg", "disabled" => false),
    "edit" => array("color" => "primary", "icon_class" => "bi bi-pencil", "disabled" => true),
    "delete" => array("color" => "danger", "icon_class" => "bi bi-trash3", "disabled" => true),
    "print" => array("color" => "primary", "icon_class" => "bi bi-printer", "disabled" => false),
    "save" => array("color" => "success", "icon_class" => "bi bi-floppy", "disabled" => true)
  );

// Dropdown: Inizio
  // Opzioni Campo di allenamento
  $field_options = array(
    array("value" => "1", "label" => "Pieraccini", "icon_class" => "1-square-fill"),
    array("value" => "2", "label" => "Altobelli", "icon_class" => "2-square-fill")
  );

  // Liste valore, nome delle colonne e attributi della dropdown Frequenza
  $frequence_attributes = array(
    "btn_color" => "btn-primary"
  );
  $frequence_options = array(
    array("value" => "once", "label" => "Una volta"),
    array("value" => "week_once", "label" => "Uno alla settimana"),
    array("value" => "week_work", "label" => "Solo feriali"),
    array("value" => "week_end", "label" => "Solo festivi"),
    array("value" => "daily", "label" => "Ogni giorno")
  );

  // Liste valore, nome delle colonne e attributi della dropdown Frequenza
  $week_day_attributes = array(
    "btn_color" => "btn-primary"
  );
  $week_day_options = array(
    array("value" => 0, "label" => $days[0]),
    array("value" => 1, "label" => $days[1]),
    array("value" => 2, "label" => $days[2]),
    array("value" => 3, "label" => $days[3]),
    array("value" => 4, "label" => $days[4]),
    array("value" => 5, "label" => $days[5]),
    array("value" => 6, "label" => $days[6])
  );
// Fine

  // Elenco degli objectable
  $objectable_models = array("account", "club", "event", "field", "screen", "team", "training");

  // Liste valore, nome delle colonne Anagrafica
  $registry_column_opts = array(
    array("value" => "account-type", "label" => "Account"),
    array("value" => "name-last", "label" => "Cognome"),
    array("value" => "name-first", "label" => "Nome"),
    array("value" => "birth-date", "label" => "Millesimo"),
    array("value" => "phone", "label" => "Telefono"),
    array("value" => "email", "label" => "Email"),
    array("value" => "document-id", "label" => "Documento"),
    array("value" => "sport-fitness", "label" => "Idoneità")
  );
?>