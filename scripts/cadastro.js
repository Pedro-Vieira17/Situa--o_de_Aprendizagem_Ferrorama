function cadastrarUsuario() {

    let nome = document.getElementById("nome").value;
    let cpf = document.getElementById("cpf").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;

    let usuario = {
        nome: nome,
        cpf: cpf,
        telefone: telefone,
        email: email
    };

    localStorage.setItem("usuario", JSON.stringify(usuario));

    window.location.href = "usuarios_cadastrados.html";
}

window.onload = function () {

    let usuario = JSON.parse(localStorage.getItem("usuario"));

    let tabela = document.getElementById("tabelaUsuarios");

    if (usuario && tabela) {

        tabela.innerHTML = `
            <tr>
                <td>${usuario.nome}</td>
                <td>${usuario.cpf}</td>
                <td>${usuario.telefone}</td>
                <td>${usuario.email}</td>
            </tr>
        `;
    }
}