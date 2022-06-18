// Get the modal
var modal = document.getElementById("brandModal");
var alertModal = document.getElementById("alertModal");

// Get the button that opens the modal
// var createBrand = document.getElementById("createBrand");

// Get the <span> element that closes the modal
// var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
// createBrand.onclick = function() {
//   modal.style.display = "block";
// }

// When the user clicks on <span> (x), close the modal
// span.onclick = function() {
//   modal.style.display = "none";
// }

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal || event.target == alertModal) {
    modal.style.display = "none";
    alertModal.style.display = "none";
  }
}