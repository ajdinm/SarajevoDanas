window.onload = function () {
    validate_news_creation = function() {
        var path = document.getElementById("img_path");
        var alt = document.getElementById("img_alt");
        var text = document.getElementById("text");

        if(path.value.length == 0 || alt.value.length == 0 || text.value.length == 0) {
            alert('Nisu uneseni svi potrebni parametri!');
            window.location  = "./../pages/admin.php";
        }

    }
}
