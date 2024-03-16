
var calendar_words = {
  previousMonth : 'Mese precedente',
  nextMonth     : 'Mese prossimo',
  months        : ['Gennaio','Febbraio','Marzo','Aprile','Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'],
  weekdays      : ['Domenica','Lunedì','Martedì','Mercoledì','Giovedì','Venerdì','Sabato'],
  weekdaysShort : ['Dom','Lun','Mar','Mer','Gio','Ven','Sab']
};

$(document).ready( function () {

  // Gestione menù di navigazione
  $.each(["registry", "technique", "book", "calendar", "activity"],  function (i, param) {console.log("#navlink_" + param + ": " + $("#navlink_" + param).length);
    $("#navlink_" + param).click( function () { open_page (param); });
  });
  $("#navlink_account").click(function () { get_account_tab ("edit", $("#account_id").val()); });

  // Gestisce il menù principale per l'elemento selezionato
  $("#ui_navbar nav a").not("#navlink_account, #navlink_home").click( function () { main_menu_selected ($(this)); });
});

// Cambia l'immagine aggiornando il db
function change_picture (model) {
  $("#" + model + "_img").click( function(){ $("#" + model + "_img_file").trigger("click"); });
  $("#" + model + "_img_file").on("change", function (e) { preload_image(e, model + "_img", model, $("#" + model + "_id").val()); });
}

