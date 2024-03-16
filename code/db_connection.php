<?php
  // Connessione al database
  $server_name = "localhost";
  $username = "pierot";
  $password = "pierot";
  $db_name = "basket";

  $db_conn = new mysqli($server_name, $username, $password, $db_name);

  // Controllo della connessione
  if ($db_conn->connect_error) {
      die("Connessione fallita: " . $db_conn->connect_error);
  }

  $sql_registry = "
    SELECT
      a.id,
      a.name_first,
      a.name_last,
      a.birth_date,
      a.email,
      a.phone,
      a.role,
      a.document_id,
      a.sport_fitness,
      t1.name as team_a,
      t2.name as team_b,
      t3.name as team_c
    FROM accounts a
    LEFT JOIN teams AS t1
    ON a.team_a = t1.id
    LEFT JOIN teams AS t2
    ON a.team_b = t2.id
    LEFT JOIN teams AS t3
    ON a.team_c = t3.id";

  $sql_book_clubs = "
    SELECT
      c.id,
      c.name,
      tw.name AS town,
      c.place,
      c.address,
      c.website,
      c.email,
      c.phone,
      c.phone_alt,
      c.facebook
    FROM clubs c
    LEFT JOIN towns AS tw
    ON c.town = tw.id";

  $sql_book_fields = "
    SELECT
      f.id,
      f.name,
      tw.name AS town,
      f.place,
      f.address,
      f.gps,
      f.phone,
      f.notes
    FROM fields f
    LEFT JOIN towns AS tw
    ON f.town = tw.id";

	$dates_table = "dates d ON d.object_type = 'event' AND d.object_id = tx.id";
	$fields_table = "fields f ON f.id = tx.field";
	$teams_table = "teams t_team ON t_team.id = tx.team";
	$towns_table = "towns tw ON tw.id = tx.town";

  $sql_events = "
    SELECT
      tx.id AS id,
      tx.name AS name,
      tx.name_short AS name_short,
      f.id AS field_id,
      f.name AS field,
      tw.name AS town,
      tx.place AS place,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM events tx
    JOIN dates d ON d.object_type = 'event' AND d.object_id = tx.id
    JOIN " . $fields_table . "
		JOIN " . $towns_table;

  $sql_activity_events = "
    SELECT
      e.id AS id,
      e.name AS name,
      e.name_short AS name_short,
      e.type AS type,
      tw.name AS town,
      e.place AS place,
      f.name AS field,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM events e
    LEFT JOIN towns AS tw ON e.town = tw.id
    LEFT JOIN dates d ON d.object_type = 'event' AND d.object_id = e.id
    LEFT JOIN fields f ON f.id = e.field";

  $sql_games = "
    SELECT
      tx.id AS id,
      tx.name AS name,
      tx.type AS type,
      tx.round AS round,
      f.id AS field_id,
			f.name AS field,
      tx.side AS side,
      tx.team AS team_id,
      t_team.name AS team,
      t_team.name_short AS team_short,
      tx.opponent AS opponent_id,
			t_opponent.name AS opponent,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM games tx
    JOIN dates d ON d.object_type = 'game' AND d.object_id = tx.id
    JOIN " . $fields_table . "
    JOIN " . $teams_table . "
		LEFT JOIN teams t_opponent ON t_opponent.id = tx.opponent";

  $sql_activity_games = "
    SELECT
      g.id AS id,
      g.name AS name,
      g.type AS type,
      g.round AS round,
      t_team.name AS team,
      t_opponent.name AS opponent,
      g.side AS side,
      f.name AS field,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM games g
    LEFT JOIN dates d ON d.object_type = 'game' AND d.object_id = g.id
    LEFT JOIN fields f ON f.id = g.field
    LEFT JOIN teams t_team ON t_team.id = g.team
    LEFT JOIN teams t_opponent ON t_opponent.id = g.opponent";

  $sql_trainings = "
    SELECT
      tx.id AS id,
      tx.name AS name,
      tx.type AS type,
      f.id AS field_id,
      f.name AS field,
      tx.id AS team_id,
      t_team.name AS team,
      t_team.name_short AS team_short,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM trainings tx
    JOIN dates d ON d.object_type = 'training' AND d.object_id = tx.id
    JOIN " . $fields_table . "
    JOIN " . $teams_table;

  $sql_activity_trainings = "
    SELECT
      t.id AS id,
      t.name AS name,
      t.type AS type,
      f.name AS field,
      t_team.name AS team,
      t_team.name_short AS team_short,
      d.date_on AS date_on,
      d.time_start AS time_start,
      d.time_stop AS time_stop,
      d.frequence AS frequence,
      d.week_day AS week_day
    FROM trainings t
    JOIN dates d ON d.object_type = 'training' AND d.object_id = t.id
    JOIN fields f ON f.id = t.field
    JOIN teams t_team ON t_team.id = t.team";
?>