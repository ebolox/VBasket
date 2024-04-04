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
    $code .= '<button class="btn ' . $btn_size . 'btn-secondary text-white" disabled>' . $label . '</button>';
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

  function button_icon ($icon_class, $bg_color, $options) {

      $btn_id = (!empty($options) && !empty($options["btn_id"])) ? $options["btn_id"] : "";
      $btn_value = (!empty($options) && !empty($options["btn_value"])) ? $options["btn_value"] : "";
      $btn_class = (!empty($options) && !empty($options["btn_class"])) ? ' ' . $options["btn_class"] : "";
      $btn_margin = (!empty($options) && !empty($options["btn_margin"])) ? ' ' . $options["btn_margin"] : "";
      $btn_hidden = (!empty($options) && !empty($options["invisible"])) ? ' invisible' : "";
      $btn_disabled = (!empty($options) && !empty($options["disabled"])) ? ' disabled' : "";

      $code = '<button type="button" id="' . $btn_id . '" class="btn btn-outline-' . $bg_color . ' btn-icon btn-circle border-0' . $btn_margin . $btn_class . $btn_hidden . '" data-value="' . $btn_value . '"' . $btn_disabled . '>';
      $code .= '<i class="' . $icon_class . '"></i>';
      $code .= '</button>';

      return $code;
  }

  // Crea un campo con icona dropdown
  function button_icon_dropdown ($model, $param, $icon_class, $value = "", $options = [], $attributes = []) {

    $field_id = $model . "_" . $param;

    // Classe per versione con icona come etichetta
    $label_class = "";
    if (!empty($attributes["label_icon"])) { $label_class = " vb-btn-icon"; }

    // Colore pulsante
    $btn_color = "btn-success";
    if (!empty($attributes["btn_color"])) { $btn_color = $attributes["btn_color"]; }

    // Dimensioni pulsante
    $btn_size = "";
    if (!empty($attributes["btn_size"]) && ($attributes[" btn_size"] == "large")) { $btn_size = "btn-lg "; }

    $code = '<div id="btn_' . $field_id . '" class="input-group vb-btn-dropdown' . $label_class . ' d-inline">';
    $code .= '<div class="btn-group ' . str_replace("btn", "btn-group", $btn_size) . 'btn-group-append">';
    $code .= '<button id="' . $field_id . '" class="btn ' . $btn_size . " btn-icon " . $btn_color . ' text-left dropdown-toggle" data-value="' . $value . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
    $code .= '<i class="' . $icon_class . '"></i>';
    $code .= '</button>';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_id . '">';
    foreach ($options as $opt) {
      $code .= '<a class="dropdown-item" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . '</a>';
    }
    if (!empty($attributes["all"])) {
      $code .= '<div class="dropdown-divider"></div>';
      $code .= '<a class="dropdown-item" href="#" data-value="all">' . $attributes["all"] . '</a>';
    }
    $code .= '</div></div></div>';

    return $code;
  }

  function button_select ($model, $param, $label, $value, $options) {

    $btn_id = $model . "_" . $param;
    $btn_name = $model . "[" . $param . "]";

    $code = '<input type="hidden" name="' . $btn_name . '" value="' . $value . '" />';
    $code .= '<div class="btn-group btn-radio" id="' . $btn_id . '" role="group" aria-label="' . $label . '">';
    foreach ($options as $opt) {
      $btn = '<span>' . $opt["label"] . '</span>';
      if (!empty($opt["icon_class"])) {
        $btn = '<i class="' . $opt["icon_class"] . '"></i>' . $btn;
      }

      $code .= '<button type="button" class="btn btn-success btn-sm" data-value="' . $opt["value"] . '">' . $btn . '</button>';
    }
    $code .= '</div>';

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

  // Crea un titolo. Eventualmente con etichetta dropdown se il modello ha aree
  function form_navbar ($area, $buttons = [], $section = false) {

    global $btn_params;
    global $vb;

    $labels = array(
      "account" => "Profilo",
      "activity" => "Attività",
      "book" => "Rubrica",
      "calendar" => "Calendario",
      "club" => "Società",
      "event" => "Evento",
      "field" => "Campi di gioco",
      "game" => "Partita",
      "registry" => "Anagrafica",
      "training" => "Allenamento",
      "all" => "Tutto"
    );

    $code = '<div class="row form-navbar sticky-top">';
    $code .= '<div class="col">';
    $code .= '<h5 class="text-uppercase mb-0">';

    // Switcher area
    $section_tags = array_merge($vb["activity"], $vb["book"]);
    if (in_array($area, $section_tags)) {
      $value = in_array($area, $vb["activity"]) ? "activity" : "book";
      $code .= button_icon ("fa-solid fa-folder-tree mr-4", "basket", array("btn_id" => "section_area", "btn_value" => $value, "btn_margin" => "mr-4"));
    }

    $code .= $labels[$area];

    // Switcher sezione
    if (!empty($section)) {

      $menu_attributes = array("btn_color" => "btn-vb", "label_icon" => true, "all" => "Tutto");
      $menu_options = array();
      foreach ($vb[$area] as $sect) {
        array_push($menu_options, array("value" => $sect, "label" => $labels[$sect]));
      }

      $code .= '<i class="bi bi-chevron-double-right mr-4 ml-4"></i>';
      $code .= '<span id="section_title" class="mr-2">' . $labels[$section] . '</span>';
      $code .= button_icon_dropdown ("section", "selector", "bi bi-caret-down-fill", $section, $menu_options, $menu_attributes);
    }

    $code .= '</h5>';
    $code .= '</div>';
    $code .= '<div class="col text-right mr-2">';
    foreach ($buttons as $btn) {
      $btn_status = !empty($btn_params[$btn]["disabled"]) ? " disabled" : "";

      $code .= button_icon ($btn_params[$btn]["icon_class"], $btn_params[$btn]["color"], array("btn_id" => $area .'_' . $btn, "btn_margin" => "ml-2", "disabled" => $btn_status));
    }
    $code .= '</div></div>';
    $code .= '<script>';
    $code .= '// Gestione righe e pulsanti della lista';
    $code .= 'set_table_events(model)';
    $code .= '</script>';

    return $code;
  }

  function item_contextual_toolbar ($section_tag, $item_id) {

    global $btn_params;

    $code = '<td scope="col" class="' . $section_tag . '-toolbar">';
    $code .= button_icon ($btn_params["edit"]["icon_class"], $btn_params["edit"]["color"], array("btn_id" => $section_tag .'_edit_' . $item_id, "btn_class" => "btn-edit", "btn_margin" => "ml-2", "invisible" => true));
    $code .= button_icon ($btn_params["delete"]["icon_class"], $btn_params["delete"]["color"], array("btn_id" => $section_tag .'_delete_' . $item_id, "btn_class" => "btn-delete", "btn_margin" => "ml-2", "invisible" => true));
    $code .= '</td>';

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

  function vb_date ($model, $param, $value = "", $options = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $code = '<div class="vb-date">';
    $code .= '<input type="text" id="' . $field_id . '" name="' . $field_name . '" class="form-control" placeholder="Scegli la data" value="' . $value . '" />';
    if (isset($params["icon"])) {
      $code .= '<i class="' . $params["icon"] . ' input-prefix text-secondary"></i>';
    }
    $code .= '</div>';

    return $code;
  }

  function vb_dropdown ($model, $param, $value = "", $options = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";
    $field_label = "";
    foreach ($options as $opt) {
      if ($opt["value"] === $value) {
        $field_label = $opt["label"];
        break;
      }
    }

    $code = '<div class="dropdown vb-dropdown">';
    $code .= '<button class="btn dropdown-toggle form-control" type="button" id="' . $field_id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="' . $param . '">' . $field_label . '</button>';
    $code .= '<input type="hidden" name="' . $field_name . '" value="' . $value . '" />';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_name . '">';
    foreach ($options as $opt) {
      $active_class = ($opt["value"] == $value) ? " active" : "";
      $active_icon = ($opt["value"] == $value) ? '<i class="fa-solid fa-check"></i>' : "";
      $code .= '<a class="dropdown-item btn-link' . $active_class . '" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . $active_icon . '</a>';
    }
    $code .= '</div>';
    $code .= '</div>';

    return $code;
  }

  function vb_text ($model, $param, $value = "", $options = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";

    $code = '<div class="vb-text">';
    $code .= '<input type="text" class="form-control" id="' . $field_id . '" name="' . $field_name . '" value="' . $value . '" placeholder="' . $param . '" />';
    $code .= '</div>';

    return $code;
  }
?>