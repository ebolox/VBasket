<?php
  // Crea un campo con etichetta e button dropdown
  function button_dropdown ($model, $param, $label, $value = "", $options = [], $attributes = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $team_name = "";
    if (empty($value)) {
      $value = "";
    } else {
      if (!empty($attributes["select_all"])) {
        $team_name = $attributes["select_all"];
      } else {
        foreach($options as $opt) {
          if ($opt["value"] == $value) { $team_name = $opt["label"]; }
        }
      }
    }

    // Classe per versione con icona come etichetta
    $label_class = "";
    if (!empty($attributes["label_icon"])) { $label_class = " vb-btn-icon"; }

    // Colore pulsante
    $btn_color = "btn-success";
    if (!empty($attributes["btn_color"])) { $btn_color = "btn-primary"; }

    // Dimensioni pulsante
    $btn_size = "btn-sm ";
    if (!empty($attributes["btn_size"])) { $btn_size = $attributes[" btn_size"] == "large" ? "btn-lg " : ""; }

    $code = '<div id="btn_' . $field_id . '" class="input-group vb-btn-dropdown' . $label_class . '">';
    $code .= '<input type="hidden" name="' . $field_name . '" value="' . $value . '" />';
    $code .= '<button class="btn btn-secondary ' . $btn_size . 'text-white" disabled>' . $label . '</button>';
    $code .= '<div class="btn-group ' . str_replace("btn", "btn-group", $btn_size) . 'btn-group-append">';
    $code .= '<button id="' . $field_id . '" class="btn ' . $btn_size . $btn_color . ' text-left dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $team_name . '</button>';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_name . '">';
    $code .= '<a class="dropdown-item" href="#" data-value=""></a>';
    foreach ($options as $opt) {
      $code .= '<a class="dropdown-item" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . '</a>';
    }
    if (!empty($attributes["select_all"])) {
      $code .= '<div class="dropdown-divider"></div>';
      $code .= '<a class="dropdown-item" href="#" data-value="all">' . $attributes["select_all"] . '</a>';
    }
    $code .= '</div></div></div>';

    return $code;
  }

  function button_select ($model, $param, $label, $value, $options) {

    $btn_id = $model . "_" . $param;
    $btn_name = $model . "[" . $param . "]";

    $code = '<input type="hidden" name="' . $btn_name . '[' . $param . ']" value="' . $value . '" />';
    $code .= '<div class="btn-group btn-radio" id="' . $btn_id . '" role="group" aria-label="' . $label . '">';
    foreach ($options as $opt) {
      $code .= '<button type="button" class="btn btn-success btn-sm" data-value="' . $opt["value"] . '">';
      $code .= '<i class="' . $opt["icon_class"] . '"></i><span>' . $opt["label"] . '</span>';
      $code .= '</button>';
    }
    $code .= '</div>';

    return $code;
  }

  // Crea un titolo. Eventualmente con etichetta dropdown se il modello ha aree
  function contextual_navbar ($area, $buttons = [], $section = false) {

    $labels = array(
      "account" => "Profilo",
      "activity" => "Attività",
      "book" => "Rubrica",
      "calendar" => "Calendario",
      "club" => "Società",
      "field" => "Campi di gioco",
      "game" => "Partita",
      "registry" => "Anagrafica",
      "training" => "Allenamento"
    );

    $params = array(
      "new" => array("color" => "success", "icon_class" => "bi bi-plus-lg", "disabled" => false),
      "edit" => array("color" => "primary", "icon_class" => "bi bi-pencil", "disabled" => true),
      "delete" => array("color" => "danger", "icon_class" => "bi bi-trash3", "disabled" => true),
      "print" => array("color" => "primary", "icon_class" => "bi bi-printer", "disabled" => false)
    );

    $code = '<div class="row contextual-navbar sticky-top">';
    $code .= '<div class="col ml-4">';
    $code .= '<h4 class="text-primary text-uppercase">';
    $code .= '<i class="fa-solid fa-folder mr-2 d-inline"></i>' . $labels[$area];
    if (!empty($section)) {
      $code .= '<i class="fa-solid fa-folder-tree mr-2 ml-4 d-inline"></i>' . $labels[$section];
      $code .= '<button type="button" id="' . $area .'_section" class="btn btn-outline-primary btn-sm btn-circle ml-2 d-inline">';
      $code .= '<i class="fa-solid fa-sort-down"></i>';
      $code .= '</button>';
    }
    $code .= '</h4></div>';
    $code .= '<div class="col text-right mr-2">';
    foreach ($buttons as $btn) {
      $btn_status = $params[$btn]["disabled"] ? " disabled" : "";

      $code .= '<button type="button" id="' . $area .'_' . $btn . '" class="btn btn-outline-' . $params[$btn]["color"] . ' btn-sm btn-circle ml-2"' . $btn_status . '>';
      $code .= '<i class="' . $params[$btn]["icon_class"] . '"></i>';
      $code .= '</button>';
    }
    $code .= '</div></div>';

    return $code;
  }

  // Crea una select con dropdown multiselezione
  function dropdown_multiselect ($model, $param, $options = [], $attributes = []) {

    $field_id = $model . "_" . $param;
    $icon = empty($attributes["icon_class"]) ? "" : '<i class="' . $attributes["icon_class"] . '"></i>';

    $code = '<div id="btn_' . $field_id . '" class="dropdown">';
    $code .= '<button class="btn btn-primary vb-btn-dropdown dropdown-toggle" type="button" id="' . $field_id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $attributes["label"] . '</button>';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_id . '">';
    foreach ($options as $opt) {
      $code .= '<button class="dropdown-item" type="button" value="' . $opt["value"] . '">' . $icon . ' ' . $opt["label"] . '</button>';
    }
    if (!empty($attributes["select_all"])) {
      $code .= '<div class="dropdown-divider"></div>';
      $code .= '<button class="dropdown-item" type="button" value="all">' . $icon . ' ' . $attributes["select_all"] . '</button>';
    }
    $code .= '</div></div>';

    return $code;
  }

  // Crea un campo con etichetta e input calendario
  function field_date ($model, $param, $label, $value, $params = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $code = '<div id="btn_' . $field_id . '" class="input-group vb-field-date mb-3">';
    $code .= '<div class="input-group-prepend">';
    $code .= '<span class="input-group-text" id="addon_' . $field_id . '">' . $label . '</span>';
    $code .= '</div>';
    $code .= '<div class="btn-group">';
    $code .= '<input type="text" id="' . $field_id . '" name="' . $field_name . '" class="form-control" placeholder="Scegli la data" />';
    if (isset($params["icon"])) {
      $code .= '<i class="' . $params["icon"] . ' input-prefix text-secondary"></i>';
    }
    $code .= '</div></div>';

    return $code;
  }

  // Crea un campo con etichetta e input dropdown
  function field_dropdown ($model, $param, $label, $value, $options) {

    global $lang_it;

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $value_shown = "n.d.";
    if (in_array($param, array("role", "account_type"))) {
      $value_shown = $lang_it[$value];
    } elseif (in_array($param, array("town", "field"))) {
      foreach($options as $opt) {
        if ($opt["value"] == $value) { $value_shown = $opt["label"]; }
      }
    } else {
      $value_shown = $value;
    }

    $code = '<div id="btn_' . $field_id . '" class="input-group vb-field-dropdown mb-3">';
    $code .= '<input type="hidden" name="' . $field_name . '" value="' . $value . '" />';
    $code .= '<div class="input-group-prepend">';
    $code .= '<span class="input-group-text" id="addon_' . $field_id . '">' . $label . '</span>';
    $code .= '</div>';
    $code .= '<div class="btn-group">';
    $code .= '<button id="' . $field_id . '" class="form-control dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $value_shown . '</button>';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_name . '">';
    foreach ($options as $opt) {
      $code .= '<a class="dropdown-item" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . '</a>';
    }
    $code .= '</div></div></div>';

    return $code;
  }

  // Crea un campo con etichetta e input text
  function field_text ($model, $param, $label, $value) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $code = '<div class="input-group vb-field-text mb-3">';
    $code .= '<div class="input-group-prepend">';
    $code .= '<span class="input-group-text" id="addon_' . $field_id . '">' . $label . '</span>';
    $code .= '</div>';
    $code .= '<input type="text" class="form-control" id="' . $field_id . '" name="' . $field_name . ']" aria-describedby="addon_' . $field_id . '" value="' . $value . '"/>';
    $code .= '</div>';

    return $code;
  }

  function modal_base ($type) {

    $code = '<!-- Modal -->';
    $code .= '<div class="modal fade" id="modal_' . $type . '" tabindex="-1" role="dialog" aria-labelledby="modal_' . $type . '_label" aria-hidden="true">';
    $code .= '<div class="modal-dialog" role="document">';
    $code .= '<div class="modal-content">';
    $code .= '<div class="modal-header">';
    $code .= '<h5 class="modal-title" id="modal_' . $type . '_label"></h5>';
    $code .= '<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    $code .= '</div>';
    $code .= '<div class="modal-body"></div>';
    $code .= '</div>';
    $code .= '</div>';
    $code .= '</div>';

    return $code;
  }
?>