function promjenaTrajanja() {
    var broj = document.getElementById("promjenaTrajanja").value;
    var data = {
        broj: broj,
        metoda: 'promjenaTrajanja'
    }

    $.ajax({
        type: "POST",
        url: "handlers/postavke_backend.php",
        data: data,
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjesno) {
                alert(odgovor.uspjesno);
                window.location.reload();
            } else if (odgovor.error) {
                alert(odgovor.error);
            }
        }
    });

}
function promjenaPokusaja() {
    var broj = document.getElementById("promjenaPokusaja").value;
    var data = {
        broj: broj,
        metoda: 'promjenaDozvoljenogBrojaLogina'
    }

    $.ajax({
        type: "POST",
        url: "handlers/postavke_backend.php",
        data: data,
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjesno) {
                alert(odgovor.uspjesno);
                window.location.reload();
            } else if (odgovor.error) {
                alert(odgovor.error);
            }
        }
    });
}
function promjenaZakljucano(element) {
    var zakljucano = element.value;
    var id = element.dataset.id;
    var data = {
        zakljucano: zakljucano,
        id: id,
        metoda: 'promjenaZakljucano'
    }

    $.ajax({
        type: "POST",
        url: "handlers/postavke_backend.php",
        data: data,
        dataType: "json",
        success: function (odgovor) {
            if (odgovor.uspjesno) {
                alert(odgovor.uspjesno);
                window.location.reload();
            } else if (odgovor.error) {
                alert(odgovor.error);
            }
        }
    });
}
