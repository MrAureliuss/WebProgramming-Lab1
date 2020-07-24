function checkYData() {
    let y = document.getElementById("y").value.replace(",", ".")

    if (parseInt(y)) {
        if (y > -3 && y < 3) {
            document.getElementById("y").setAttribute("style", "border: 2px solid green;")
            console.log("q")
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
        if (r > -1 && r < 4) {
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