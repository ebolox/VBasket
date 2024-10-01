$(document).ready( function () {

  model = "presences";

  // De/Selezione di presenza, ritardo o assenza
  $("td.presence.late, td.presence.present, td.presence.missing").click( function () { update_presences ($(this)); });

  // Imposta le spunte ed i totali
  set_presence_initial ();
});

// Assegna l'icona di spunta a seconda
// se ritardo, presenza o assenza
function presence_icon (btn) {
  if (btn.attr("class").match("missing")) {
    return "bi bi-x-square text-danger";
  } else if (btn.attr("class").match("present")) {
    return "bi bi-check-square text-success";
  } else {
    return "bi bi-r-square text-warning";
  }
}

// Al click, resetta la cella spuntata
// ed eventualmente mette la spunta
function set_presence_check (btn) {

  status_off = btn.attr("class").match("btn-off");

  row = btn.parent();
  present_cell = row.find(".presence.present").first();
  late_cell = row.find(".presence.late").first();
  missing_cell = row.find(".presence.missing").first();

  icon_off = "bi-record-circle";
  icon_on = presence_icon (btn);
  icon_present_on = presence_icon (present_cell);
  icon_late_on = presence_icon (late_cell);
  icon_missing_on = presence_icon (missing_cell);

  present_cell.removeClass("btn-on").addClass("btn-off");
  late_cell.removeClass("btn-on").addClass("btn-off");
  missing_cell.removeClass("btn-on").addClass("btn-off");

  present_cell.find("i").removeClass(icon_present_on).addClass(icon_off);
  late_cell.find("i").removeClass(icon_late_on).addClass(icon_off);
  missing_cell.find("i").removeClass(icon_missing_on).addClass(icon_off);

  if (status_off) {
    btn.removeClass("btn-off").addClass("btn-on");
    btn.find("i").removeClass(icon_off).addClass(icon_on);
  }
}

// A view caricata imposta le spunte come da db
function set_presence_initial () {

  // Celle coi totali
  cell_presents = $("#list_presences tfoot th.presence.present");
  cell_lates = $("#list_presences tfoot th.presence.late");
  cell_missings = $("#list_presences tfoot th.presence.missing");

  raw_present_ids = $("#presences_present_ids").val();
  raw_late_ids = $("#presences_late_ids").val();
  raw_missing_ids = $("#presences_missing_ids").val();

  present_ids = raw_present_ids == "" ? "" : raw_present_ids.split(',').map(id => parseInt(id));
  late_ids = raw_late_ids == "" ? "" : raw_late_ids.split(',').map(id => parseInt(id));
  missing_ids = raw_missing_ids == "" ? "" : raw_missing_ids.split(',').map(id => parseInt(id));

  if (present_ids.length > 0) {

    $.each(present_ids, function(index, id) {
      cell = $("#list_presences tbody tr[data-actor-id='" + id + "'] td.presence.present");
      set_presence_check (cell);
    });
  }

  if (late_ids.length > 0) {

    $.each(late_ids, function(index, id) {
      cell = $("#list_presences tbody tr[data-actor-id='" + id + "'] td.presence.late");
      set_presence_check (cell);
    });
  }

  if (missing_ids.length > 0) {

    $.each(missing_ids, function(index, id) {
      cell = $("#list_presences tbody tr[data-actor-id='" + id + "'] td.presence.missing");
      set_presence_check (cell);
    });
  }

  set_presence_totals ();
}

// Aggiorna le celle coi totali
function set_presence_totals () {

  // Celle coi totali
  cell_presents = $("#list_presences tfoot th.presence.present");
  cell_lates = $("#list_presences tfoot th.presence.late");
  cell_missings = $("#list_presences tfoot th.presence.missing");

  raw_present_ids = $("#presences_present_ids").val();
  raw_late_ids = $("#presences_late_ids").val();
  raw_missing_ids = $("#presences_missing_ids").val();

  present_ids = raw_present_ids == "" ? "" : raw_present_ids.split(',').map(id => parseInt(id));
  late_ids = raw_late_ids == "" ? "" : raw_late_ids.split(',').map(id => parseInt(id));
  missing_ids = raw_missing_ids == "" ? "" : raw_missing_ids.split(',').map(id => parseInt(id));

  cell_presents.html(present_ids.length);
  cell_lates.html(late_ids.length);
  cell_missings.html(missing_ids.length);
}

// Aggiorna gli input hidden present/late/missing_ids
function set_presence_values () {
  presents = $("#list_presences tbody td.presence.present");
  lates = $("#list_presences tbody td.presence.late");
  missings = $("#list_presences tbody td.presence.missing");

  present_ids = Array();
  late_ids = Array();
  missing_ids = Array();
  
  presents.each( function () {
    cell = $(this);

    if (cell.attr("class").match("btn-on")) {
      present_ids.push(parseInt(cell.parent().data("actor-id")));
    }
  });
  $("#presences_present_ids").val(present_ids);

  lates.each( function () {
    cell = $(this);

    if (cell.attr("class").match("btn-on")) {
      late_ids.push(parseInt(cell.parent().data("actor-id")));
    }
  });
  $("#presences_late_ids").val(late_ids);

  missings.each( function () {
    cell = $(this);

    if (cell.attr("class").match("btn-on")) {
      missing_ids.push(parseInt(cell.parent().data("actor-id")));
    }
  });
  $("#presences_missing_ids").val(missing_ids);
}

// Aggiorna il db con l'ultimo click
function update_presences (btn) {

  raw_present_ids = $("#presences_present_ids").val();
  raw_late_ids = $("#presences_late_ids").val();
  raw_missing_ids = $("#presences_missing_ids").val();

  present_ids = raw_present_ids == "" ? "" : "[" + raw_present_ids.split(',').map(id => parseInt(id)) + "]";
  late_ids = raw_late_ids == "" ? "" : "[" + raw_late_ids.split(',').map(id => parseInt(id)) + "]";
  missing_ids = raw_missing_ids == "" ? "" : "[" + raw_missing_ids.split(',').map(id => parseInt(id)) + "]";

  params = {
    action: "update_presences",
    model: model,
    id: $("#presences_id").val(),
    present_ids: present_ids,
    late_ids: late_ids,
    missing_ids: missing_ids
  };

  update_backend ("logic.php", {
    parameters: $.param(params),
    method: "POST",
    asynchronous: true,
    evalScripts: true,
    onLoading: function() { console.log("update_" + model + " loading"); },
    onComplete: function(response) {console.log("update_" + model + " complete");
      set_presence_check (btn);
      set_presence_values ();
      set_presence_totals ();
    }
  });
}