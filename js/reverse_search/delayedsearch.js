var ReverseSearch = {
  onReady: function(){
    $("#rsearch input").on("keyup change", ReverseSearch.wait);
  },
  wait: function(e){
    clearTimeout($.data(this, 'timer'));
    if (e.keyCode == 13){
      ReverseSearch.rsearch(true);
    } else {
      $(this).data('timer', setTimeout(ReverseSearch.rsearch, 500));
    }
  },
  rsearch: function(){
    var raddress = $("#rsearch input[name='address']").val(),
      rstate = $("#rsearch input[name='state']").val();
    $.post("ajaxScripts/if-address-reverse-search-ajax.php", { address: raddress, state: rstate })
    .done(function(data){
      var results = $("<div/>", {
        html: data
      });
      $("#rsearch-results").html(results);
    });
  }
};
$(document).ready(ReverseSearch.onReady);