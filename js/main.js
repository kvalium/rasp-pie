    $(document).ready(function() {
        $('#btn_submit').click(function() {
            for (var i = $("#start").val(); i < $("#end").val(); i++) {
                $.ajax({
                    type: "GET",
                    url: "struct/isup.php",
                    data: "ip=" + i,
                    success: function(msg) {
                        $("#hosts").append(msg);
                    }
                });
            }
        });
    });