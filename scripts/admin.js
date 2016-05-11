window.onload = function () {
    validate_news_creation = function() {
        var path = document.getElementById("img_path");
        var alt = document.getElementById("img_alt");
        var text = document.getElementById("text");
        var ccode = document.getElementById("country_code");
        var phone = document.getElementById("phone");

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            var codeOK = false;
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                  var resp = JSON.parse(xhttp.responseText);
                  if (phone.value.startsWith("+" + resp[0]['callingCodes'])) {
                      codeOK = true;
                  }
                if(!codeOK) {
                    alert("Neispravan pozivni broj.");
                    window.location  = "./../pages/admin.php?what=create";
                    event.returnValue = false;
                }
              }
          };

            var url = "https://restcountries.eu/rest/v1/alpha?codes=" + ccode.value;
            xhttp.open("GET", url, true);
            xhttp.send();

        if(path.value.length == 0 || alt.value.length == 0 || text.value.length == 0) {
            alert('Nisu uneseni svi potrebni parametri!');
            window.location  = "./../pages/admin.php?what=create";
            event.returnValue = false;
        }

    }
}