// Elimina la scheda Account
function delete_account (account_id) {

  if (confirm('Sei sicuro di voler eliminare questo tesserato?')) {

    if (!account_id) {
      account_id = $("#registry_list > table > tbody > tr.text-success").attr("id").replace("item_", "");
    }
    params = {
      action: "delete_item",
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
function delete_item (model = null, item_id = null) {

  if (confirm('Sei sicuro di voler eliminare questo elemento?')) {

    if (!model) {
      model = $("input[name='book[section]']").val();
    }
    if (!item_id) {
      item_id = $("#book_list > table > tbody > tr.text-success").attr("id").replace("item_", "");
    }
    params = {
      action: "delete_item",
      model: model,
      id: item_id
    };

    update_backend("logic.php", {
      parameters: $.param(params),
      method: "POST",
      asynchronous: true,
      evalScripts: true,
      onComplete: function() { console.log("delete_item complete"); },
      onLoading: function() { console.log("delete_item loading"); }
    });
  }
}

// Carica la pagina dell'account
function get_account_tab (action, account_id = null) {

  // Aggiorniamo la navbar interfaccia
  main_menu_selected ($("#navlink_account"));

  if (action == "edit" && !account_id) {
    account_id = $("#registry_list > table > tbody > tr.text-success").attr("id").replace("item_", "");
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

// Carica la scheda dell'elemento desiderato
function get_item_tab (model, action, tab = null, item_id = null) {

  if (!tab) {
    tab = $("input[name='" + model + "[section]']").val();
  }
  if (action == "edit" && !item_id) {
    item_id = $("#" + model + "_list > table > tbody > tr.text-success").attr("id").replace("item_", "");
  }
  params = {
    action: action,
    model: tab,
    id: item_id
  };

  update_frontend("ui_content", tab + ".php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("get_item_tab complete"); },
    onLoading: function() { console.log("get_item_tab loading"); }
  });
}

// Aggiorna la tabella al click su opzione dropdown Area
function get_activity (section_tag) {

  params = {
    action: "get_activity",
    section_tag: section_tag
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

// Gestisce il click su riga di tabella
function item_selected (context, row, buttons) {

  is_selected = !row.attr("class").match("text-success");
  item_id = row.attr("id").replace("item_", "");
  cell_check = row.find("td").first();
  icon_checked = "<i class=\"bi bi-check-circle-fill\"></i>";
  btn_edit = $("#" + context + "_edit");
  btn_delete = $("#" + context + "_delete");

  btn_edit.prop("disabled", true);
  btn_delete.prop("disabled", true);

  if (is_selected) {
    row.addClass("text-success");
    cell_check.html(icon_checked);
    if (buttons) {
      btn_edit.prop("disabled", false);
      btn_delete.prop("disabled", false);
    }
  } else {
    row.removeClass("text-success");
    cell_check.html(item_id);
  }
}

// Mostra il menù principale per l'elemento selezionato
function main_menu_selected (selected) {

  tag = selected.attr("id").replace("navlink_", "");

  $(".vb-navbar").hide();
  $(".navlink.active, .btn-link.active").removeClass("active");

  selected.addClass("active");
  if (tag != "account") {
    $("#" + tag + "_button_bar").show();
  }
}

// Carica la pagina dell'anagrafica
function open_page (page) {

  update_frontend("ui_content", page + ".php", {
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("open_page complete"); },
    onLoading: function() { console.log("open_page loading"); }
  });
}

// Precarica un'immagine e aggiorna il db
function preload_picture (e, target_id, object_type, object_id) {
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

// Stampa scheda
function print_item_tab () {
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
function set_dropdown (model, item_id, opt, opt_items) {

  opt_items.each( function () {
    $(this).removeClass("text-success");
  });
  opt.addClass("text-success");

  name = opt.text();
  $("#" + model + "_" + item_id).text(name);

  tag = opt.attr("data-value");
  $("input[name='" + model + "[" + item_id + "]']").val(tag);

  return tag;
}

function set_radio_value (btn_radio) {
  btn = btn_radio.parent();
  btn_id = btn.attr("id").split("_");
  btn_hidden = $("input[name='" + btn_id[0] + "[" + btn_id[1] + "]']");

  btn_value = btn_radio.attr("data-value");
  hidden_value = btn_value.replace("_parameters", "");
  

  btn.find(".btn.active").removeClass("active");
  btn_radio.addClass("active");
  btn_hidden.val(hidden_value);
}

// Gestione dei pulsanti Scheda (tab)
function set_tab_buttons (action, model, item_id) {

  if (action == "new") {
    $.each(["new", "edit", "print"],  function (i, param) {
      $("#" + model + "_" + param).hide();
    });
  }

  if (action == "edit") {
    $("#" + model + "_print").click(function () { print_item_tab (); });
    $("#" + model + "_new").click(function () { get_item_tab ("new", model) });
    $("#" + model + "_edit").hide();
  }

  $("#" + model + "_delete").click(function () { delete_item (model, item_id); });
  $("#" + model + "_delete").removeAttr('disabled');
}

function set_value ( elem ) {
  input_name = elem.parent().attr("aria-labelledby");
  input_id = input_name.replace("]", "").replace("[", "_");
  input_value = elem.attr("data-value");

  $("input[name='" + input_name + "']").val( input_value );
  $("#" + input_id).text( elem.text() );
}

// Compone e mostra/nasconde la modale di scelte
function show_modal_choice (show, title = false, choices = {}) {

  // Se show è false o esiste già, la modale si chiude
  if (!show) {

    // Modale nascosta e layer rimosso
    $("#modal_choice").fadeOut().removeClass("show");
    $(".modal-backdrop").remove();
    return false;
  }

  // Creiamo il blocco delle scelte sottoforma di pulsanti
  choices_code = $("<div></div>").addClass("modal-choices text-center");
  for (key in choices) {
    choices_code.append('<button type="button" class="btn btn-sm ' + choices[key]["class"] + '" onclick="' + choices[key]["click"] + '">' + choices[key]["label"] + '</button>');
  }

  // Titolo e scelte in modale
  $("#modal_choice_label").text(title);
  $("#modal_choice .modal-body").empty().append(choices_code);

  // Layer grigio sull'interfaccia
  modal_cover = $("<div></div>").addClass("modal-backdrop fade");
  $("body").append(modal_cover);

  // Modale e layer mostrati
  modal_cover.addClass("show");
  $("#modal_choice").fadeIn().addClass("show");
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

// Aggiorna la pagina con dati da server
function update_frontend (container, url, options) {

  options = options || {};

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

// Aggiorna i dati dell'item passato
function update_item (model, item_id, param, value) {

  params = {
    action: "update_item",
    model: model,
    id: item_id,
    param: param,
    value: value
  };

  update_backend("logic.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onComplete: function() { console.log("update_" + model + " complete"); },
    onLoading: function() { console.log("update_" + model + " loading"); }
  });
}