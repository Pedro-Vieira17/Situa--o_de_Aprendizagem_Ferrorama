const parametros = new URLSearchParams(window.location.search);
const id = parametros.get("id");


const dados = {


    "001": {
        localizacao: "Estação Central - Eixo A",
        velocidade: "70 KM/H",
        temperatura: "36ºC",
        status: "Ativo",


    },


    "002": {
        localizacao: "Ponte de ferro do Rio Paraty",
        velocidade: "44 KM/H",
        temperatura: "40ºC",
        status: "Ativo"
    },


    "003": {
        localizacao: "Patio Sul",
        velocidade: "0 KM/H",
        temperatura: "85ºC",
        status: "Alerta"
    },


    "004": {
        localizacao: "Linha Oeste - Km 12",
        velocidade: "63 KM/H",
        temperatura: "34ºC",
        status: "Ativo"
    },


    "005": {
        localizacao: "Estação Leste - Plataforma 2",
        velocidade: "51 KM/H",
        temperatura: "39ºC",
        status: "Ativo"
    },


    "006": {
        localizacao: "Trecho Sul - Km 78",
        velocidade: "48 KM/H",
        temperatura: "33ºC",
        status: "Ativo"
    },


    "007": {
        localizacao: "Patio Norte",
        velocidade: "22 KM/H",
        temperatura: "31ºC",
        status: "Ativo"
    },


    "008": {
        localizacao: "Estação Jardim Azul",
        velocidade: "75 KM/H",
        temperatura: "37ºC",
        status: "Ativo"
    },


    "009": {
        localizacao: "Trecho Central - Km 101",
        velocidade: "66 KM/H",
        temperatura: "35ºC",
        status: "Ativo"
    },


    "010": {
        localizacao: "Estação Rio Verde",
        velocidade: "57 KM/H",
        temperatura: "38ºC",
        status: "Ativo"
    },


    "011": {
        localizacao: "Trecho Industrial - Km 56",
        velocidade: "61 KM/H",
        temperatura: "36ºC",
        status: "Ativo"
    },


    "012": {
        localizacao: "Patio Ferroviário Oeste",
        velocidade: "43 KM/H",
        temperatura: "32ºC",
        status: "Ativo"
    },


    "013": {
        localizacao: "Estação Bela Vista",
        velocidade: "71 KM/H",
        temperatura: "34ºC",
        status: "Ativo"
    },


    "014": {
        localizacao: "Trecho Norte - Km 89",
        velocidade: "0 KM/H",
        temperatura: "79ºC",
        status: "Alerta"
    },


    "015": {
        localizacao: "Estação Vale do Sol",
        velocidade: "12 KM/H",
        temperatura: "91ºC",
        status: "Alerta"
    },


    "016": {
        localizacao: "Patio Técnico Leste",
        velocidade: "0 KM/H",
        temperatura: "88ºC",
        status: "Alerta"
    },


    "017": {
        localizacao: "Trecho Sul - Km 132",
        velocidade: "28 KM/H",
        temperatura: "82ºC",
        status: "Alerta"
    }


};


const trem = dados[id];


document.getElementById("titulo-monitoramento").innerText =
    "Monitoramento em tempo real - Trem #" + id + " 👀";


document.getElementById("id-trem").innerText = "#" + id;
document.getElementById("velocidade").innerText = trem.velocidade;
document.getElementById("localizacao").innerText = trem.localizacao;
document.getElementById("status").innerText = trem.status;
document.getElementById("temperatura").innerText = trem.temperatura;
