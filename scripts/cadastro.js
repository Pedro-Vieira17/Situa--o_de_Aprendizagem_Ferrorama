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

    
    let usuarios = JSON.parse(localStorage.getItem("usuarios"));


    if (usuarios == null) {
        usuarios = [];
    }

    usuarios.push(usuario);

 
    localStorage.setItem("usuarios", JSON.stringify(usuarios));

    window.location.href = "usuarios_cadastrados.html";
}



window.onload = function () {

    let usuarios = JSON.parse(localStorage.getItem("usuarios"));

    if (usuarios != null) {

        let tabela = document.getElementById("tabelaUsuarios");

        for (let i = 0; i < usuarios.length; i++) {

            tabela.innerHTML += `
                <tr>
                    <td>${usuarios[i].nome}</td>
                    <td>${usuarios[i].cpf}</td>
                    <td>${usuarios[i].telefone}</td>
                    <td>${usuarios[i].email}</td>
                </tr>
            `;
        }
    }
}