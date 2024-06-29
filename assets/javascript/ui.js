
var calendar_words = {
  previousMonth : 'Mese precedente',
  nextMonth     : 'Mese prossimo',
  months        : ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
  weekdays      : ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
  weekdaysShort : ['Dom','Lun','Mar','Mer','Gio','Ven','Sab']
};

var mandatory_params = {
  account  : ["name_last", "name_first"],
  club     : ["name"],
  event    : ["name", "type", "town"],
  field    : ["name", "town"],
  game     : ["type", "team", "opponent"],
  team     : ["name"],
  training : ["type", "team", "field"]
};

// Aree e Sezioni
var vb = {
  activity : ["event", "game", "training"],
  book     : ["account", "club", "field", "team"]
};

var lang_it = {
  account: "Profilo",
  accounts: "Profili",
  club: "Società",
  clubs: "Società",
  event: "Evento",
  events: "Eventi",
  field: "Campo di gioco",
  fields: "Campi di gioco",
  game: "Partita",
  games: "Partite",
  team: "Squadra",
  teams: "Squadre",
  training: "Allenamento",
  trainings: "Allenamenti"
}

$(document).ready( function () {

  // Gestione menù di navigazione
  $.each(["registry", "technique", "calendar"],  function (i, param) {
    $("#navlink_" + param).click( function () {
      update_content (param);
      main_menu_selected ($(this));
    });
  });
  $("#navlink_account").click( function () { edit_object ("account", $("#account_id").val()); });
  $.each(["activity", "book"],  function (i, param) {
    $("#navlink_" + param).parent().mouseenter( function () { show_dropdown_btn ($(this)); });
    $("#navlink_" + param).parent().mouseleave( function () { show_dropdown_btn ($(this), false); });
    $("#navlink_" + param).parent().click( function () { show_dropdown_menu ($(this)); });
    $("#" + param + "_selector + .dropdown-menu").find(".dropdown-item").click( function () { update_section_by_navbar ($(this), param); });
  });
});

// Cambia l'immagine aggiornando il db
function change_picture (model) {
  $("#" + model + "_img").click( function(){ $("#" + model + "_img_file").trigger("click"); });
  $("#" + model + "_img_file").on("change", function (e) { preload_image(e, model + "_img", model, $("#form_id").val()); });
}

// Converte la stringa serializzata in un hash (oggetto JavaScript)
function convert_to_hash (encode_string) {

  var hash = {};
  var parts = encode_string.split("&");
  for (var i = 0; i < parts.length; i++) {
    var keyValue = parts[i].split("=");
    var key = decodeURIComponent(keyValue[0]);
    var value = decodeURIComponent(keyValue[1]);

    // Gestione delle chiavi annidate
    var keys = key.split(/\[|\]/).filter(function(k) { return k; });
    var lastKey = keys.pop();
    var current = hash;

    keys.forEach(function(k) {
      if (!current[k]) {
        current[k] = {};
      }
      current = current[k];
    });

    current[lastKey] = value;
  }

  return hash;
}

// Crea l'oggetto di cui si salva il nome
function create_object () {

  model = $("#form_model").val();
  parameters = convert_to_hash ($("form.vb-tab-right").serialize());

  validation = true;
  for (c in parameters[model]) {
    if (parameters[model][c] == "") { validation = false; }
  }

  if (validation) {

    params = {
      action: "create_object",
      model: model
    }
    for (c in mandatory_params[model]) {
      param = mandatory_params[model][c];
      params[param] = parameters[model][param];
    }

    update_frontend("ui_content", "logic.php", {
      parameters: $.param(params),
      method: "POST",
      asynchronous: true,
      evalScripts: true,
      onComplete: function() { console.log("create " + model + " tab complete"); },
      onLoading: function() { console.log("create " + model + " tab loading"); }
    });

  } else {
    alert("Dati obbligatori mancanti");
  }
}

// Elimina la scheda Account
function delete_account (account_id) {

  if (confirm('Sei sicuro di voler eliminare questo tesserato?')) {

    if (!account_id) {
      account_id = $("#registry_list > table > tbody > tr.text-success").attr("id").replace("object_", "");
    }
    params = {
      action: "delete_object",
      model: "account",
      id: account_id
    };

    update_backend("logic.php", {
      parameters: $.param(params),
      method: "POST",
      asynchronous: true,
      evalScripts: true,
      onComplete: function() {
        team_id = $("input[name='registry[teams]']").val();
        get_registry_by_team (team_id);
      },
      onLoading: function() { console.log("delete_account loading"); }
    });
  }
}

