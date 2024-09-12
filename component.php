<?php
  // 
  function account_mandatory_data ($data) {

    $code = '<div class="">';

    if ($data["purpose"] == "registration") {

      $code .= '<div class=""><label>Iscrizione</label></div>';
      $code .= '<div class=""><label>Prima rata</label></div>';
      $code .= '<div class=""><label>Seconda rata</label></div>';
    } else {

      $code .= '<div class=""><label>' . $data["purpose"] . '</label></div>';
    }

    $code .= '</div>';
  }

  // Icona/simbolo del Ruolo all'interno della squadra
  function account_marker ($role, $text) {

    return '<span class="role-' . $role . ' mr-2">' . $text . '</span>';
  }

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
    if (!empty($attributes["btn_size"])) { $btn_size = $attributes["btn_size"] == "large" ? "btn-lg " : ""; }

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

      $btn_id = (!empty($options) && !empty($options["id"])) ? $options["id"] : "";
      $btn_value = (!empty($options) && !empty($options["value"])) ? $options["value"] : "";
      $btn_class = (!empty($options) && !empty($options["class"])) ? " " . $options["class"] : "";
      $btn_size = (!empty($options) && !empty($options["size"])) ? " " . $options["size"] : "";
      $btn_shape = (!empty($options) && !empty($options["shape"])) ? " btn-" . $options["shape"] : "";
      $outline = (!empty($options) && !empty($options["shape"])) ? true : false;
      $btn_style = $bg_color == "vb" ? "btn-icon btn-vb" : "btn" . ($outline ? "-outline" : "") . "-" . $bg_color . ($outline ? " btn-icon" : "");
      $btn_margin = (!empty($options) && !empty($options["margin"])) ? " " . $options["margin"] : "";
      $btn_hidden = (!empty($options) && !empty($options["invisible"])) ? " invisible" : "";
      $btn_disabled = (!empty($options) && !empty($options["disabled"])) ? " disabled" : "";

      $code = '<button type="button" id="' . $btn_id . '" class="btn ' . $btn_style . $btn_shape . ' border-0' . $btn_class . $btn_size . $btn_margin . $btn_hidden . '" data-value="' . $btn_value . '"' . $btn_disabled . '>';
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

    // Pulsante gruppo di elementi (input-group)
    $btn_group = " input-group ";
    if (isset($attributes["btn_group"]) && $attributes["btn_group"] === false) { $btn_group = ""; }

    // Colore nascosto
    $btn_hidden = "";
    if (isset($attributes["btn_hidden"]) && $attributes["btn_hidden"] === true) { $btn_hidden = " invisible"; }

    // Colore pulsante
    $btn_color = "btn-success";
    if (!empty($attributes["btn_color"])) { $btn_color = $attributes["btn_color"]; }

    // Dimensioni pulsante
    $btn_size = "";
    if (!empty($attributes["btn_size"])) { $btn_size = $attributes["btn_size"] == "large" ? "btn-lg " : "btn-sm "; }

    $code = '<div id="btn_' . $field_id . '" class="vb-btn-dropdown' . $label_class . $btn_group . $btn_hidden . ' d-inline">';
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
    $btn_icon = (!empty($attributes["label"]) && strpos($attributes["label"], "</i>") !== false) ? "vb-btn-icon " : "";
    $btn_size = empty($attributes["size"]) ? "" : $attributes["size"];

    $code = '<div id="btn_' . $field_id . '" class="dropdown">';
    $code .= '<button class="btn btn-primary ' . $btn_size . $btn_icon . 'vb-btn-dropdown dropdown-toggle" type="button" id="' . $field_id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $attributes["label"] . '</button>';
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

  // Crea il box Immagine
  function field_image ($model, $filename) {

    $code = '<div class="box-image">';
    $code .= '<div class="vb-image">';
    $code .= '<img id="' . $model . '_img" class="img-fluid" src="' . $filename . '" />';
    $code .= '<input type="file" id="' . $model . '_img_file" class="d-none">';
    $code .= '</div></div>';

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
    global $lang_it;
    $rachid = init_pluralizer();

    $code = '<div class="row form-navbar sticky-top">';
    $code .= '<div class="col">';
    $code .= '<h5 class="text-uppercase mb-0">';

    // Switcher area
    $section_tags = array_merge($vb["activity"], $vb["book"]);
    if (in_array($area, $section_tags)) {
      $value = in_array($area, $vb["activity"]) ? "activity" : "book";
      $code .= button_icon ("bi bi-caret-down-fill", "vb", array("id" => "section_area", "value" => $value, "shape" => "circle", "margin" => "ml-4"));
    }

    $code .= $lang_it[$area];

    // Switcher sezione
    if (!empty($section)) {

      $menu_attributes = array("btn_color" => "btn-vb", "label_icon" => true);
      $menu_options = array();
      foreach ($vb[$area] as $sect) {
        array_push($menu_options, array("value" => $sect, "label" => $lang_it[$rachid->pluralize($sect)]));
      }

      $code .= '<i class="bi bi-chevron-double-right mr-3 ml-3"></i>';
      $code .= '<span id="section_title" class="mr-2">' . $lang_it[$section] . '</span>';
      $code .= button_icon_dropdown ("section", "selector", "bi bi-caret-down-fill", $section, $menu_options, $menu_attributes);
    }

    $code .= '</h5>';
    $code .= '</div>';
    $code .= '<div class="col text-right mr-3">';
    foreach ($buttons as $btn) {
      $btn_status = !empty($btn_params[$btn]["disabled"]) ? " disabled" : "";

      $code .= button_icon ($btn_params[$btn]["icon_class"], $btn_params[$btn]["color"], array("id" => $area .'_' . $btn, "shape" => "circle", "margin" => "ml-2", "disabled" => $btn_status));
    }
    $code .= '</div></div>';

    return $code;
  }

  // Icona attivo/disattivo
  function icon_arrow ($direction = "right", $class_name = "") {

    return '<i class="bi bi-chevron-' . $direction . ' ' . $class_name . '"></i>';
  }

  // Icona attivo/disattivo
  function icon_selected ($select_status = true, $size = "") {

    switch ($size){
      case "large": $size = "-lg"; break;
      default: $size = ""; break;
    }

    $code = $select_status ?
              '<i class="bi bi-check' . $size . ' text-success"></i>' :
              '<i class="bi bi-x' . $size . ' text-danger"></i>';

    return $code;
  }

  // Icona attivo/disattivo
  function icon ($icon_class, $options = []) {

    $icon_color = "";
    $btn_classes = "";
    $other_classes = "";

    if (isset($options)) {
      if (isset($options["icon_color"])) { $icon_color = " " . $options["icon_color"]; }
      if (isset($options["other_classes"])) { $other_classes = " " . $options["other_classes"]; }
      if (isset($options["is_button"])) { $btn_classes = " btn btn-vb"; }
    }
    return '<i class="' . $icon_class . $icon_color . $btn_classes . $other_classes . '"></i>';
  }

  function icon_upload () {
    $code = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-plus" viewBox="0 0 16 16">';
    $code .= '<path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5"/>';
    $code .= '<path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z"/>';
    $code .= '</svg>';

    return $code;
  }

  function link_text ($context, $tag, $label, $icon_class, $options = []) {

    $btn_id = $context . "_" . $tag;

    $code = '<div class="mt-3 mr-3 ml-3 d-inline-block">';
    $code .= '<a id="' . $btn_id . '" class="btn-link ' . $context . ' mr-1" href="#">';
    $code .= '<i class="' . $icon_class . ' mr-2"></i><span>' . $label . '</span>';
    $code .= '</a>';
    if (!empty($options)) {
      $code .= '<div class="dropdown-menu" aria-labelledby="' . $btn_id . '">';
      foreach ($options as $opt) {
        $code .= '<a class="dropdown-item btn-link" href="#" data-value="' . $opt["value"] . '">' . $opt["label"] . '</a>';
      }
      $code .= '</div>';
    }
    $code .= '</div>';

    return $code;
  }

  function list_empty ($section_tag) {

    global $lang_it;
    global $female_words;
    $rachid = init_pluralizer();

    $first_add = in_array($section_tag, $female_words) ? " la prima" : " il primo";

    $code = '<div class="mt-2 mb-2">';
    $code .= '<span class="mr-3 ml-3">0 ' . $lang_it[$rachid->pluralize($section_tag)] . ' presenti.</span>';
    $code .= link_text ("section", "new", "Aggiungi" . $first_add, "");
    $code .= '</div>';

    return $code;
  }

  // Funzione per rendere maiuscola la prima lettera di una stringa multibyte
  function mb_ucfirst($string, $encoding = 'UTF-8') {
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $restOfString = mb_substr($string, 1, null, $encoding);

    return mb_strtoupper($firstChar, $encoding) . $restOfString;
  }

  function modal_base ($type) {

    $code = modal_base_header ($type);
    $code .= modal_base_footer ();

    return $code;
  }

  function modal_base_footer () {

    return '</div></div></div></div>';
  }

  function modal_base_header ($type) {

    $code = '<!-- Modal -->';
    $code .= '<div class="modal fade" id="modal_' . $type . '" tabindex="-1" role="dialog" aria-labelledby="modal_' . $type . '_label" aria-hidden="true">';
    $code .= '<div class="modal-dialog" role="document">';
    $code .= '<div class="modal-content">';
    $code .= '<div class="modal-header">';
    $code .= '<h5 class="modal-title" id="modal_' . $type . '_label"></h5>';
    $code .= '<span class="ml-4" id="modal_' . $type . '_toolbar"></span>';
    $code .= '<button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    $code .= '</div>';
    $code .= '<div class="modal-body" id="modal_' . $type . '_content">';

    return $code;
  }

  function modal_compiled ($type, $filename) {

    $code = modal_base_header ($type);
    ob_start(); // Avvia il buffering dell'output
    include $filename; // Include il file contenente il codice PHP
    $code .= ob_get_clean(); // Ottiene l'output del buffer e lo pulisce
    $code .= modal_base_footer ();

    return $code;
  }

  function object_contextual_toolbar ($section_tag, $object_id) {

    global $btn_params;

    $code = '<td scope="col" class="' . $section_tag . '-toolbar">';
    $code .= button_icon ($btn_params["edit"]["icon_class"], $btn_params["edit"]["color"], array("id" => $section_tag .'_edit_' . $object_id, "class" => "btn-edit", "shape" => "circle", "margin" => "ml-2", "invisible" => true));
    $code .= button_icon ($btn_params["delete"]["icon_class"], $btn_params["delete"]["color"], array("id" => $section_tag .'_delete_' . $object_id, "class" => "btn-delete", "shape" => "circle", "margin" => "ml-2", "invisible" => true));
    $code .= '</td>';

    return $code;
  }

  function roster_details ($members, $coach_ids, $assistant_ids, $staff_ids, $player_ids) {

    $code = '<div id="roster_details">';

    if ((count($coach_ids) + count($assistant_ids) + count($staff_ids)) > 0) {
      $code = '<div>';
      $code = roster_group($members, $coach_ids, "COACH");
      $code = roster_group($members, $assistant_ids, "ASSISTENTI");
      $code = roster_group($members, $staff_ids, "STAFF");
      $code = '</div>';
    }
    if (count($player_ids) > 0) {
      $code = '<div>';
      $code = roster_group($members, $player_ids, "GIOCATORI");
      $code = '</div>';
    }

    $code = '</div>';

    return $code;
  }

  // Crea un titolo. Eventualmente con etichetta dropdown se il modello ha aree
  function tab_title ($area, $section = false) {

    global $lang_it;

    $code = '<div class="vb-tab-title text-uppercase underlined pr-3 pb-1 mb-3">';
    $code .= '<i class="bi bi-file-earmark-richtext mr-2 ml-4"></i>' . $lang_it[$area];
    $code .= '</div>';

    return $code;
  }

  // Crea la toolbar della scheda
  function tab_toolbar ($action) {

    $code = '<div class="vb-tab-toolbar pb-1 mb-3">';
    if ($action == "init_object") {
			$code .= button_icon ("bi bi-floppy", "success", array("id" => "tab_create", "shape" => "circle"));
    } else {
			$code .= button_icon ("bi bi-plus-lg", "success", array("id" => "tab_new", "shape" => "circle"));
      $code .= button_icon ("bi bi-trash3", "danger", array("id" => "tab_delete", "shape" => "circle", "margin" => "ml-3"));
    }
    $code .= button_icon ("bi bi-x-lg", "danger", array("id" => "tab_close", "shape" => "circle", "margin" => "ml-3"));
    $code .= '</div>';

    return $code;
  }

  // Crea un titolo. Eventualmente con etichetta dropdown se il modello ha aree
  function tab_toolbar_never_used ($area, $buttons = []) {

    global $btn_params;
    global $vb;

    $code = '<div class="row form-navbar sticky-top">';
    $code .= '<div class="col text-right mr-2">';
    foreach ($buttons as $btn) {
      $btn_status = !empty($btn_params[$btn]["disabled"]) ? " disabled" : "";

      $code .= button_icon ($btn_params[$btn]["icon_class"], $btn_params[$btn]["color"], array("id" => $area .'_' . $btn, "shape" => "circle", "margin" => "ml-2", "disabled" => $btn_status));
    }
    $code .= '</div></div>';

    return $code;
  }

  function vb_boolean ($model, $param, $value, $label_on = false, $label_off = false) {

    $btn_id = $model . '_' . $param;
    $btn_name = $model . '[' . $param . ']';

    if (empty($label_on)) { $label_on = icon_selected(true, "large"); }
    if (empty($label_off)) { $label_off = icon_selected(false, "large"); }

    $code = '<button class="form-control vb-boolean" id="' . $btn_id . '" name="' . $btn_name . '" data-value="' . $value . '">';
    $code .= '<span class="vb-boolean-label">' . ($value ? $label_on : $label_off) . '</span>';
    $code .= '<sub class="vb-boolean-on">' . $label_on . '</sub>';
    $code .= '<sub class="vb-boolean-off">' . $label_off . '</sub>';
    $code .= '</button>';

    return $code;
  }

  function vb_color ($model, $param, $value) {
    $code = '<input type="color" class="form-control form-control-color vb-color" id="' . $model . '_' . $param . '" name="' . $model . '[' . $param . ']" value="' . $value . '">';

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

  function vb_dropdown ($model, $param, $value = "", $options = [], $attributes = []) {

    $field_id = $model . "_" . $param;
    $field_name = $model . "[" . $param . "]";
    $field_label = '<i class="bi bi-pencil"></i>';
    foreach ($options as $opt) {
      if ($opt["value"] == $value) {
        $field_label = $opt["label"];
        break;
      }
    }

    // Dimensioni pulsante
    $btn_size = "";
    if (!empty($attributes["btn_size"])) { $btn_size = $attributes["btn_size"] == "large" ? "btn-lg " : "btn-sm "; }

    $code = '<div class="dropdown vb-dropdown">';
    $code .= '<button class="btn ' . $btn_size . 'dropdown-toggle form-control" type="button" id="' . $field_id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="' . $param . '">' . $field_label . '</button>';
    $code .= '<input type="hidden" name="' . $field_name . '" value="' . $value . '" />';
    $code .= '<div class="dropdown-menu" aria-labelledby="' . $field_name . '">';
    foreach ($options as $opt) {
      $active_class = ($opt["value"] == $value) ? " active" : "";
      $active_icon = ($opt["value"] == $value) ? '<i class="bi bi-check"></i>' : "";
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
    $code .= '<button class="btn form-control btn-edit" style="' . (empty($value) ? '' : ' display: none;') . '"><i class="bi bi-pencil"></i></button>';
    $code .= '<input type="text" class="form-control" id="' . $field_id . '" name="' . $field_name . '" value="' . $value . '" placeholder="' . $param . '" style="' . (empty($value) ? ' display: none;' : '') . '" />';
    $code .= '</div>';

    return $code;
  }
?>