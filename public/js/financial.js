$(function () {
    $('#value').maskMoney({
        prefix: 'R$ ',
        allowNegative: true,
        thousands: '.', decimal: ',',
        affixesStay: true});
});

function showDetails(release) {
    release = JSON.parse(release);
    let html = `
        <h6>Descrição:</h6>
        <p>${release.description}</p>
        <h6>Valor:</h6>
        <p>R$ ${release.value}</p>
        <h6>Detalhes:</h6>
        <p>${release.details == null ? "Nenhum detalhe do lançamento." : release.details}</p>
        <h6>Data:</h6>
        <p>${dateBr(release.date)}</p>
        <h6>Tipo:</h6>
        <p>${release.type == "DESPESA" ? "Saída" : "Entrada"}</p>
        <h6>Pagamento:</h6>
        <p>${release.payment == "DÉBITO" ? "À vista" : "À prazo"}</p>
        <h6>Categoria:</h6>
        <p>${release.category.name}</p>
        `;
    $('#show .modal-body').html(html);
    $('#show').modal('show');
}

function dateBr(date) {
    const newDate = new Date(date);
    return newDate.toLocaleDateString("pt-BR", {
        timeZone: "UTC"
    });
}

function showHiddenPassword() {
    var password = document.getElementById("password");
    if (password.type == "password") {
        password.type = "text";
    } else {
        password.type = "password";
    }
}

function showHiddenPasswords() {
    var cpassword = document.getElementById("cpassword");
    var ccpassword = document.getElementById("ccpassword");

    if (cpassword.type == "password" && ccpassword.type == "password") {
        cpassword.type = "text";
        ccpassword.type = "text";
    } else {
        cpassword.type = "password";
        ccpassword.type = "password";
    }
}


