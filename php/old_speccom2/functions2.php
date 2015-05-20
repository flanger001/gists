<?php
/* ------------------------ */
//
// Suggestion box  JavaScript AJAX functions
// This page is only used by suggestion-box[][user][admin].php
//
/* ------------------------ */
?>

<script type="text/javascript">
var userid = '<?php echo $_SESSION["ifre_user_id"]; ?>',
    username = "<?php echo $_SESSION['ifre_user_name']; ?>",
    pname = username.split(" "),
    commentname = pname[0] + " " + pname[1][0],
    email = "<?php echo $_SESSION['ifre_email']; ?>";
var SuggestionBox = {
    originalClose: function(){
        $.colorbox.close();
    },
    onReady: function(){
        $(".upvote").on("click", SuggestionBox.upVote);
        $(".downvote").on("click", SuggestionBox.downVote);
        $(".undecidedvote").on("click", SuggestionBox.undecidedVote);
        $(".suggestiontitle").on("click", SuggestionBox.toggleSuggestion);
        $(".commentsdisplay").on("click", SuggestionBox.toggleComment);
        $("input[class='suggestionadmin'][type='submit']").on("click", SuggestionBox.suggestionAdmin);
        $("input[class='suggestiontitleadmin'][type='submit']").on("click", SuggestionBox.suggestionTitleAdmin);
        $("select[class='suggestionallow']").on("change", SuggestionBox.suggestionStatusChange);
        $("select[class='suggestionstatus']").on("change", SuggestionBox.statusChange);
        $("input[class='usercommentadmin'][type='submit']").on("click", SuggestionBox.commentAdmin);
        $("select[class='commentstatus']").on("change", SuggestionBox.commentStatusChange);
        $("#showdevelopment").on("click", SuggestionBox.showDevelopment);
        $("#showsuggestions").on("click", SuggestionBox.showSuggestions);
    },
    upVote: function(){
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("upvote-","");
        var upvotecount = ($(this).find(".upcount").text()).trim();
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "upvote",
                userid: userid,
                id: suggestionid
            },
            success: function(data){
                if (data == "already") {
                    var result = $("#" + suggestionid);
                    result.find("td[class='votecontainer']").html("<span class='alreadyvote'>You already voted!<span>");
                } else {
                    $.colorbox({
                        iframe: true,
                        href: "suggestion-box-comment.php?suggid=" + suggestionid + "&kind=up",
                        height: "16%",
                        width: "55%",
                        fixed: true,
                        closeButton: false,
                        opacity: 0,
                        top: "50px"
                    });
                }
            }
        });
    },
    downVote: function(){
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("downvote-","");
        var downvotecount = ($(this).find(".downcount").text()).trim();
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "downvote",
                userid: userid,
                id: suggestionid
            },
            success: function(data){
                if (data == "already") {
                    var result = $("#" + suggestionid);
                    result.find("td[class='votecontainer']").html("<span class='alreadyvote'>You already voted!<span>");
                } else {
                    $.colorbox({
                        iframe: true,
                        href: "suggestion-box-comment.php?suggid=" + suggestionid + "&kind=dn",
                        height: "16%",
                        width: "55%",
                        fixed: true,
                        closeButton: false,
                        opacity: 0,
                        top: "50px"
                    });
                }
            }
        });
    },
    undecidedVote: function(){
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("undecidedvote-","");
        var undecidedvotecount = ($(this).find(".undecidedcount").text()).trim();
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "undecidedvote",
                userid: userid,
                id: suggestionid
            },
            success: function(data){
                if (data == "already") {
                    var result = $("#" + suggestionid);
                    result.find("td[class='votecontainer']").html("<span class='alreadyvote'>You already voted!<span>");
                } else {
                    $.colorbox({
                        iframe: true,
                        href: "suggestion-box-comment.php?suggid=" + suggestionid + "&kind=ud",
                        height: "16%",
                        width: "55%",
                        fixed: true,
                        closeButton: false,
                        opacity: 0,
                        top: "50px"
                    });
                }
            }
        });
    },
    colorbox: {
        closeupv: function(suggestionid){
            console.log(suggestionid);
            $.ajax ({
                url: "functions3.php",
                type: "POST",
                data: {
                    type: "upvote",
                    userid: userid,
                    id: suggestionid
                },
                success: function(data){
                    /* Updates display and disables button */
                    var result = $("#" + suggestionid);
                    result.find("div[class='votebutton btn btn-success']").attr("disabled", true);
                    result.find("p[class='upcount']").html(data);
                    result.find("upvotebutton-" + suggestionid).toggleClass("disabled");
                }
                });
            SuggestionBox.originalClose();
        },
        closednv: function(suggestionid){
            console.log(suggestionid);
            $.ajax ({
                url: "functions3.php",
                type: "POST",
                data: {
                    type: "downvote",
                    userid: userid,
                    id: suggestionid
                },
                success: function(data){
                    /* Updates display and disables button */
                    var result = $("#" + suggestionid);
                    result.find("div[class='votebutton btn btn-danger']").attr("disabled", true);
                    result.find("p[class='downcount']").html(data);
                    result.find("downvotebutton-" + suggestionid).toggleClass("disabled");
                }
                });
            SuggestionBox.originalClose();
        },
        closeund: function(suggestionid){
            console.log(suggestionid);
            $.ajax ({
                url: "functions3.php",
                type: "POST",
                data: {
                    type: "undecidedvote",
                    userid: userid,
                    id: suggestionid
                },
                success: function(data){
                    /* Updates display and disables button */
                    var result = $("#" + suggestionid);
                    result.find("div[class='votebutton btn btn-warning']").attr("disabled", true);
                    result.find("p[class='undecidedcount']").html(data);
                    result.find("undecidedvotebutton-" + suggestionid).toggleClass("disabled");
                }
                });
            SuggestionBox.originalClose();
        },
    },
    toggleSuggestion: function(){
        var e = $(this);
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("suggestiontitle","");
        var dbi = $("#suggestion-box-iframe", parent.document);
        $("#suggestioncondensed" + suggestionid).slideToggle("linear", function(){
            if (e.html() == "More Info") {
                dbi.height(dbi.height() + 50);
                e.html("Less Info");
            } else {
                dbi.height(dbi.height() - 50);
                e.html("More Info");
            }
            $("#suggestionfull" + suggestionid).slideToggle("linear");
        });
    },
    toggleComment: function(){
        var e = $(this);
        var comm = $(this).prop("id");
        var commentid = comm.replace("commentsdisplay","");
        $("#commentscondensed" + commentid).slideToggle("linear", function(){
            if (e.html() == "Show Comments") {
                e.html("Hide Comments");
            } else {
                e.html("Show Comments");
            }
        });
    },
    suggestionAdmin: function(){
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("suggestion-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "updatesuggestion",
                id: suggestionid,
                suggestion: $("textarea[name='suggestionadmin'][id='suggestionadmin-" + suggestionid + "']").val()
            },
            success: function(data){
                alert("Suggestion updated!");
            }
        });
    },
    suggestionTitleAdmin: function(){
        var sugg = $(this).prop("id");
        var suggestiontitleid = sugg.replace("suggestiontitle-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "updatesuggestiontitle",
                id: suggestiontitleid,
                suggestiontitle: $("textarea[name='suggestiontitleadmin'][id='suggestiontitleadmin-" + suggestiontitleid + "']").val()
            },
            success: function(data){
                alert("Suggestion title updated!");
            }
        });
    },
    suggestionStatusChange: function(){
        var sugg = $(this).prop("id");
        var suggestionid = sugg.replace("suggestionallow-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "suggestionallow",
                id: suggestionid,
                status: $("#" + sugg).val()
            },
            success: function(data){
                alert("Suggestion allow changed!");
            }
        });
    },
    statusChange: function(){
        var stat = $(this).prop("id");
        var statusid = stat.replace("status-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "status",
                id: statusid,
                status: $("#" + stat).val()
            },
            success: function(data){
                alert("Suggestion status changed!");
            }
        });
    },
    commentAdmin: function(){
        var comm = $(this).prop("id");
        var commentid = comm.replace("commentsadmin-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "updatecomment",
                id: commentid,
                comment: $("input[name='usercommentadmin'][id='usercommentadmin-" + commentid + "']").val()
            },
            success: function(data){
                alert("Comment updated!");
            }
        });
    },
    commentStatusChange: function(){
        var stat = $(this).prop("id");
        var statusid = stat.replace("commentstatus-","");
        $.ajax ({
            url: "functions1.php",
            type: "POST",
            data: {
                type: "updatecommentstatus",
                id: statusid,
                status: $("#" + stat).val()
            },
            success: function(data){
                alert("Comment status changed!");
            }
        });
    },
    showDevelopment: function(){
        $("#suggestionsdisplay").fadeOut("fast");
        $.post("suggestion-box-development.php")
        .done(function(data){
            $("#developmentdisplay").fadeIn("slow");
            $("#developmentdisplay").html(data);
        });
    },
    showSuggestions: function () {
        $("#developmentdisplay").fadeOut("fast");
        $("#suggestionsdisplay").fadeIn("slow");
    }
};
$(document).ready(SuggestionBox.onReady);
</script>