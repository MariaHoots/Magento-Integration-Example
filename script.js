$(document).ready(function() {

  // IMAGE PROCESSING

  // set variables for image upload
  var encodedImage = "";
  var fileName = "";
  var mimeType = "";
  var validFile = true;

  // encode file to base64 and fill variables for ajax request
  function readFile() {
    if (this.files && this.files[0]) {
      var FR = new FileReader();
      var filesize = this.files[0].size;

      FR.addEventListener("load", function(e) {

        //check filetype first
        var ext = $('#image').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
          alert('Please upload only .gif, .png, .jpg or .jpeg file type');
          $('#image').val('');
          $('#imgPrevContainer').hide();
          validFile = false;
        }

        //file types match, now check size
        var image = new Image();
        image.src = e.target.result;
        image.onload = function () {
          var height = this.height;
          var width = this.width;
          if (height > 1200 || width > 1200) {
            alert("Please upload an image that is smaller than 1200px in height or width.");
            $('#image').val('');
            $('#imgPrevContainer').hide();
            validFile = false;
          }
        };

        if (filesize > 2000000){
          alert("Please upload only images smaller than 2MB");
          $('#image').val('');
          $('#imgPrevContainer').hide();
          validFile = false;
        }

        if (validFile) {
          //everythings is ok, prepare the image and show the preview
          $("#imgPreview").attr("src",e.target.result);
          $('#imgPrevContainer').show();
          //base64 encoding without the first part
          encodedImage = e.target.result.substr(e.target.result.indexOf(',') + 1);
          //filename to be transmitted to Magento
          fileName = $('#image').val().split('\\').pop();
          //no jQuery plugins so we use js
          mimeType = document.getElementById('image').files[0].type;
        }
      });
      FR.readAsDataURL(this.files[0]);
    }
  }
  document.getElementById("image").addEventListener("change", readFile);

  // additional function to the reset button
  $("#resetForm").click(function(){
    $('#imgPrevContainer').hide();
  });

  // Variable to hold  ajax request
  var request;

  // ADD PRODUCT
  $("#addProducts").submit(function(event){
      event.preventDefault();
      if (request) {
        request.abort();
      }

      var $form = $(this);
      var $inputs = $form.find("input, select, button, textarea");
      var serializedData = $form.serialize() + "&image=" + encodeURIComponent(encodedImage) + "&imageName=" + fileName + "&imageMIME=" + mimeType;

      // disable the inputs and indicate loading for the duration of the Ajax request
      $inputs.prop("disabled", true);
      $("#loadingCircle").show();

      // Fire off the request
      request = $.ajax({
        url: "/handler.php",
        type: "post",
        processData:false,
        data: serializedData
      });

      // request succeeded
      request.done(function (response, textStatus, jqXHR){
        $("#alertDiv").empty();
        $("#alertDiv").append(response);
      });
      // request failed
      request.fail(function (jqXHR, textStatus, errorThrown){
        $("#alertDiv").empty();
        $("#alertDiv").append('<div class="alert alert-danger" role="alert">Ajax request failed: '+textStatus, errorThrown+'</div>');
      });
      // request finished
      request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
        $("#loadingCircle").hide();
      });

  }); //ADD PRODUCT END
});
