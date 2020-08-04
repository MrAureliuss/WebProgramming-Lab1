function checkYData() {
    let y = document.getElementById("y").value.replace(",", ".")

    if (y === "-" || y === "0") {
        return;
    }
    if (parseInt(y)) {
        if (y >= -3 && y <= 3) {
            document.getElementById("y").setAttribute("style", "border: 2px solid green;")
        } else {
            document.getElementById("y").setAttribute("style", "border: 2px solid red;")
            document.getElementById("y").value = "";
        }
    } else {
        document.getElementById("y").setAttribute("style", "border: 2px solid red;")
        document.getElementById("y").value = "";
    }
}

function checkRData() {
    let r = document.getElementById("r").value.replace(",", ".")

    if (parseInt(r)) {
        if (r >= 1 && r <= 4) {
            document.getElementById("r").setAttribute("style", "border: 2px solid green;")
            console.log("q")
        } else {
            document.getElementById("r").setAttribute("style", "border: 2px solid red;")
            document.getElementById("r").value = "";
        }
    } else {
        document.getElementById("r").setAttribute("style", "border: 2px solid red;")
        document.getElementById("r").value = "";
    }
}

function showTable() {
    document.getElementById('infoContent').style.visibility = "hidden";
    document.getElementById('table').style.visibility = "visible";

    document.getElementById("tableButton").onclick = hideTable;
}

function hideTable() {
    document.getElementById('infoContent').style.visibility = "visible";
    document.getElementById('table').style.visibility = "hidden";

    document.getElementById("tableButton").onclick = showTable;
}