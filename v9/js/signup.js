const statutSelect = document.getElementById("statut-select");
const poidstailleInput = document.getElementById("height-weight-row");
const dateInput = document.getElementById("birthdate-div");

statutSelect.addEventListener("change", function() {
  if (this.value === "athlete") {
    poidstailleInput.style.display = "block";
    dateInput.style.display = "block";
  } else {
    poidstailleInput.style.display = "none";
    dateInput.style.display = "none";
  }
});

const submitBtn = document.getElementById('submit-btn');

submitBtn.addEventListener('click', function() {
  submitBtn.classList.add('button-clicked');
});