// Elimina un elemento permanentemente
function delete_object (event, btn, model, object_id = null) {

  if (confirm('Sei sicuro di voler eliminare questo elemento?')) {

    if (!object_id){
      row_id = (["activity", "book"].indexOf(model) >= 0) ?
        $("#" + model + "_list > table > tbody > tr.text-success").attr("id") :
        btn.parent().parent().attr("id");

      object_id = row_id.replace("object_", "");
    }

    params = {
      action: "delete_object",
      model: model,
      id: object_id
    };

    update_backend("logic.php", {
      parameters: $.param(params),
      method: "POST",
      asynchronous: true,
      evalScripts: true,
      onComplete: function() { console.log("delete_object complete"); },
      onSuccess: function() { if ($("#" + model + "_list > table > tbody > tr.text-success").length > 0) { $("#" + row_id).remove(); }},
      onLoading: function() { console.log("delete_object loading"); }
    });
  }

  event.stopPropagation();
}

// Carica la scheda dell'elemento desiderato
function edit_object (model, object_id) {

  params = {
    action: "edit_object",
    model: model,
    id: object_id
  };

  update_frontend("ui_content", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("edit " + model + " tab complete"); },
    onLoading: function() { console.log("edit " + model + " tab loading"); }
  });
}

// Carica la scheda dell'elemento selezionato da lista
function edit_object_from_list (event, btn, model = null) {

  row = btn.parent().parent();

  if (!model) {
    model = row.data("type");
  }

  object_id = row.attr("id").replace("object_", "");

  params = {
    action: "edit_object",
    model: model,
    id: object_id
  };

  update_frontend("ui_content", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("edit " + model + " tab complete"); },
    onLoading: function() { console.log("edit " + model + " tab loading"); }
  });

  event.stopPropagation();
}

// Crea la scheda nuova dell'elemento desiderato
function init_object (model = null) {

  if (!model) { model = $("#section_selector").data("value"); }

  params = {
    action: "init_object",
    model: model
  };

  update_frontend("ui_content", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("init " + model + " model complete"); },
    onLoading: function() { console.log("init " + model + " model loading"); }
  });
}

// Carica la pagina dell'account
function get_account_tab (action, update_navbar = true, account_id = null) {

  // Aggiorniamo la navbar interfaccia
  if (update_navbar) {
    main_menu_selected ($("#navlink_account"));
  }

  if (action == "edit_object" && !account_id) {
    account_id = $("#registry_list > table > tbody > tr.text-success").attr("id").replace("object_", "");
  }
  params = {
    action: action,
    model: "account",
    account_id: account_id
  };

  update_frontend("ui_content", "account.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("tab_account complete"); },
    onLoading: function() { console.log("tab_account loading"); }
  });
}

// Aggiorna la tabella al click su pulsante Sezione
function get_activity (section) {

  params = {
    action: "get_activity",
    model: section
  };

  update_frontend("activity_list", "activity.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_activity_results complete"); },
    onLoading: function () { console.log("update_activity_results loading"); }
  });
}

// Aggiorna la lista
// al click su opzione dropdown Sezione
function get_section (model, section) {

  params = {
    action: "get_section_list",
    section: section
  };

  update_frontend(model + "_list", model + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function () { console.log("update_" + section + "_results complete"); },
    onLoading: function () { console.log("update_" + section + "_results loading"); }
  });
}

// Apre una pagina in una nuova scheda
function go_to (filename, params = false) {
  page = (filename == "login") ? "/" : filename + ".php";
  if (params) { page = page + "?" + params; }

  window.open(page);
}

// Inizializza input Date con calendario Pikaday
function init_pikaday (model, object_id) {

  var calendar_picker = new Pikaday({
    field: $("#" + model + "_date_on")[0],
    format: 'D/M/YYYY',
    i18n: calendar_words,
    toString(date, format) {
      // you should do formatting based on the passed format,
      // but we will just return 'D/M/YYYY' for simplicity
      const day = date.getDate();
      const month = date.getMonth() + 1;
      const year = date.getFullYear();
  
      return `${day}/${month}/${year}`;
    },
    parse(dateString, format) {
      // dateString is the result of `toString` method
      const parts = dateString.split('/');
      const day = parseInt(parts[0], 10);
      const month = parseInt(parts[1], 10) - 1;
      const year = parseInt(parts[2], 10);
      return new Date(year, month, day);
    },
    onSelect: function() {
      value = calendar_picker.toString();
      $("#" + model + "_date_on").val(value);

      parts = value.split('/');
      day = parts[0].padStart(2, '0');
      month = parts[1].padStart(2, '0');
      year = parts[2];

      formatted_date = `${year}-${month}-${day}`;
      update_object (model, object_id, "date_on", formatted_date);
    }
  });

  return calendar_picker;
}

