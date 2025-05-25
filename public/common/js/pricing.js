$(document).ready(function() {
  $(' input[type="checkbox"]').change(function() {
    if ($(`input[type="checkbox"]`).is(":checked")) {
      $(`.monthly-price`).addClass("d-nones");
      $(`.yearly-price`).removeClass("d-nones");
      $(`.monthly-plan`).addClass("d-nones");
      $(`.yearly-plan`).removeClass("d-nones");
    } else {
      $(`.monthly-price`).removeClass("d-nones");
      $(`.yearly-price`).addClass("d-nones");
      $(`.monthly-plan`).removeClass("d-nones");
      $(`.yearly-plan`).addClass("d-nones");
    }
  });
  $(`.card`).mouseenter(function(item) {
    $(`.card`).removeClass("card-selected");
    item.currentTarget.classList.add("card-selected")
  });
})