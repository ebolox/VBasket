<?php
  include('db_connection.php');
  include('constants.php');
  include('component.php');

  //Start the session
  session_start([
    "cookie_lifetime" => 604800
  ]);

  // Imposta il timezone in modo da ottenere la data corrente correttamente
  date_default_timezone_set('Europe/Rome');

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

      } elseif ($_POST['action'] === 'create_item') {
        create_item();

      } elseif ($_POST['action'] === 'delete_item') {
        delete_item();

      } elseif ($_POST['action'] === 'update_item') {
        update_item();

      } elseif ($_POST['action'] === 'get_registry_by_team') {
        get_registry_by_team($_POST['team_id']);

      } elseif ($_POST['action'] === 'get_book') {
        get_book($_POST['section_tag']);

      } elseif ($_POST['action'] === 'get_calendar_by') {
        get_calendar_by($_POST['activity_tag'], $_POST['team_tag'], $_POST['account_id']);
      }
    }

    if (!empty($_FILES)) { upload_image (); }
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

  // Crea un'account
  function create_item () {
    global $db_conn;
    $sql = "INSERT INTO " . $_POST["model"] . "s ('id', '" . $_POST["param"] . "') VALUES (" . $_POST["id"] . ", '" . $_POST["value"] . "')";
    $result = $db_conn->query($sql);
  }

  // Elimina l'item desirato
  function delete_item () {
    global $db_conn;
    $sql = "DELETE FROM " . $_POST["model"] . "s where id=" . $_POST["id"];
    $result = $db_conn->query($sql);

    // Verifica se ci sono righe eliminate
    $deleted_item = $db_conn->affected_rows;
    
    if ($deleted_item > 0) {
      $code = $_POST["model"] == "account" ? file_get_contents("registry.php") : file_get_contents("book.php");
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
  function form_variables ($action, $model, $item_id) {

    $code = '<input type="hidden" id="form_action" name="form[action]" value="' . $action . '" />';
    $code .= '<input type="hidden" id="form_model" name="form[model]" value="' . $model . '" />';
    $code .= '<input type="hidden" id="form_id" name="form[id]" value="' . $item_id . '" />';

    return $code;
  }

  // Recupera i dati dell'account
  // o ne crea uno nuovo
  function get_account () {
    global $db_conn;

    if (isset($_POST) && isset($_POST["action"]) && $_POST["action"] == "new") {

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

    return !empty($_POST) ? $_POST["account_id"] : $_SESSION["POST"]["account_id"];
  }

  // Ritorna la tabella delle attività settimanali
  function get_activity ($section_tag) {

    global $lang_it;

    $records = get_activity_section($section_tag);

    $results = '<table class="table table-striped">';
    $results .= '<thead>';
    $results .= '<tr>';
    $results .= '<th scope="col" class="' . $section_tag . '-id">#</th>';
    if (in_array($section_tag, array("event", "game"))) {
      $results .= '<th scope="col" class="' . $section_tag . '-type">Tipo</th>';
    }
    $results .= '<th scope="col" class="' . $section_tag . '-date">Nome</th>';
    if ($section_tag == "training") {
      $results .= '<th scope="col" class="' . $section_tag . '-type">Tipo</th>';
    }
    if (in_array($section_tag, array("game", "training"))) {
      $results .= '<th scope="col" class="' . $section_tag . '-team">Squadra VDCB</th>';
    }
    if ($section_tag == "game") {
      $results .= '<th scope="col" class="' . $section_tag . '-opponent">Squadra rivale</th>';
    }
    $results .= '<th scope="col" class="' . $section_tag . '-name">Data</th>';
    $results .= '<th scope="col" class="' . $section_tag . '-field">Campo</th>';
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
          $date = $record["date_on"]; break;
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

      $results .= '<tr id="item_' . ($key + 1) . '" class="">';
      $results .= '<td scope="col" class="text-center">' . ($key + 1) . '</th>';
      if (in_array($section_tag, array("event", "game"))) {
        $results .= '<td scope="col" class="' . $section_tag . '-type">' . $type . '</th>';
      }
      $results .= '<td scope="col" class="' . $section_tag . '-name">' . $name . '</th>';
      if ($section_tag == "training") {
        $results .= '<td scope="col" class="' . $section_tag . '-type">' . $type . '</th>';
      }
      if (in_array($section_tag, array("game", "training"))) {
        $results .= '<td scope="col" class="' . $section_tag . '-team">' . $record["team"] . '</th>';
      }
      if ($section_tag == "game") {
        $results .= '<td scope="col" class="' . $section_tag . '-opponent">' . $record["opponent"] . '</th>';
      }
      $results .= '<td scope="col" class="' . $section_tag . '-date">' . $date . '</th>';
      $results .= '<td scope="col" class="' . $section_tag . '-field">' . $field . '</th>';
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>';
    $results .= '$("#activity_list > table > tbody > tr").click( function () {';
    $results .= 'item_selected ("activity", $(this), true); });';
    $results .= '</script>';

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

    $results = '<table class="table table-striped">';
    $results .= '<thead>';
    $results .= '<tr>';
    $results .= '<th scope="col" class="' . $section_tag . '-id">#</th>';
    $results .= '<th scope="col" class="' . $section_tag . '-name">Nome</th>';
    $results .= '<th scope="col" class="' . $section_tag . '-town">Comune</th>';
    $results .= '</tr>';
    $results .= '</thead>';
    $results .= '<tbody>';
    foreach ($records as $key => $record) {
      $results .= '<tr id="item_' . ($key + 1) . '" class="">';
      $results .= '<td scope="col" class="text-center">' . ($key + 1) . '</th>';
      $results .= '<td scope="col" class="' . $section_tag . '-name">' . $record["name"] . '</th>';
      $results .= '<td scope="col" class="' . $section_tag . '-town">' . $record["town"] . '</th>';
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>';
    $results .= '$("#book_list > table > tbody > tr").click( function () {';
    $results .= 'item_selected ("book", $(this), true); });';
    $results .= '</script>';

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

  // Recupera i dati degli eventi
  function get_events () {
    global $db_conn;
    global $sql_events;

    $items = do_ask($sql_events);

	return $items;
  }

  // Recupera i dati delle partite
  function get_games ($conditions) {
    global $db_conn;
    global $sql_games;

    $sql = $sql_games . $conditions;
    $items = do_ask($sql);

	return $items;
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

  // Recupera i dati dell'item
  // o ne crea uno nuovo
  function get_item_tab () {
    global $db_conn;

    if (isset($_POST) && isset($_POST["action"]) && $_POST["action"] == "new") {

      $sql = "SELECT MAX(id) as id FROM " . $_POST["model"] . "s";
      $result = $db_conn->query($sql);
      $item_new = $result->fetch_array();

      $response = array(
        "id" => $item_new["id"],
        "name" => ""
      );

      if (in_array($_POST["model"], array("club", "field"))) {
        $response["town"] = "";
      }

      if (in_array($_POST["model"], array("event", "game", "training"))) {
        $response["type"] = "";
        $response["field"] = "";
        $response["frequence"] = "once";
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
            $response["side"] = "home";
            $response["team"] = "";
            $response["opponent"] = ""; break;
          case "training":
            $response["team"] = ""; break;
          default:
            break;
        }
      }
    } else {

      $sql = "SELECT * FROM " . $_POST["model"] . "s WHERE id=" . $_POST["id"];
      $result = $db_conn->query($sql);

      $response = $result->fetch_array();
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
    $results .= '<th scope="col">#</th>';
    $results .= '<th scope="col" class="registry-role">Ruolo</th>';
    $results .= '<th scope="col">Cognome</th>';
    $results .= '<th scope="col">Nome</th>';
    foreach ($registry_column_opts as $opt) {
      $colspan = $opt["value"] == "team" ? " colspan=3" : "";
      if ($opt["value"] != "role") {
        $results .= '<th class="registry-' . $opt["value"] . '" scope="col"' . $colspan . '>' . $opt["label"] . '</th>';
      }
    }
    $results .= '</tr>';
    $results .= '</thead>';
    $results .= '<tbody>';
    foreach ($members as $member) {

      $birth_parts = empty($member["birth_date"]) ?
        array("-", "-", "-") :
        explode("-", $member["birth_date"]);

      $results .= '<tr id="item_' . $member["id"] . '" class="registry-role-' . $member["role"] . '">';
      $results .= '<td scope="col" class="text-center">' . $member["id"] . '</th>';
      $results .= '<td scope="col" class="registry-role">' . $lang_it[$member["role"]] . '</th>';
      $results .= '<td scope="col">' . $member["name_last"] . '</th>';
      $results .= '<td scope="col">' . $member["name_first"] . '</th>';
      $results .= '<td scope="col" class="registry-birth">' . $birth_parts[0] . '</th>';
      $results .= '<td scope="col" class="registry-phone">' . $member["phone"] . '</th>';
      $results .= '<td scope="col" class="registry-email">' . $member["email"] . '</th>';
      $results .= '<td scope="col" class="registry-document">' . $member["document_id"] . '</th>';
      $results .= '<td scope="col" class="registry-fitness">' . $member["sport_fitness"] . '</th>';
      $results .= '<td scope="col" class="registry-team">' . $member["team_a"] . '</th>';
      $results .= '<td scope="col" class="registry-team">' . $member["team_b"] . '</th>';
      $results .= '<td scope="col" class="registry-team">' . $member["team_c"] . '</th>';
      $results .= '</tr>';
    }
    $results .= '</tbody>';
    $results .= '</table>';
    $results .= '<script>';
    $results .= '$("#registry_list > table > tbody > tr").click( function () {';
    $results .= 'item_selected ("registry", $(this), true); });';
    $results .= '$("#registry_select_all").val("all");';
    $results .= '$("#registry_select_all").text("Seleziona tutti");';
    $results .= '</script>';

    return $results;
  }

  // Recupera i dati anagrafici di tutti gli account
  function get_team_members ($team_id = null) {
    global $db_conn;
    global $sql_registry;

    $conditions = (!empty($team_id) && $team_id != "all") ?
      " WHERE (a.team_a='" . $team_id . "' OR a.team_b='" . $team_id . "' OR a.team_c='" . $team_id . "')" :
      "";
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
    $items = do_ask($sql);

	return $items;
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

    $id = get_account_id();

    $sql = "SELECT team_a, team_b, team_c FROM accounts WHERE id=" . $id;
    $result = $db_conn->query($sql);
    return $result->fetch_array();
  }

  // Imposta il formato del nome account e lo restituisce
  function set_account_name () {
    global $db_conn;

    $sql_update = "UPDATE accounts set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
    $result_update = $db_conn->query($sql_update);

    $name = compose_account_name($_POST["id"]);
    return $name == null ? "" : trim(htmlspecialchars_decode($name, ENT_QUOTES));
  }

  // Aggiorna i dati dell'account
  function update_account () {
    global $db_conn;
    $sql = "UPDATE accounts set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
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
      $sql_main = "SELECT * FROM images WHERE object_type = '" . $_POST["object_type"] . "' AND object_id = " . $_POST["object_id"] . " AND main = 1";
      $result_main = $db_conn->query($sql_main);
      $main = $result_main->fetch_array();

      $sql = empty($main) ?
        "INSERT INTO images (filename, object_type, object_id, main) VALUES ('" . $filename . "', '" . $_POST["object_type"] . "', " . $_POST["object_id"] . ", 1)" :
        "UPDATE images SET filename = '" . $filename . "' WHERE id=" . $main["id"];

      if(move_uploaded_file($temp_file, $upload_path)) {
        $result = $db_conn->query($sql);
  
        return "File caricato con successo!";
      } else {
        return "Errore durante il caricamento del file.";
      }
    } else {
      return "Si è verificato un errore durante l'upload del file.";
    }
  }

  // Aggiorna un dato di uno specifico elemento
  function update_item () {
    global $db_conn;

    if (array("frequence", "date_on", "week_day", "time_start", "time_stop").indexOf($_POST["param"]) >= 0) {
      $sql = "UPDATE dates set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE object_type=" . $_POST["model"] . " AND object_id=" . $_POST["id"];
    } else {
      $sql = "UPDATE " . $_POST["model"] . "s set " . $_POST["param"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
    }

    $result = $db_conn->query($sql);
  }
?>