// Mostra il menù principale per l'elemento selezionato
function main_menu_selected (selected) {

  if (selected.attr("class").match("dropdown-item")) {
    tag = selected.data("value");
    area_tag = "activity";

    $.each(vb, function(key, values) {
      if (values.includes(tag)) {
        area_tag = key;
        return false;
      }
    });

    navlink = $("#navlink_" + area_tag);
  } else {
    tag = selected.attr("id").replace("navlink_", "");
    navlink = selected;
  }

  $(".vb-navbar").hide();
  $(".navlink.active").removeClass("active");
  navlink.addClass("active");

  if (tag != "account") {
    $("#" + tag + "_button_bar").show();
  }

  // Nasconde il menu dropdown
  $(".dropdown-menu.show").removeClass("show");
}

// Compone e mostra/nasconde la modale di scelte
function modal_choice (show, title = false, choices = {}) {

  // Se show è false o esiste già, la modale si chiude
  modal_hide ("modal_choice", show);

  // Creiamo il blocco delle scelte sottoforma di pulsanti
  choices_code = $(".modal-choices");
  if (choices_code.length == 0) {
    choices_code = $("<div></div>").addClass("modal-choices text-center");
  }
  for (key in choices) {
    choices_code.append('<button type="button" class="btn btn-sm ' + choices[key]["class"] + '" data-value="' + choices[key]["tag"] + '" onclick="' + choices[key]["click"] + '">' + choices[key]["label"] + '</button>');
  }

  modal_fill ("modal_choice", title, choices_code);
  modal_show ("modal_choice");
}

// Compila la modale
function modal_fill (id, title, content) {
  // Titolo e scelte in modale
  $("#" + id + "_label").text(title);
  $("#" + id + " .modal-body").empty().append(content);
}

// Nasconde la modale tramite id
function modal_hide (id, show = false) {

  modal = $("#" + id);
  // Se show è false o esiste già, la modale si chiude
  if (!show && modal.is(":visible")) {
    // Modale nascosta e layer rimosso
    modal.fadeOut().removeClass("show");
    $(".modal-backdrop").remove();
    return false;
  }
}

// Mostra la modale ed il suo sfondo
function modal_show (id) {
  // Layer grigio sull'interfaccia
  modal_cover = $(".modal-backdrop");
  if (modal_cover.length == 0) {
    modal_cover = $("<div></div>").addClass("modal-backdrop fade");
    $("body").append(modal_cover);
  }

  // Modale e layer mostrati
  modal_cover.addClass("show");
  modal = $("#" + id);
  modal.fadeIn().addClass("show");
}

// Gestisce il click su riga di tabella
function object_selected (context, row) {

  is_selected = !row.attr("class").match("text-success");
  object_id = row.attr("id").replace("object_", "");
  cell_check = row.find("td").first();
  icon_checked = "<i class=\"bi bi-check-circle-fill\"></i>";

  if (is_selected) {
    row.addClass("text-success");
    cell_check.html(icon_checked);
  } else {
    row.removeClass("text-success");
    cell_check.html(object_id);
  }
}

// Mostra/nasconde la barra laterale
function sidebar_collapse (id, context) {

  change_content = false;
  if ((context == "config" && $("#eboard_effects").is(":visible")) || (context == "effects" && $("#eboard_config").is(":visible"))) {
    change_content = true;
  }

  // Mostra il contenuto richiesto
  if (context == "config") {
    $("#eboard_config").show();
    $("#eboard_effects").hide();
  } else {
    $("#eboard_config").hide();
    $("#eboard_effects").show();
  }

  if (!change_content) {
    sidebar = $("#" + id);
    right_pos = parseInt(sidebar.css("right")) == 0 ? "-300px" : "0px";

    // Movimento orizzontale della sidebar
    sidebar.animate({ "right": right_pos }, "slow");
  }
}

// Precarica un'immagine e aggiorna il db
function preload_image (e, target_id, object_type, object_id) {
  var file = e.target.files[0];
  var reader = new FileReader();

  reader.onload = function(eve){
    filename = eve.target.result;

    if (file.size > 5000000) {
      alert('La dimensione del file supera i 5 MB.');
      return;
    }
    if (!file.type.match('image.*')) {
      alert('Si prega di selezionare un file immagine.');
      return;
    }

    var formData = new FormData();
    formData.append("file", file);
    formData.append("action", "upload_image");
    formData.append("object_type", object_type);
    formData.append("object_id", object_id);

    $.ajax({
      url: "logic.php",
      type: "POST",
      data: formData,
      parameters: $.param(params),
      contentType: false,
      processData: false,
      success: function(response) {
        console.log(response);
        $('#' + target_id).attr('src', filename);
      },
      error: function(xhr, status, error) {
        console.error(error);
        alert("Errore durante l'upload del file.");
      }
    });
  };

  reader.readAsDataURL(file);
}

