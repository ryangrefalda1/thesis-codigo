$(window).scroll(function() {
  $('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
});


$(document).ready(function() {
  $("#sub-header-name").fadeIn(2000);
  $("#logo-img").fadeIn(2000);

});

$(window).scroll(function() {
var containerOffset = $('.container').eq(1).offset().top;
var windowHeight = $(window).height();
var scrollPosition = $(this).scrollTop();

if (scrollPosition >= containerOffset - windowHeight + 100) {
  $('.custom-image, .text-center').fadeIn(1500);
} else {
  $('.custom-image, .text-center').fadeOut(100);
}
});



/* when the button in the form is clicked, display the entered values in the modal */
$('#submitBtn').click(function() {
  $('#Name').text($('#name').val());
  $('#Email').text($('#email').val());
  $('#Message').val($('#message').val()); 
});

// get if the button was clicked
document.getElementById("confirmSubmitComment").addEventListener("click", submitComment);

// create submitComment function
function submitComment(e) {
  e.preventDefault();

  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var message = document.getElementById("message").value;

  // check if the fields are empty
  if (!name || !email || !message) {
      // Show an alert or any other appropriate user feedback for empty fields
      alert("All field Must be Filled!");
      return;
  }


  var data =  'name=' + encodeURIComponent(name) +
              '&email=' + encodeURIComponent(email) +
              '&message=' + encodeURIComponent(message);

  //create xhr object
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "contact_us_controller.php", true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {

          $('#confirmComment').modal('hide');


          if(xhr.responseText.trim() === "Successful"){
              $("#successModal").modal("show");
          } else {
              $("#errorModal").modal("show");
          }
      }
  }

  xhr.send(data);

}
