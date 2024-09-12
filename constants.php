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
    "book" => "Segreteria",
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
    "delete" => "Elimina",
    "edit" => "Modifica",
    "event" => "Evento",
    "events" => "Eventi",
    "field" => "Campo di gioco",
    "fields" => "Campi di gioco",
    "file" => "Documento",
    "files" => "Documenti",
    "first f" => "Prima",
    "first m" => "Primo",
    "friendly" => "Amichevole",
    "friendlys" => "Amichevoli",
    "game" => "Partita",
    "games" => "Partite",
    "image" => "Immagine",
    "images" => "Immagini",
    "late" => "Ritardo",
    "manager" => "Dirigente",
    "managers" => "Dirigenti",
    "media" => "Media",
    "meeting" => "Meeting",
    "missing" => "Assente",
    "name" => "Nome",
    "names" => "Nomi",
    "name-last" => "Cognome",
    "name-first" => "Nome",
    "other f" => "Altra",
    "other m" => "Altro",
    "others f" => "Altre",
    "others m" => "Altri",
    "party" => "Festa",
    "parties" => "Feste",
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
    "other" => "Altro",
    "others" => "Altri",
    "registry" => "Anagrafica",
    "roster" => "Formazione",
    "rosters" => "Formazioni",
    "screen" => "Schermo",
    "screens" => "Schermi",
    "staff" => "Staff",
    "team" => "Squadra",
    "teams" => "Squadre",
    "technique" => "Tecnico",
    "total" => "Totale",
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
    "media" => array("file", "image", "screen", "video")
  );

  // Settori di appartenenza Squadre
  $team_sectors = array(
    "minibasket" => array(
      "Pulcini",
      "Scoiattoli",
      "Aquilotti",
      "Esordienti"
    ),
    "youth" => array(
      "Under 13",
      "Under 14",
      "Under 15",
      "Under 16",
      "Under 17",
      "Under 18",
      "Under 19",
      "Under 20"
    ),
    "senior" => array(
      "Senior",
      "Amatoriale"
    )
  );

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

  // Estensioni dei file ammessi
  $image_extensions = ["jpg", "jpeg", "png", "gif", "bmp", "tiff", "svg"];
  $video_extensions = ["mp4", "avi", "mov", "wmv", "flv", "mkv", "webm"];
  $audio_extensions = ["mp3", "wav", "ogg", "flac", "aac", "wma", "m4a"];
?>