// Stampa lo schermo usando btn
// come riferimento per il soggetto della stampa
function print_screen (btn) {
  window.print();
}

function set_checked ( elem ) {
  input_name = elem.attr("id").split("_");
  input_value = elem.attr("class").match("success") ? false : true;

  $("input[name='" + input_name[0] + "[" + input_name[1] + "]']").val( input_value );
  elem.toggleClass("btn-danger").toggleClass("btn-success");
  elem.find("i.bi").toggleClass("bi-check-lg").toggleClass("bi-x-lg");

}

// Aggiorna la dropdown al click su un'opzione
function set_dropdown (model, object_id, opt, opt_objects) {

  opt_objects.each( function () {
    $(this).removeClass("text-success");
  });
  opt.addClass("text-success");

  name = opt.text();
  $("#" + model + "_" + object_id).text(name);

  tag = opt.data("value");
  $("input[name='" + model + "[" + object_id + "]']").val(tag);

  return tag;
}

// Aggiorna il menu dropdown al click su un'opzione
function set_dropdown_menu (opt) {

  dd_menu = opt.parent();
  menu_options = dd_menu.find(".dropdown-item");

  menu_options.show();
  opt.hide();
  dd_menu.removeClass("show");
}

// Assegna gli eventi a righe e pulsanti
function set_list_events (model, section_tag) {

  // Si aggiorna il selettore alla sezione attuale
  $("#section_selector").data("value", section_tag);

  // Gestione righe della tabella
  rows = $("#" + model + "_list > table > tbody > tr");

  // Click sulla riga: de/seleziona
  rows.click( function () { object_selected (model, $(this)); });

  // Mouseover sulla riga: mostra/nasconde i pulsanti contestuali
  rows.mouseenter( function () { show_toolbar ($(this), true); });
  rows.mouseleave( function () { show_toolbar ($(this), false); });

  // Click su pulsanti contestuali
  rows.find("button.btn-edit").click( function () { edit_object_from_list (event, $(this), section_tag); });
  rows.find("button.btn-delete").click( function () { delete_object (event, $(this), section_tag); });
}

function set_radio_value (btn_radio) {
  btn = btn_radio.parent();
  btn_id = btn.attr("id").split("_");
  btn_hidden = $("input[name='" + btn_id[0] + "[" + btn_id[1] + "]']");

  btn_value = btn_radio.data("value");
  hidden_value = btn_value.replace("_parameters", "");
  

  btn.find(".btn.active").removeClass("active");
  btn_radio.addClass("active");
  btn_hidden.val(hidden_value);
}

// Gestione dei pulsanti Scheda (tab)
function set_tab_buttons (action, model, object_id) {

  if (action == "init_object") {
    $("#tab_create").click(function () { create_object (); });
  }

  if (action == "edit_object") {
    //$("#tab_print").click(function () { print_screen ($(this)); });
    $("#tab_new").click(function () { init_object (model); });
    $("#tab_delete").click(function () { delete_object (event, $(this), model, object_id); });
    $("#tab_delete").removeAttr('disabled');
  }

  parent_area = vb["activity"].indexOf(model) >= 0 ? "activity" : "book";
  $("#tab_close").click( function () { update_content (parent_area, { last_view: model }); });
}

function set_value ( elem ) {
  input_name = elem.parent().attr("aria-labelledby");
  input_id = input_name.replace("]", "").replace("[", "_");
  input_value = elem.data("value");

  $("input[name='" + input_name + "']").val( input_value );
  $("#" + input_id).text( elem.text() );
}

// Mostra/nasconde la freccia dropdown
// e aggiorna le opzioni disponibili
function show_dropdown_btn (navlink, visible = true) {

  btn_dropdown = navlink.find(".vb-btn-dropdown");

  visible ?
    btn_dropdown.removeClass("invisible") :
    btn_dropdown.addClass("invisible");
}

// Mostra/nasconde il menù dropdown
function show_dropdown_menu (navlink) {

  menu_dropdown = navlink.find(".vb-btn-dropdown .dropdown-menu");

  menu_dropdown.is(":visible") ?
    menu_dropdown.removeClass("show") :
    menu_dropdown.addClass("show");
}

