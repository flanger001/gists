var Stupid = {
  onReady: function() {
    $(".doit").on("click", Stupid.connector);
  },
  connector: function() {
    var it = $(this).prop("id");
    Stupid[it]();
  },
  doit: function() {
    alert("Did it.");
  },
  dontdoit: function() {
    alert("Didn't do it.");
  }
};
$(document).ready(Stupid.onReady);