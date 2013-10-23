    $(document).ready(function() {
        $("#current_scan").hide();
 
        $( "#scanform" ).submit(function( event ) {
            $("#current_scan").show();
            for (var i = $("#scanstart").val(); i <= $("#scanend").val(); i++) {
                $.ajax({
                    url: "struct/isup.php",
                    data: "ip=" + i,
                    dataType: "html",
                    success: function(msg) {
                            var nbh = parseInt($( "#scanned" ).text());
                            ++nbh;
                            $( "#scanned" ).text(nbh);
                        if(msg !== ""){
                            $("#hosts").append(msg);
                            var nba = parseInt($( "#added" ).text());
                            ++nba;
                            $( "#added" ).text(nba);
                            
                        }
                    }
                }

            );
                    
            }
            $("#current_scan").delay(15000).hide(200);
            $("#scanned").text(0);
            $("#added").text(0);
            return;
            
        });
    });