// Mostra/nasconde i pulsanti edita/elimina riga
function show_toolbar (row, show) {

  if (row.is('li')) {
    toolbar = row.find("button.btn-icon");
  } else {
    context = row.data("type");
    toolbar = row.find("td." + context + "-toolbar button.btn-icon");
  }

  show ? toolbar.removeClass("invisible").addClass("visible") : toolbar.removeClass("visible").addClass("invisible");
}

// Passa da pulsante Edit a field e viceversa
function switch_to_edit (event, field) {

  event.preventDefault();

  btn = field.prev();

  if (field.val() == "" && btn.is(":hidden")) {

    btn.show();
    field.hide();
  } else {
console.log("val: " + field.val());
    btn.hide();
    field.show();
    field.focus();
  }
}

// Aggiorna il db
function update_backend (url, options) {

  options = options || {};

  $.ajax({
    url: url,
    method: options.method ? options.method : 'GET',
    data: options.parameters,
    asynchronous: options.asynchronous,
    dataType: options.evalScripts ? 'script' : 'text',
    beforeSend: options.onLoading,
    success: function (res) {

      return res;
    },
    error: function(xhr, status, error) {
      console.log('update_backend error:', error);
    },
    statusCode: {
      401: function(){
        // Redirect the to the login page.
        location.href = "login";
      }
    }
  });
}

// Carica la pagina dell'anagrafica
function update_content (page, parameters = []) {

  params = [];
  if (parameters) {
    params = {
      last_view: parameters["last_view"] ?
                  parameters["last_view"] :
                  (parameters["section"] ? parameters["section"] : parameters["section"])
    };
  }

  update_frontend("ui_content", page + ".php", {
    parameters: $.param(parameters),
    asynchronous: true,
    evalScripts: true,
    onLoading: function() { console.log("update_content loading"); },
    onComplete: function() {
      if (params && params.hasOwnProperty("last_view")) {
        $("#section_title").text(lang_it[params["last_view"] + "s"]);
      }

      console.log("update_content complete");
    },
  });
}

// Aggiorna la pagina con dati da server
function update_frontend (container, url, options) {

  options = options || {};
console.log("updating: " + container + " #\n\n" +  url + " #\n\n" + options.parameters);

  $.ajax({
    url: url,
		method: options.method ? options.method : "GET",
    data: options.parameters,
		asynchronous: options.asynchronous,
    dataType: "html",
    beforeSend: options.onLoading,
    success: function (response) {

      // container can either be an id or an object { success: ..., failure: ... }
      var container_obj = container.success ? container.success : $("#" + container);
      container_obj.html(response);

    },
    error: function(xhr, status, error) {
      console.log("update_frontend error:", error);
    },
    statusCode: {
      401: function(){
        // Redirect the to the login page.
        location.href = "login";
      }
    }
  });
}

// Se init == true: gestisce pulsante Salva
// Se init == false: aggiorna i dati dell'object passato
function update_object (model, object_id, param, value, init = false) {

  if (init) {

    btn_save = $("#" + model + "_save");
    value == "" ? btn_save.attr("disabled", "disabled") : btn_save.removeAttr("disabled");
  } else {

    params = {
      action: "update_object",
      model: model,
      id: object_id,
      param: param,
      value: value
    };

    update_backend("logic.php", {
      parameters: $.param(params),
      method: "POST",
      asynchronous: true,
      evalScripts: false,
      onComplete: function() { console.log("update_" + model + " complete"); },
      onLoading: function() { console.log("update_" + model + " loading"); }
    });
  }
}

// Aggiorna la pagina alla Sezione cliccata
function update_section_by_list_toolbar (model, btn) {

  section_tag = btn.data("value");
  section_title = btn.text();
  section_switcher = $("#section_selector + .dropdown-menu");

  // Aggiorna la variabile globale
  section = section_tag;

  // Aggiorna icona dropdown
  section_switcher.find(".dropdown-item").show();
  section_switcher.find(".dropdown-item[data-value='" + section_tag + "']").hide();

  // Aggiorna il titolo della Sezione
  $("#section_btn").attr("data-value", section_tag);
  $("#section_title").text(section_title);

  // Aggiorna la lista della Sezione
  get_section (model, section_tag);
}

// Aggiorna la pagina alla Sezione cliccata
function update_section_by_navbar (btn, param) {

  update_content (param, { section: btn.data("value") });
  main_menu_selected (btn);
  set_dropdown_menu (btn);
}