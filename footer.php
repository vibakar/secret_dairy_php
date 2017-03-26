<!-- jQuery first, then Tether, then Bootstrap JS. -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.3.7/js/tether.min.js" ></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" ></script>

<script>
    $(".toggle").click(function () {
        $("#signupform").toggle();
        $("#loginform").toggle();

    });

    $("#dairy").bind("input propertychange", function () {
        $.ajax({
            method: "POST",
            url: "updatedb.php",
            data: {content: $("#dairy").val()}
        });
    });
</script>
</body>
</html>
