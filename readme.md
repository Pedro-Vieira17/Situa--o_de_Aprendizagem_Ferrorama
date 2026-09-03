# 🚂 Ferrorama

> **Situação de Aprendizagem — Técnico em Desenvolvimento de Sistemas**

![Status](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)
![HTML](https://img.shields.io/badge/HTML-5-orange)
![CSS](https://img.shields.io/badge/CSS-3-blue)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow)
![PHP](https://img.shields.io/badge/PHP-8-blueviolet)
![Git](https://img.shields.io/badge/Git-controle%20de%20versão-red)

---

## 📋 Descrição do Projeto

O **Ferrorama** é um projeto desenvolvido como uma **Situação de Aprendizagem** do curso Técnico em Desenvolvimento de Sistemas.

O sistema tem como objetivo apresentar uma solução para o **monitoramento e gerenciamento de trens e sensores**, utilizando uma aplicação web.

Durante o desenvolvimento são utilizados conhecimentos de **HTML, CSS, JavaScript, PHP, banco de dados, Git e GitHub**.

---

## 🎯 Objetivo

O objetivo do projeto é desenvolver um sistema funcional para auxiliar no **controle de trens e sensores**, permitindo visualizar informações, cadastrar dados, gerar relatórios e acompanhar possíveis alertas.

Além disso, o projeto busca colocar em prática conhecimentos de:

* Desenvolvimento web;
* Programação;
* Banco de dados;
* Organização de código;
* Criação de interfaces;
* Git e GitHub;
* Trabalho em equipe;
* Testes e correção de erros;
* Documentação de sistemas.

---

# ⚙️ Funcionalidades

O sistema deverá possuir funcionalidades relacionadas ao gerenciamento de usuários, trens, sensores e relatórios.

| Área               | Funcionalidades                                |
| ------------------ | ---------------------------------------------- |
| 👤 Usuários        | Login, cadastro, visualização e exclusão       |
| 🚂 Trens           | Cadastro, alteração e exclusão                 |
| 📡 Sensores        | Cadastro, edição, exclusão e identificação     |
| 📊 Dashboard       | Visualização de informações gerais             |
| 📄 Relatórios      | Geração, busca e filtragem                     |
| 🔐 Acesso          | Login e logout                                 |
| 🗄️ Banco de dados | Armazenamento e relacionamento das informações |

---

# 📌 Requisitos do Sistema

Os requisitos foram definidos para orientar o desenvolvimento do Ferrorama.

## 📋 Requisitos Funcionais

| Código   | Requisito                                                                                                         |
| -------- | ----------------------------------------------------------------------------------------------------------------- |
| **RF01** | O sistema deve permitir o login de usuários por meio de e-mail e senha.                                           |
| **RF02** | O sistema deve permitir o cadastro de novos usuários.                                                             |
| **RF03** | O sistema deve exibir um dashboard com informações gerais, como sensores ativos, trens em operação e alertas.     |
| **RF04** | O sistema deve permitir o gerenciamento de sensores, incluindo cadastrar, editar e excluir.                       |
| **RF05** | O sistema deve permitir visualizar os sensores com informações de localização, tipo de dado e status.             |
| **RF06** | O sistema deve permitir o monitoramento em tempo real dos trens, mostrando velocidade, temperatura e localização. |
| **RF07** | O sistema deve permitir gerar relatórios por período, tipo de falha e trem.                                       |
| **RF08** | O sistema deve permitir a busca e filtragem de relatórios gerados.                                                |
| **RF09** | O sistema deve solicitar confirmação antes de excluir um sensor.                                                  |
| **RF10** | O sistema deve permitir o logout do usuário.                                                                      |
| **RF11** | O sistema deve ser desenvolvido utilizando PHP.                                                                   |
| **RF12** | O sistema deve atender todos os requisitos definidos para o projeto.                                              |
| **RF13** | O sistema deve utilizar padrões para criação e organização das funções.                                           |
| **RF14** | O sistema deve identificar os sensores cadastrados.                                                               |
| **RF15** | O sistema deve possuir um banco de dados funcional com as tabelas relacionadas.                                   |
| **RF16** | O sistema deve permitir alterar dados cadastrados.                                                                |
| **RF17** | O sistema deve permitir excluir usuários.                                                                         |
| **RF18** | O sistema deve permitir excluir trens cadastrados.                                                                |
| **RF19** | O sistema deve mostrar os usuários cadastrados.                                                                   |
| **RF20** | O sistema deve permitir o cadastro de novos trens.                                                                |
| **RF21** | O sistema deve permitir associar um ou mais sensores a um trem no cadastro ou edição.                             |

---

## 📐 Regras de Negócio

| Código   | Regra                                                                                                      |
| -------- | ---------------------------------------------------------------------------------------------------------- |
| **RN01** | Apenas usuários autenticados podem acessar o sistema.                                                      |
| **RN02** | Um sensor deve estar obrigatoriamente vinculado a um trem no cadastro.                                     |
| **RN03** | A exclusão de sensores deve exigir confirmação.                                                            |
| **RN04** | Sensores devem possuir os status **Ativo** ou **Alerta**.                                                  |
| **RN05** | Relatórios devem utilizar filtros de período, tipo de falha e trem.                                        |
| **RN06** | O sistema deve exibir informações atualizadas dos sensores e trens.                                        |
| **RN07** | Um sensor só pode ser vinculado a um trem que já esteja cadastrado.                                        |
| **RN08** | A exclusão de um trem deve exigir confirmação.                                                             |
| **RN09** | Um trem só poderá ser excluído se não possuir sensores vinculados, ou conforme regra definida pela equipe. |

---

## ⚡ Requisitos Não Funcionais

| Código    | Requisito                                                                                          |
| --------- | -------------------------------------------------------------------------------------------------- |
| **RNF01** | O sistema deve apresentar atualização dos dados em tempo real.                                     |
| **RNF02** | O sistema deve possuir desempenho adequado na exibição das informações.                            |
| **RNF03** | O sistema deve possuir autenticação segura por e-mail e senha.                                     |
| **RNF04** | A interface deve ser intuitiva e fácil de utilizar.                                                |
| **RNF05** | O sistema deve buscar alta disponibilidade.                                                        |
| **RNF06** | As telas devem possuir uma interface consistente, seguindo padrões de cores, layout e usabilidade. |
| **RNF07** | O sistema deve ser testado antes da entrega.                                                       |
| **RNF08** | O sistema deve seguir um padrão de nomenclatura para arquivos e funções.                           |
| **RNF09** | A equipe deve definir, documentar e registrar a metodologia de desenvolvimento utilizada.          |

---

# 🛠️ Tecnologias Utilizadas

| Tecnologia     | Utilização                                                  |
| -------------- | ----------------------------------------------------------- |
| **HTML5**      | Estrutura das páginas                                       |
| **CSS3**       | Estilização e organização visual                            |
| **JavaScript** | Interações e funcionalidades                                |
| **PHP**        | Desenvolvimento do back-end e processamento das informações |
| **MySQL**      | Armazenamento dos dados do sistema                          |
| **Git**        | Controle de versões                                         |
| **GitHub**     | Armazenamento e compartilhamento do projeto                 |

---

# 📁 Estrutura do Projeto

```text
Situa--o_de_Aprendizagem_Ferrorama/
│
├── 📂 assets/
├── 📂 doc/
├── 📂 public/
├── 📂 scripts/
│
├── 📄 index.html
├── 📄 license
└── 📄 readme.md
```

| Pasta/Arquivo | Função                            |
| ------------- | --------------------------------- |
| `assets/`     | Imagens e outros recursos visuais |
| `doc/`        | Documentação do projeto           |
| `public/`     | Arquivos públicos da aplicação    |
| `scripts/`    | Scripts utilizados no sistema     |
| `index.html`  | Página principal                  |
| `license`     | Licença do projeto                |
| `readme.md`   | Documentação principal            |

---

# 🔄 Metodologia de Desenvolvimento

Para organizar o desenvolvimento do projeto, a equipe utilizará a metodologia **Kanban**.

A escolha foi feita porque o projeto possui várias tarefas que precisam ser distribuídas entre os integrantes e acompanhadas durante o desenvolvimento.

### Fluxo do Kanban

```text
📋 A Fazer
     ↓
🔨 Em Desenvolvimento
     ↓
🧪 Em Teste
     ↓
✅ Concluído
```

Cada tarefa deverá possuir:

* Descrição da atividade;
* Requisito relacionado;
* Responsável;
* Status;
* Prioridade, quando necessário.

O Kanban será utilizado no **GitHub Projects** para acompanhar o andamento das atividades.

---

# 🧑‍💻 Padrão de Código

Para evitar diferenças entre os códigos dos integrantes, serão utilizados alguns padrões.

| Item        | Padrão                                          |
| ----------- | ----------------------------------------------- |
| Arquivos    | Nomes em minúsculo                              |
| Variáveis   | Nomes claros e descritivos                      |
| Funções     | Nomes relacionados à função realizada           |
| Indentação  | Código organizado e identado                    |
| Comentários | Utilizados quando ajudarem na compreensão       |
| Pastas      | Cada pasta deve possuir uma finalidade          |
| HTML        | Estrutura organizada e sem código desnecessário |
| CSS         | Classes com nomes claros                        |
| PHP         | Código separado de acordo com suas funções      |

O objetivo é fazer com que todos os integrantes consigam entender e continuar o código desenvolvido pelos outros membros da equipe.

---

# 🧪 Testes

Os testes serão realizados durante o desenvolvimento para verificar se os requisitos estão funcionando corretamente.

| Teste          | O que será verificado                  |
| -------------- | -------------------------------------- |
| Login          | Entrada com usuário e senha            |
| Cadastro       | Criação de usuários, trens e sensores  |
| Alteração      | Alteração dos dados cadastrados        |
| Exclusão       | Exclusão com confirmação               |
| Sensores       | Cadastro, identificação e status       |
| Trens          | Cadastro e associação com sensores     |
| Relatórios     | Geração, busca e filtros               |
| Dashboard      | Exibição das informações               |
| Logout         | Saída segura do sistema                |
| Banco de dados | Gravação e recuperação das informações |

---

# 🔐 Segurança

Durante o desenvolvimento serão utilizadas boas práticas de segurança, como:

* Autenticação de usuários;
* Validação dos dados;
* Proteção das informações do usuário;
* Não deixar senhas expostas no código;
* Controle de acesso às páginas;
* Confirmação antes de exclusões;
* Organização dos arquivos;
* Validação das informações antes de salvar no banco.

---

# 📚 Aprendizados

Com o desenvolvimento do Ferrorama, a equipe poderá praticar conhecimentos de:

* HTML;
* CSS;
* JavaScript;
* PHP;
* Banco de dados;
* Git e GitHub;
* Kanban;
* Requisitos de sistema;
* Regras de negócio;
* Testes;
* Segurança;
* Organização de projetos;
* Trabalho em equipe.

---

# 👥 Equipe

| Integrante            |
| --------------------- |
| **Pedro Vieira**      |
| **Davi Zilz**         |
| **Enzo Vegini**       |
| **Francisco Goulart** |

**Curso:** Técnico em Desenvolvimento de Sistemas
**Instituição:** SENAI
**Turma:** DS24/M4

---

# 🌐 Repositório

O projeto está disponível no GitHub:

[Repositório Ferrorama no GitHub](https://github.com/Pedro-Vieira17/Situa--o_de_Aprendizagem_Ferrorama.git?utm_source=chatgpt.com)

---

# 📌 Status do Projeto

🟡 **Em desenvolvimento**

Nesta primeira etapa, a equipe está realizando a revisão do projeto, organização dos requisitos, definição da metodologia, padronização do código e planejamento das próximas tarefas.

---

## 🚂 Considerações Finais

O **Ferrorama** é um projeto desenvolvido para colocar em prática os conhecimentos do curso Técnico em Desenvolvimento de Sistemas.

Nesta etapa, o foco principal é **revisar, organizar e planejar** o projeto, deixando definidos os requisitos, regras de negócio, padrões de código e tarefas que serão realizadas pela equipe.

Com isso, o desenvolvimento das próximas etapas poderá ser feito de forma mais organizada, dividindo as atividades entre os integrantes e acompanhando tudo pelo Kanban do GitHub Projects.
