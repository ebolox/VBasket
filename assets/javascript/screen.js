$(document).ready(function() {
  // Load existing files
  load_files();

  // Handle drag-and-drop upload
  $('.drag-in').on('dragover', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).addClass('dragging');
  });

  $('.drag-in').on('dragleave', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).removeClass('dragging');
  });

  $('.drag-in').on('drop', function(event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).removeClass('dragging');

    var files = event.originalEvent.dataTransfer.files;
    upload_screen_items(files);
  });
});

function upload_screen_items(files) {
  var form_data = new FormData();
  $.each(files, function(i, file) { form_data.append('file', file); });

  $.ajax({
    url: 'logic.php',
    type: 'POST',
    data: form_data,
    processData: false,
    contentType: false,
    parameters: $.param({ action: "update_screen_items" }),
    success: function(response) {
      var res = JSON.parse(response);
      res.status === 'success' ?
        load_screen_items() :
        alert(res.message);
      }
    },
    error: function(xhr, status, error) {
      console.log('Upload error:', error);
    }
  });
}

function load_screen_items() {
  $.ajax({
    url: 'list_files.php',
    type: 'GET',
    success: function(response) {
      var files = JSON.parse(response);
      var output = '';
      $.each(files, function(i, file) {
        if (file.type.startsWith('image/')) {
          output += '<img src="' + file.url + '" alt="' + file.name + '" style="width: 100px; height: auto; margin: 5px;">';
        } else if (file.type.startsWith('video/')) {
          output += '<video controls style="width: 100px; height: auto; margin: 5px;"><source src="' + file.url + '" type="' + file.type + '"></video>';
        }
      });
      $('.drag-out').html(output);
    },
    error: function(xhr, status, error) {
      console.log('Load files error:', error);
    }
  });
}