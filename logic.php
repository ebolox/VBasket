<?php
  include('db_connection.php');
  include('constants.php');
  include('component.php');

  // Includiamo la classe Pluralizer
  require_once("ext/rachid/pluralizer.php");

  //Start the session
  session_start([
    "cookie_lifetime" => 604800
  ]);

  // Imposta il timezone in modo da ottenere la data corrente correttamente
  date_default_timezone_set('Europe/Rome');

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
      if ($_POST['action'] === 'create_account') {
        create_account();

      } elseif ($_POST['action'] === 'delete_account') {
        delete_account();

      } elseif ($_POST['action'] === 'update_account') {
        update_account();

      } elseif ($_POST['action'] === 'set_account_name') {
        set_account_name();

      } elseif ($_POST['action'] === 'init_object') {
        init_object();

      } elseif ($_POST['action'] === 'create_object') {
        create_object();

      } elseif ($_POST['action'] === 'edit_object') {
        edit_object();

      } elseif ($_POST['action'] === 'delete_object') {
        delete_object();

      } elseif ($_POST['action'] === 'update_object') {
        update_object();

      } elseif ($_POST['action'] === 'init_eboard') {
        init_eboard();

      } elseif ($_POST['action'] === 'edit_eboard') {
        edit_eboard();

      } elseif ($_POST['action'] === 'get_eboard') {
        get_eboard();

      } elseif ($_POST['action'] === 'get_registry_by_team') {
        get_registry_by_team($_POST['team_id']);

      } elseif ($_POST['action'] === 'get_book') {
        get_book($_POST['section']);

      } elseif ($_POST['action'] === 'get_calendar_by') {
        get_calendar_by($_POST['activity_tag'], $_POST['team_tag'], $_POST['account_id']);

      } elseif ($_POST['action'] === 'upload_image') {
        upload_image ();

      } else {

        unknown_action();
      }
    }

    if (!empty($_FILES)) { upload_image (); }
  }

  // Reindirizza al login se serve 
  function account_logged () {
    if (empty($_SESSION["account_id"])) {
      // Se l'utente non è loggato, reindirizza alla pagina di login
      header("Location: login.php");
      exit();
    }
  }

  function coming_from_eboard () {
    return (isset($_GET) && !empty($_GET["watch"]));
  }

  // Compone il nome account in base al named scelto
  function compose_account_name ($account_id) {
    global $db_conn;
    $sql_select = "SELECT name_last, name_first, nickname, named FROM accounts WHERE id=" . $account_id;
    $result_select = $db_conn->query($sql_select);
    $account = $result_select->fetch_array();

    switch ($account["named"]) {
      case "f+l": $name = $account["name_first"] . " " . $account["name_last"]; break;
      case "f+l+s": $name = $account["name_first"] . " " . $account["name_last"][0] . "."; break;
      case "l+f": $name = $account["name_last"] . " " . $account["name_first"]; break;
      case "l+f+s": $name = $account["name_last"] . " " . $account["name_first"][0] . "."; break;
      case "n": $name = $account["nickname"]; break;
      default: $name = $account["name_first"] . " " . $account["name_last"]; break;
    }

    return $name;
  }

  // Crea un'account
  function create_account () {
    global $db_conn;

    $sql = "INSERT INTO accounts ('id', '" . $_POST["param"] . "') VALUES (" . $_POST["id"] . ", '" . $_POST["name_last"] . "')";
    $result = $db_conn->query($sql);
  }

  // Ritorna il blocco div dell'Attività
  // compilato con i dati utili al calendario
  function create_activity ($act_type, $act_label, $act_data) {

    return '<div class="activity-' . $act_type . '" id="act_' . $act_data["cell_id"] . '" data-time-start="' . $act_data["time_start"] . '" data-time-last="' . $act_data["time_last"] . '">' . $act_label . '</div>';
  }

  // Crea un nuovo oggetto e
  // ritorna la scheda completa
  function create_object () {
    global $db_conn;
    $rachid = init_pluralizer();

    $model = $_POST["model"];
    $action = $_POST["action"];

    $cols = "";
    $values = "";
    foreach ($_POST as $key => $val) {
      if (!in_array($key, ["model", "action"])) {
        $cols .= $key . ",";
        $values .= "'" . $val . "',";
      }
    }

    $sql = "INSERT INTO " . $rachid->pluralize($model) . " (" . trim($cols, ",") . ") VALUES (" . trim($values, ",") . ");";
    echo $sql;
    $result = $db_conn->query($sql);

    $sql_new = "SELECT * FROM " . $rachid->pluralize($model) . " ORDER BY id desc LIMIT 1;";
    $result_new = do_ask_easy($sql_new);

    $_POST["id"] = $result_new["id"];

    $content = include($model . ".php");

    return $content;
  }

  // Elimina l'object desirato
  function delete_object () {
    global $db_conn;
    global $vb;
    $rachid = init_pluralizer();

    $sql = "DELETE FROM " . $rachid->pluralize($_POST["model"]) . " where id=" . $_POST["id"];
    $result = $db_conn->query($sql);

    // Verifica se ci sono righe eliminate
    $deleted_object = $db_conn->affected_rows;
    
    if ($deleted_object > 0) {

      if ($_POST["model"] == "account") {
        $code = file_get_contents("registry.php");

      } elseif (in_array($_POST["model"], $vb["book"])) {
        $code = file_get_contents("book.php");

      } elseif (in_array($_POST["model"], $vb["activity"])) {
        $code = file_get_contents("activity.php");

      } else {
        $code = file_get_contents("no_result.php");
      }
    } else {
      $code = 'alert("non eliminato");';
    }
  }

  // Ritorna un array di risultati
  function do_ask ($query) {
    global $db_conn;

    $result = $db_conn->query($query);
    $results = array();
    while ($row = $result->fetch_assoc()) {
      foreach ($row as $key => $value) {
        $row[$key] = !empty($value) ? htmlspecialchars($value) : "";
      }
      $results[] = $row;
    }

    return $results;
  }

  // Ritorna un array di risultati
  function do_ask_easy ($query) {
    global $db_conn;

    $result = $db_conn->query($query);
    return $result->fetch_array(MYSQLI_ASSOC);
  }

  function eboard_dots ($totals, $filled) {

    // Convertire stringhe numeriche a interi
    $totals = (int)$totals;
    $filled = (int)$filled;

    // Verifica che $totals e $filled siano numeri interi positivi
    if (!is_int($totals) || $totals < 0 || !is_int($filled) || $filled < 0) {
      return "I parametri devono essere numeri interi positivi.";
    }

    $code = "";
    for ($c = 0; $c < $totals; $c++) {
      $icon_class = ($c < $filled) ? "bi-circle-fill" : "bi-circle";
      $code .= '<i class="bi ' . $icon_class . ' ml-4"></i>';
    }

    return $code;
  }

  // Recupera i dati dell'object desiderato
  function edit_object () {
    global $db_conn;
    global $vb;
    $rachid = init_pluralizer();

    if (in_array($_POST["model"], array_merge($vb["activity"], $vb["book"]))) {

      // Object che richiedono più tabelle
      // Si usano le query base, tipo $sql_game
      $var_name = "sql_" . $rachid->pluralize($_POST["model"]);

      global $$var_name;
      $sql = $$var_name . " WHERE tx.id=" . $_POST["id"];
    } else {

      // Object da tabella singola
      $sql = "SELECT * FROM " . $rachid->pluralize($_POST["model"]) . " WHERE id=" . $_POST["id"];
    }
    $result = $db_conn->query($sql);

    return $result->fetch_array();
  }

  // Definizione del formato named
  function extend_account_name_code ($code) {
    switch ($code) {
      case "f+l": $full = "Nome Cognome"; break;
      case "f+l+s": $full = "Nome C."; break;
      case "l+f": $full = "Cognome Nome"; break;
      case "l+f+s": $full = "Cognome N."; break;
      case "n": $full = "Soprannome"; break;
      default: $full = "Nome Cognome"; break;
    }

    return $full;
  }

  // Definizione dell'account name
  function extend_account_name ($named, $name_first, $name_last, $nickname) {
    switch ($named) {
      case "f+l": $full = "$name_first $name_last"; break;
      case "f+l+s": $full = "$name_first $name_last[0]."; break;
      case "l+f": $full = "$name_last $name_first"; break;
      case "l+f+s": $full = "$name_last $name_first[0]."; break;
      case "n": $full = $nickname; break;
      default: $full = "$name_first $name_last"; break;
    }

    return $full;
  }

  // Variabili di una form base
  function form_variables ($action, $model, $object_id) {

    $code = '<input type="hidden" id="form_action" name="form[action]" value="' . $action . '" />';
    $code .= '<input type="hidden" id="form_model" name="form[model]" value="' . $model . '" />';
    $code .= '<input type="hidden" id="form_id" name="form[id]" value="' . $object_id . '" />';

    return $code;
  }

  // Converte una data dal formato YYYY-MM-DD a DD-MM-YYYY
  function format_to_ddmmyyyy ($yyyymmdd) {

    if (empty($yyyymmdd) || strpos($yyyymmdd, '-') === false) {

      $ddmmyyyy = "-";
    } else {

      $parts = explode('-', $yyyymmdd);
      $day = str_pad($parts[2], 2, '0', STR_PAD_LEFT);
      $month = str_pad($parts[1], 2, '0', STR_PAD_LEFT);
      $year = $parts[0];

      $ddmmyyyy = $day . '/' . $month . '/' . $year;
    }

    return $ddmmyyyy;
  }

  // Recupera i dati dell'account
  // o ne crea uno nuovo
  function get_account () {
    global $db_conn;

    if (isset($_POST) && isset($_POST["action"]) && $_POST["action"] == "init") {

      $sql = "SELECT MAX(id) as id FROM accounts";
      $result = $db_conn->query($sql);
      $account_new = $result->fetch_array();

      $response = array(
        "id" => $account_new["id"],
        "name_first" => "",
        "name_last" => "",
        "role" => "staff",
        "account_type" => "staff",
      );
    } else {

      $id = get_account_id();

      $sql = "SELECT * FROM accounts WHERE id=" . $id;
      $result = $db_conn->query($sql);

      $response = $result->fetch_array();
    }

    return $response;
  }

  // Prende l'id account attivo
  function get_account_id () {

    return (!empty($_POST) && !empty($_POST["account_id"])) ? $_POST["account_id"] : ((!empty($_SESSION["POST"]) && !empty($_SESSION["POST"]["account_id"])) ? $_SESSION["POST"]["account_id"] : 1);
  }

  // Ritorna la tabella delle attività settimanali
  function get_activities ($section_tag) {

    global $lang_it;
    global $btn_params;

    $records = get_activity_section($section_tag);

    $results = '<table class="table table-striped">';
    $results .= '<thead>';
    $results .= '<tr>';
    $results .= '<th scope="col" class="cell-nr">#</th>';
    if (in_array($section_tag, array("event", "game"))) {
      $results .= '<th scope="col" class="cell-type">Tipo</th>';
    }
    $results .= '<th scope="col" class="cell-name">Nome</th>';
    if ($section_tag == "training") {
      $results .= '<th scope="col" class="cell-type">Tipo</th>';
    }
    if (in_array($section_tag, array("game", "training"))) {
      $results .= '<th scope="col" class="cell-team">VDCB</th>';
    }
    if ($section_tag == "game") {
      $results .= '<th scope="col" class="cell-opponent">Rivale</th>';
    }
    $results .= '<th scope="col" class="cell-date">Data</th>';
    $results .= '<th scope="col" class="cell-field cell-optional">Campo</th>';
    if ($section_tag == "game") {
      $results .= '<th scope="col" class="cell-eboard">Tabellone</th>';
    }
    $results .= '<th scope="col" class="cell-toolbar"></th>';
    $results .= '</tr>';
    $results .= '</thead>';
    $results .= '<tbody>';

    foreach ($records as $key => $record) {

      $name = !empty($record["name"]) ?
                $record["name"] :
                (!empty($record["round"]) ? $record["type"] . " " . $record["round"] : "n.d.");

      $field = !empty($record["field"]) ? $record["field"] : "n.d.";

      switch ($record["frequence"]) {
        case "once":
          $date = format_to_ddmmyyyy($record["date_on"]); break;
        case "daily":
          $date = "Giornaliero"; break;
        case "week_once":
          $date = "Ogni " . $record["week_day"]; break;
        case "week_work":
          $date = "Lun > Ven"; break;
        case "week_end":
          $date = "Sab Dom"; break;
        default:
          $date = "n.d."; break;
      }

      $type = $lang_it[$record["type"]];

      $day_past = ($record["frequence"] == "once" && $record["date_on"] >= date("Y-m-d")) ? false : true;
      $eboard = get_game_board($record["id"]);
      $eboard_icon = empty($eboard) ? "bi bi-calendar-x text-danger" : ($day_past ? "bi bi-calendar-plus text-primary" : "bi bi-calendar-check text-success");

      $buttons = array("edit", "delete");

      $results .= '<tr id="object_' . ($key + 1) . '" class data-type="' . $section_tag . '">';
      $results .= '<td scope="col" class="cell-nr text-center">' . ($key + 1) . '</td>';
      if (in_array($section_tag, array("event", "game"))) {
        $results .= '<td scope="col" class="cell-type">' . $type . '</td>';
      }
      $results .= '<td scope="col" class="cell-name">' . $name . '</td>';
      if ($section_tag == "training") {
        $results .= '<td scope="col" class="cell-type">' . $type . '</td>';
      }
      if (in_array($section_tag, array("game", "training"))) {
        $results .= '<td scope="col" class="cell-team">' . $record["team"] . '</td>';
      }
      if ($section_tag == "game") {
        $results .= '<td scope="col" class="cell-opponent">' . $record["opponent"] . '</td>';
      }
      $results .= '<td scope="col" class="cell-date">' . $date . '</td>';
      $results .= '<td scope="col" class="cell-field cell-optional">' . $field . '</td>';
      if ($section_tag == "game") {
        $results .= '<td scope="col" class="cell-eboard text-center"><i class="' . $eboard_icon . '" data-id="' . $eboard["id"] . '"></i></td>';
      }
      $results .= object_contextual_toolbar ($section_tag, $key + 1);
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>set_list_events ("activity", "' . $section_tag . '");</script>';

    return $results;
  }

  // Recupera i dati della sezione desiderata
  function get_activity_section ($tag) {
    global $db_conn;

    switch ($tag) {
      case "event":
        global $sql_activity_events;
        $sql = $sql_activity_events; break;
      case "game":
        global $sql_activity_games;
        $sql = $sql_activity_games; break;
      case "training":
        global $sql_activity_trainings;
        $sql = $sql_activity_trainings; break;
      default: break;
    }

    $result = $db_conn->query($sql);

    $results = array();
    while ($row = $result->fetch_assoc()) {
      $results[] = $row;
    }

    return $results;
  }

  // Ritorna un'hash con i dati dell'attività passata come parametro
  function get_activity_data ($act) {

		$week_day = $act["date_on"] != "" ? date('N', strtotime($act["date_on"])) : $act["week_day"];
		$hour_start = substr($act["time_start"], 0, 2);
    $time_start = substr($act["time_start"], -2);
		$hour_stop = $act["time_stop"] != "" ? substr($act["time_stop"], 0, 2) : ((int)$hour_start + 2);
		$time_stop = $act["time_stop"] != "" ? substr($act["time_stop"], -2) : (int)$time_start;

    return [
      "time_start" => $time_start,
      "time_last" => ((int)$hour_stop - (int)$hour_start) * 60 + ((int)$time_stop - (int)$time_start),
      "cell_id" => "field_" . $act["field_id"] . '_' . $week_day . '_' . $hour_start
    ];
  }

  // Ritorna la tabella della sezione desiderata
  function get_book ($section_tag) {

    global $lang_it;

    $records = get_book_section($section_tag);
    $col_param = $section_tag == "team" ? "club" : "town";

    $results = '<table class="table table-striped">';
    $results .= '<thead>';
    $results .= '<tr>';
    $results .= '<th scope="col" class="cell-nr">#</th>';
    $results .= '<th scope="col" class="cell-name">Nome</th>';
    $results .= '<th scope="col" class="cell-' . $col_param . '">' . $lang_it[$col_param] . '</th>';
    $results .= '<th scope="col" class="cell-toolbar"></th>';
    $results .= '</tr>';
    $results .= '</thead>';
    $results .= '<tbody>';
    foreach ($records as $key => $record) {
      $name_short = !empty($record["name_short"]) ? ' <span style="font-weight: 400;">(' . $record["name_short"] . ')</span>' : "";

      $results .= '<tr id="object_' . ($key + 1) . '" class data-type="' . $section_tag . '">';
      $results .= '<td scope="col" class="cell-nr text-center">' . ($key + 1) . '</th>';
      $results .= '<td scope="col" class="cell-name">' . $record["name"] . $name_short . '</th>';
      $results .= '<td scope="col" class="cell-' . $col_param . '">' . $record[$col_param] . '</th>';
      $results .= object_contextual_toolbar ($section_tag, $key + 1);
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>set_list_events ("book", "' . $section_tag . '");</script>';

    return $results;
  }

  // Recupera i dati della sezione desiderata
  function get_book_section ($tag) {
    global $db_conn;

    switch ($tag) {
      case "club":
        global $sql_book_clubs;
        $sql = $sql_book_clubs; break;
      case "field":
        global $sql_book_fields;
        $sql = $sql_book_fields; break;
      case "team":
        global $sql_book_teams;
        $sql = $sql_book_teams; break;
      default: break;
    }

    $result = $db_conn->query($sql);

    $results = array();
    while ($row = $result->fetch_assoc()) {
      $results[] = $row;
    }

    return $results;
  }

  // Ritorna i div Attività che venganno mostrati sul calendario
  function get_calendar_by ($activity_tag, $team_tag, $account_id) {

    global $lang_it;

    // Ottieni la data corrente
    $current_date = new DateTime();

    // Ottieni il giorno della settimana (1 = lunedì, 7 = domenica)
    $current_day_of_week = $current_date->format('N');

    // Calcola la differenza di giorni per ottenere il lunedì della settimana corrente
    $days_to_subtract = $current_day_of_week - 1;
    $last_monday = clone $current_date;
    $last_monday->sub(new DateInterval("P{$days_to_subtract}D"));

    // Formatta la data nel formato desiderato (YYYY-MM-DD)
    $last_monday_formatted = $last_monday->format('Y-m-d');

    $conditions = " where (d.date_on >= '" . $last_monday_formatted . "' or d.week_day is not NULL)";
    if ($team_tag == "all") {
      $conditions .= ";";
    } elseif ($team_tag == "handled") {
      $conditions .= " and tx.team in (" . implode(", ", handled_teams($account_id)) . ");";
    } else {
      $conditions .= " and tx.team = " . $team_tag . ";";
    }

    if ($activity_tag == "all") {
      $result_events = get_events ();
      $result_games = get_games ($conditions);
      $result_trainings = get_trainings ($conditions);

    } elseif ($activity_tag == "events") {
      $result_events = get_events ();

    } elseif ($activity_tag == "games") {
      $result_games = get_games ($conditions);

    } elseif ($activity_tag == "trainings") {
      $result_trainings = get_trainings ($conditions);

    } else {
      return false;
    }

    $results = '';

    //if (count($result_events) > 0) {
    //  foreach ($result_events as $res) {
    //
		//		$activity_data = get_activity_data($res);
    //    $activity_label = !empty($res["name_short"]) ? $res["name_short"] : $res["name"];
    //
    //    $results .= create_activity("event", $activity_label, $activity_data);
    //  }
    //}
    if (count($result_games) > 0) {
      foreach ($result_games as $res) {

				$activity_data = get_activity_data($res);
        $activity_label = !empty($res["team_short"]) ? $res["team_short"] : $res["team"];

        $results .= create_activity("game", $activity_label, $activity_data);
      }
    }
    if (count($result_trainings) > 0) {
      foreach ($result_trainings as $res) {

				$activity_data = get_activity_data($res);
        $activity_label = !empty($res["team_short"]) ? $res["team_short"] : $res["team"];

        $results .= create_activity("training", $activity_label, $activity_data);
      }
    }
		$results .= "<script>apply_activities();</script>";

    echo $results;
  }

  // Recupera i dati delle club
  function get_clubs () {
    global $db_conn;

    $sql = "SELECT id AS value, name AS label FROM clubs ORDER BY name ASC";
    $result = $db_conn->query($sql);

    $clubs = array();
    while ($row = $result->fetch_assoc()) {
      $clubs[] = $row;
    }

    return $clubs;
  }

  // Recupera i dati del tabellone elettronico desiderato
  function get_eboard ($eboard_id) {

    $response = do_ask_easy ("Select * FROM eboards WHERE id=" . $eboard_id);

    $object = [
      "id" => 999999,
      "game_id" => 999999,
      "timer" => "09:59",
      "quarter" => 4,
      "arrow" => "a",
      "ta_id" => 1,
      "ta_points" => 99,
      "ta_fouls" => 3,
      "ta_timeout" => 1,
      "ta_service" => null,
      "tb_id" => 2,
      "tb_points" => 100,
      "tb_fouls" => 4,
      "tb_timeout" => 1,
      "tb_service" => null,
      "created_at" => "2024-01-01 00:00:01"
    ];

    return !empty($response) ? $response : $default;
  }

  // Recupera la configurazione del tabellone elettronico desiderato
  function get_eboard_config ($eboard_id) {

    $response = do_ask_easy ("Select * FROM eboard_config WHERE eboard_id=" . $eboard_id);

    $default = [
      "id" => 999999,
      "eboard_id" => 999999,
      "timer" => true,
      "quarter" => true,
      "arrow" => true,
      "teams" => true,
      "points" => true,
      "fouls" => true,
      "timeout" => true,
      "service" => false,
      "created_at" => "2024-01-01 00:00:01"
    ];

    return !empty($response) ? $response : $default;
  }

  // Recupera i dati degli eventi
  function get_events () {
    global $db_conn;
    global $sql_events;

    $objects = do_ask ($sql_events);

    return $objects;
  }

  // Ritorna l'ID tabellone elettronico di una partita
  // o false se la partita non ne ha di associati
  function get_game_board ($game_id) {

    $response = do_ask_easy ("SELECT id FROM eboards WHERE game_id = " . $game_id);

    return !empty($response) ? $response : false;
  }

  // Ritorna gli ID delle squadre di una partita
  // o false se la partita non ne ha di associati
  function get_game_teams ($game_id) {
    global $db_conn;
    global $sql_game_teams;

    $query = $sql_game_teams . " WHERE g.id = " . $game_id;
    $result = $db_conn->query($query);

    $teams = array();
    while ($row = $result->fetch_assoc()) {
      $teams = ["a" => array("id" => $row["a_id"], "name" => $row["a_name"]), "b" => array("id" => $row["b_id"], "name" => $row["b_name"])];
    }

    return !empty($teams) ? $teams : ["a" => array("id" => 99999, "name" => "Squadra A"), "b" => array("id" => 99998, "name" => "Squadra B")];
  }

  // Recupera i dati delle partite
  function get_games ($conditions) {
    global $db_conn;
    global $sql_games;

    $sql = $sql_games . $conditions;
    $objects = do_ask($sql);

    return $objects;
  }

  // Recupera un'immagine
  function get_image ($object_type, $object_id, $options = []) {
    global $db_conn;

    $conditions = "object_type='" . $object_type . "' and ";
    $conditions .= "object_id=" . $object_id;

    $sql = "SELECT id, filename FROM images WHERE object_type='" . $object_type . "' and object_id=" . $object_id;
    $result = $db_conn->query($sql);
    $image = $result->fetch_array();

	return $image["filename"];
  }

  // Recupera i dati dell'object
  // o ne crea uno nuovo
  function get_object_tab () {

    $response = "";
    if (isset($_POST) && isset($_POST["action"])) {
      $response = $_POST["action"] == "init_object" ?
        init_object () :
        edit_object ();
    }

    return $response;
  }

  // Recupera i dati anagrafici di tutti gli account
  function get_registry () {
    global $db_conn;
    global $sql_registry;

    $sql = $sql_registry . " ORDER BY name_last ASC";
    $result = $db_conn->query($sql);

    $accounts = array();
    while ($row = $result->fetch_assoc()) {
      $accounts[] = $row;
    }

    return $accounts;
  }

  // Ritorna la tabella account per Anagrafica
  function get_registry_by_team ($team_id = null) {

    global $registry_column_opts;
    global $lang_it;

    $members = get_team_members($team_id);

    $results = '<table class="table table-striped">';
    $results .= '<thead>';
    $results .= '<tr>';
    $results .= '<th scope="col" class="cell-nr">#</th>';
    foreach ($registry_column_opts as $opt) {
      $opt_class = in_array($opt["value"], ["account-type", "name-last", "name-first"]) ? "" : " cell-optional";

      $results .= '<th class="cell-' . $opt["value"] . $opt_class . '" scope="col">' . $opt["label"] . '</th>';
    }
    $results .= '<th scope="col" class="data-toolbar"></th>';
    $results .= '</tr>';
    $results .= '</thead>';
    $results .= '<tbody>';
    foreach ($members as $key => $member) {

      $results .= '<tr id="object_' . $member["id"] . '" data-type="registry">';
      $results .= '<td scope="col" class="cell-nr text-center">' . ($key + 1) . '</td>';
      $results .= '<td scope="col" class="cell-account-type">' . $lang_it[$member["account_type"]] . '</td>';
      $results .= '<td scope="col" class="cell-name-last">' . $member["name_last"] . '</td>';
      $results .= '<td scope="col" class="cell-name-first">' . $member["name_first"] . '</td>';
      $results .= '<td scope="col" class="cell-birth-date cell-optional">' . (empty($member["birth_date"]) ? "n.d." : substr($member["birth_date"], 0, 4)) . '</td>';
      $results .= '<td scope="col" class="cell-phone cell-optional">' . (empty($member["phone"]) ? "n.d." : $member["phone"]) . '</td>';
      $results .= '<td scope="col" class="cell-email cell-optional">' . (empty($member["email"]) ? "n.d." : $member["email"]) . '</td>';
      $results .= '<td scope="col" class="cell-document-id cell-optional">' . (empty($member["document_id"]) ? "n.d." : $member["document_id"]) . '</td>';
      $results .= '<td scope="col" class="cell-sport-fitness cell-optional">' . (empty($member["sport_fitness"]) ? "n.d." : format_to_ddmmyyyy($member["sport_fitness"])) . '</td>';
      $results .= object_contextual_toolbar ("registry", $key + 1);
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>set_list_events ("registry", "account");</script>';

    return $results;
  }

  // Determina la sezione da mostrare
  function get_section_to_view ($section) {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      if (!empty($_POST["section"])) {
        $section = $_POST["section"];
      }
      if (!empty($_POST["last_view"])) {
        $section = $_POST["last_view"];
      }
    }

    return $section;
  }

  // Recupera i dati anagrafici di tutti gli account
  function get_team_members ($team_id = null) {
    global $db_conn;
    global $sql_registry;

    $conditions = "";
    if (!empty($team_id) && $team_id != "all") { $conditions = " WHERE (r.team_id='" . $team_id . "')"; }

    $sql = $sql_registry . $conditions;
    $result = $db_conn->query($sql);

    $accounts = array();
    while ($row = $result->fetch_assoc()) {
      $accounts[] = $row;
    }

    return $accounts;
  }

  // Recupera i dati delle team
  function get_teams () {
    global $db_conn;

    $sql = "SELECT id as value, name as label FROM teams WHERE season=2023";
    $result = $db_conn->query($sql);

    $teams = array();
    while ($row = $result->fetch_assoc()) {
      $teams[] = $row;
    }

    return $teams;
  }

  // Recupera i dati delle team
  function get_towns () {
    global $db_conn;

    $sql = "SELECT id as value, name as label FROM towns";
    $result = $db_conn->query($sql);

    $towns = array();
    while ($row = $result->fetch_assoc()) {
      $towns[] = $row;
    }

    return $towns;
  }

  // Recupera i dati degli allenamenti
  function get_trainings ($conditions) {
    global $db_conn;
    global $sql_trainings;

    $sql = $sql_trainings . $conditions;
    $objects = do_ask($sql);

	return $objects;
  }

  function get_week () {
    global $days_short;

    $today = new DateTime();
    $today->modify('Monday this week');

    // Inizializza l'array delle colonne della tabella
    $calendar_days = array();

    // Riempie l'array delle colonne con le date di ogni giorno della settimana
    for ($i = 0; $i < 7; $i++) {
      $formatted_date = $days_short[$today->format('N') - 1] . ' ' . $today->format('d');
      $calendar_days[] = $formatted_date;
      $today->modify('+1 day');
    }

    return $calendar_days;
  }

  // Recupera le squadre di pertinenza dell'utente
  function handled_teams ($account_id) {
    global $db_conn;

    if (!isset($account_id)) { $account_id = get_account_id(); }

    $sql = "SELECT team_id FROM rosters WHERE account_id=" . $account_id;
    $result = $db_conn->query($sql);
    return $result->fetch_array();
  }

  // Inizializza un tabellone elettronico
  function init_eboard () {
  }

  // Genera i dati per un nuovo object
  function init_object () {
    global $db_conn;
    global $vb;

    $response = array(
      "id" => "",
      "name" => ""
    );

    if (in_array($_POST["model"], $vb["book"])) {
      $response["town"] = "";
    }

    if (in_array($_POST["model"], $vb["activity"])) {
      $response["type"] = "";
      $response["field_id"] = "";
      $response["field"] = "";
      $response["frequence"] = "";
      $response["week_day"] = "";
      $response["date_on"] = "";
      $response["time_start"] = "";
      $response["time_stop"] = "";

      switch ($_POST["model"]) {
        case "event":
          $response["name_short"] = "";
          $response["town"] = "";
          $response["place"] = ""; break;
        case "game":
          $response["round"] = "";
          $response["side"] = "";
          $response["team_id"] = "";
          $response["team"] = "";
          $response["opponent_id"] = "";
          $response["opponent"] = ""; break;
        case "training":
          $response["team_id"] = "";
          $response["team"] = ""; break;
        default:
          break;
      }
    }

    return $response;
  }

  // Inizializza istanza della classe Pluralizer
  function init_pluralizer () {
    return new rachid\pluralizer\Pluralizer();
  }

  // Ritora il numero di maglia
  function jersey_number ($nr) {
    return !empty($nr) ? $nr : "-";
  }

  // Ritorna il ruolo abbreviato
  function role_short ($role) {
    return mb_ucfirst(mb_substr($role, 0, 2));
  }

  // 
  function roster_group ($items, $ids, $label) {

    $code = "";

    if (count($ids) > 0) {
      $code .= '<label>' . $label . '</label>';
      $code .= '<ul>';

      foreach ($ids as $key => $id) {
        $member = $items[$id];
        $member_name = $member["name_last"] . " " . substr($member["name_first"], 0, 1);
        $member_jersey = $label == "GIOCATORI" ?
                          '<span class="player-nr">#' . jersey_number($member["jersey_nr"]) . '</span>' :
                          "";

        $code .= '<li>' . $member_jersey . $member_name . '</li>';
      }
      $code .= '</ul>';
    }

    return $code;
  }


  // Imposta il formato del nome account e lo restituisce
  function set_account_name () {
    global $db_conn;

    $sql_update = "UPDATE accounts set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
    $result_update = $db_conn->query($sql_update);

    $name = compose_account_name($_POST["id"]);
    return $name == null ? "" : trim(htmlspecialchars_decode($name, ENT_QUOTES));
  }

  function unknown_action () {

    return '<script>alert("Azione sconosciuta");</script>';
  }


  // Aggiorna i dati dell'account
  function update_account () {
    global $db_conn;
    $sql = "UPDATE accounts set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["account_id"];
    $result = $db_conn->query($sql);
  }

  // Carica un'immagine e
  // la registra nella tabella images
  function upload_image () {
    global $db_conn;

    if ($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
      $temp_file = $_FILES["file"]["tmp_name"];
      $filename = $_FILES["file"]["name"];
      $upload_path = "assets/images/" . $filename;

      // Controlliamo la presenza dell'immagine main
      // per l'elemento in editing
      $sql_main = "SELECT id FROM images WHERE object_type = '" . $_POST["object_type"] . "' AND object_id = " . $_POST["object_id"] . " AND main = 1";
      $result_main = $db_conn->query($sql_main);
      $main = $result_main->fetch_array();

      $sql_insert = "INSERT INTO images (filename, object_type, object_id, main) VALUES ('" . $filename . "', '" . $_POST["object_type"] . "', " . $_POST["object_id"] . ", 1)";

      if(move_uploaded_file($temp_file, $upload_path)) {
        $result = $db_conn->query($sql_insert);
  
        if (!empty($main)) {
          $sql_update = "UPDATE images SET main = 0 WHERE id=" . $main["id"];
          $result = $db_conn->query($sql_update);
        }

        return "File caricato con successo!";
      } else {
        return "Errore durante il caricamento del file.";
      }
    } else {
      return "Si è verificato un errore durante l'upload del file.";
    }
  }

  // Aggiorna un dato di uno specifico elemento
  function update_object () {
    global $db_conn;
    $rachid = init_pluralizer();
    $table = $_POST["model"] == "eboard_config" ?
              $_POST["model"] :
              $rachid->pluralize($_POST["model"]);

    if (in_array($_POST["param"], array("frequence", "date_on", "week_day", "time_start", "time_stop"))) {
      $sql = "UPDATE dates set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE object_type='" . $_POST["model"] . "' AND object_id=" . $_POST["id"];
    } else {
      $sql = "UPDATE " . $table . " set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
    }

    $result = $db_conn->query($sql);
  }
?>