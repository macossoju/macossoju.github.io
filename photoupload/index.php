<!DOCTYPE html>
<html>
<head>
  <title>Upload your photo</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="model-agency.css">
  <style>
    .submit-body {
      background-color: black;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      padding: 0;
    }
    .message {
      color: white;
      font-size: 24px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container" style="width:700px;">
    <h2 align="center">Show Us Why You Deserve To Join Our Team!</h2>
    <br />
    <label>Select Image</label>
    <input type="file" name="file" id="file" />
    <br />
    <button type="submit" class="btn btn-primary" id="submit-button">Submit</button>
    <span id="uploaded_image"></span>
  </div>
  <div class="message" id="message" style="display: none;">Thank you, our team will get back to you soon!</div>

  <script>
    $(document).ready(function(){
      var fileInput = $('#file');
      var imagePreview = $('#uploaded_image');
      var submitButton = $('#submit-button');
      var messageContainer = $('#message');
      var container = $('.container');

      fileInput.on('change', function() {
        var file = fileInput[0].files[0];
        var reader = new FileReader();

        reader.onload = function(e) {
          var img = new Image();
          img.src = e.target.result;

          img.onload = function() {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');

            var MAX_WIDTH = 400;
            var MAX_HEIGHT = 400;

            var width = img.width;
            var height = img.height;

            if (width > height) {
              if (width > MAX_WIDTH) {
                height *= MAX_WIDTH / width;
                width = MAX_WIDTH;
              }
            } else {
              if (height > MAX_HEIGHT) {
                width *= MAX_HEIGHT / height;
                height = MAX_HEIGHT;
              }
            }

            canvas.width = width;
            canvas.height = height;

            ctx.drawImage(img, 0, 0, width, height);

            var resizedDataUrl = canvas.toDataURL('image/jpeg', 0.8);

            imagePreview.html('<img src="' + resizedDataUrl + '">');
          };
        };

        reader.readAsDataURL(file);
      });

      submitButton.on('click', function(e) {
        e.preventDefault();

        var file = fileInput[0].files[0];
        var form_data = new FormData();

        if (!file) {
          alert('Please select an image');
          return;
        }

        var name = file.name;
        var ext = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(ext, ['gif','png','jpg','jpeg']) === -1) {
          alert('Invalid Image File');
          return;
        }

        var fsize = file.size || file.fileSize;
        if (fsize > 2000000) {
          alert('Image File Size is too large');
          return;
        }

        form_data.append('file', file);

        $.ajax({
          url: 'upload.php',
          method: 'POST',
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            imagePreview.html("<label class='text-success'>Image Uploading...</label>");
          },
          success: function(data) {
            imagePreview.html('');
            container.hide();
            messageContainer.show();
            $('body').addClass('submit-body');
          }
        });
      });
    });
  </script>
</body>
</html>
