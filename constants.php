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

  // Generale
  $lang_it = array(
    "account" => "Profilo",
    "accounts" => "Profili",
    "activity" => "Attività",
    "activities" => "Attività",
    "admin" => "Amministratore",
    "all" => "Tutto",
    "alls" => "Tutti",
    "athlete" => "Atleta",
    "athletes" => "Atleti",
    "assistant" => "Assistente",
    "assistants" => "Assistenti",
    "athletic" => "Atletico",
    "book" => "Rubrica",
    "brainstorming" => "Riunione societaria",
    "calendar" => "Calendario",
    "championship" => "Campionato",
    "championships" => "Campionati",
    "club" => "Società",
    "clubs" => "Società",
    "coach" => "Coach",
    "coaches" => "Coaches",
    "cup" => "Coppa",
    "cups" => "Coppe",
    "document" => "Documento",
    "documents" => "Documenti",
    "event" => "Evento",
    "events" => "Eventi",
    "field" => "Campo di gioco",
    "fields" => "Campi di gioco",
    "friendly" => "Amichevole",
    "friendlys" => "Amichevoli",
    "game" => "Partita",
    "games" => "Partite",
    "image" => "Immagine",
    "images" => "Immagini",
    "manager" => "Dirigente",
    "managers" => "Dirigenti",
    "meeting" => "Meeting",
    "name" => "Nome",
    "names" => "Nomi",
    "name-last" => "Cognome",
    "name-first" => "Nome",
    "party" => "Festa",
    "parties" => "Feste",
    "player" => "Giocatore",
    "players" => "Giocatori",
    "other" => "Altro",
    "others" => "Altri",
    "registry" => "Anagrafica",
    "screen" => "Schermo",
    "screens" => "Schermi",
    "staff" => "Staff",
    "team" => "Squadra",
    "teams" => "Squadre",
    "technique" => "Tecnico",
    "town" => "Città",
    "training" => "Allenamento",
    "trainings" => "Allenamenti",
    "trophy" => "Torneo",
    "trophies" => "Tornei",
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
// Fine

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

  // Parametri dei btn-icon
  $btn_params = array(
    "new" => array("color" => "success", "icon_class" => "bi bi-plus-lg", "disabled" => false),
    "edit" => array("color" => "primary", "icon_class" => "bi bi-pencil", "disabled" => true),
    "delete" => array("color" => "danger", "icon_class" => "bi bi-trash3", "disabled" => true),
    "print" => array("color" => "primary", "icon_class" => "bi bi-printer", "disabled" => false),
    "save" => array("color" => "success", "icon_class" => "bi bi-floppy", "disabled" => true)
  );

  // Aree e Sezioni
  $vb = array(
    "activity" => array("event", "game", "training"),
    "book" => array("account", "club", "field", "team"),
    "media" => array("document", "image", "screen", "video")
  );

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