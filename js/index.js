function logout() {
    $.ajax({
        type: "POST",
        url: "handlers/logout_backend.php",
        data: {},
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjesno) {
                window.location.reload();
            }
        }
    });
}
// korisnicki uvjeti 
var provjeraCookiea = Cookies.get("uvjeti");
if (provjeraCookiea) {
    $('#uvjeti').hide();
    console.log("da", provjeraCookiea);
} else {
    console.log("ne", provjeraCookiea);
}

function prihvacam() {
    Cookies.set("uvjeti", true);
    $('#uvjeti').hide();
}