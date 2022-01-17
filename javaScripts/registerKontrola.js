function kontrolaVstupov(input ,maxPocet, zobrazenie) {
    let kontrola = false;
    if(input.value.length > maxPocet) {
        input.value = input.value.substring(0,maxPocet);
    }
    if(zobrazenie ===  "meno") {
        let specialneCharaktery = /[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
        if(specialneCharaktery.test(input.value)) {
            document.getElementById(zobrazenie).style.visibility = "visible";
            kontrola = true;
        } else {
            document.getElementById(zobrazenie).style.visibility = "hidden";
        }
    } else if(zobrazenie === "heslo") {
        let znakyHesla = /[A-Za-z]/;
        let cislaHesla = /[0-9]/;
        if(input.value.length < 8 || !znakyHesla.test(input.value) || !cislaHesla.test(input.value)) {
            document.getElementById(zobrazenie).style.visibility = "visible";
            kontrola = true;
        } else {
            document.getElementById(zobrazenie).style.visibility = "hidden";
        }
    } else if(zobrazenie === "email") {
        let controlaEmail = /[@]/;
        if(!controlaEmail.test(input.value)) {
            document.getElementById(zobrazenie).style.visibility = "visible";
            kontrola = true;
        } else {
            document.getElementById(zobrazenie).style.visibility = "hidden";
        }
    } else {
        if(document.getElementById('hesloNaKontrolu').value !== input.value) {
            document.getElementById(zobrazenie).style.visibility = "visible";
            kontrola = true;
        } else {
            document.getElementById(zobrazenie).style.visibility = "hidden";
        }
    }
    document.getElementById('submitRegistracie').disabled = kontrola;
}