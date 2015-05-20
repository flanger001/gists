// But you can make an object and use that instead

var Snapshot = {
  onReady: function(){
    $(".ps-delete").on("click", Snapshot.deleteLead);
    $("#ps-address").on("keyup", Snapshot.searchLead);
  },
  deleteLead: function(){
    var id = $(this).prop("id").replace("delete", "");
    if (confirm("This will delete this property. Are you sure?")) {
      $.post("ajaxScripts/property-list-functions.php", {step: "delete", user: "<?php echo $_SESSION['ifre_user_id'] ?>", IncludedRecords: id })
      .done(function(data){
        alert("Property ID #" + id + " deleted!");
        $("#property" + id).fadeOut(1000);
      });
    } else {
      return false;
    }
  },
  searchLead: function(){
    var searchvalue = $("#ps-address").val().toLowerCase();
    $(".ps-property").each(function(){
      var text = $(this).text().toLowerCase();
      (text.indexOf(searchvalue) !== -1) ? $(this).show() : $(this).hide();
    });
  }
};
$(document).ready(Snapshot.onReady);