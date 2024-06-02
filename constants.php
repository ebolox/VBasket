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
    "admin" => "Amministratore",
    "manager" => "Dirigente",
    "coach" => "Coach",
    "athlete" => "Atleta",
    "staff" => "Staff",
    "brainstorming" => "Riunione societaria",
    "meeting" => "Meeting",
    "party" => "Festa",
    "other" => "Altro",
    "championship" => "Campionato",
    "cup" => "Coppa",
    "trophy" => "Torneo",
    "friendly" => "Amichevole",
    "technique" => "Tecnico",
    "athletic" => "Atletico"
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
    "book" => array("club", "field")
  );

  // Liste valore, nome delle colonne Anagrafica
  $registry_column_opts = array(
    array("value" => "role", "label" => "Ruolo"),
    array("value" => "birth", "label" => "Millesimo"),
    array("value" => "phone", "label" => "Telefono"),
    array("value" => "email", "label" => "Email"),
    array("value" => "document", "label" => "Documento"),
    array("value" => "fitness", "label" => "Idoneità"),
    array("value" => "team", "label" => "Squadre")
  );
?>