DOCUMENTAÇÃO DAS VALIDAÇÕES

1. Introdução
Ferrorama — Sistema de Monitoramento e Gerenciamento Ferroviário

Curso: Técnico em Desenvolvimento de Sistemas

Instituição: SENAI

Turma: DS24/M5

Integrantes:
Pedro Vieira
Davi Zilz
Enzo Vegini
Francisco Goulart

Este documento apresenta as validações realizadas no projeto Ferrorama, desenvolvido para o curso Técnico em Desenvolvimento de Sistemas do SENAI.
Foram analisados os requisitos funcionais, regras de negócio, requisitos não funcionais, banco de dados e principais funcionalidades do sistema.

2. Objetivo
Verificar se o sistema está funcionando de acordo com os requisitos definidos e identificar problemas que precisam ser corrigidos antes da entrega.
A validação foi feita por meio da análise do código e dos testes que deverão ser realizados no ambiente local.

3. Requisitos Funcionais
RF01 — Login
O sistema possui login com e-mail e senha, utilizando sessão e verificação de senha.
Resultado: Parcialmente atendido. Precisa de teste prático.
RF02 — Cadastro de usuários
Existe cadastro de usuários com validação de dados e verificação de CPF e e-mail duplicados.
Resultado: Parcialmente atendido, pois o cadastro está limitado ao administrador.

RF03 — Dashboard
O dashboard apresenta informações sobre sensores, trens e alertas.
Resultado: Parcialmente atendido.

RF04 e RF05 — Sensores
O sistema permite cadastrar, editar, excluir, pesquisar e visualizar sensores.
Resultado: Parcialmente atendido. Foram encontrados problemas relacionados ao CSRF.

RF06 — Monitoramento em tempo real
Não foi encontrada atualização automática dos dados.
Resultado: Não atendido atualmente.

RF07 e RF08 — Relatórios
Não foi encontrada uma área de relatórios com filtros por período, falha e trem.
Resultado: Não atendidos.

RF09 — Confirmação de exclusão
Existe confirmação antes da exclusão de sensores e trens.
Resultado: Atendido parcialmente devido a problemas nas requisições de exclusão.

RF10 — Logout
O sistema possui encerramento da sessão.
Resultado: Atendido.

RF11 — PHP
O sistema foi desenvolvido utilizando PHP.
Resultado: Atendido.

RF14 e RF15 — Sensores e banco de dados
Os sensores possuem identificação e o banco possui as tabelas necessárias para usuários, trens, sensores e rotas.

Resultado: Atendido estruturalmente.
RF16 a RF21 — Cadastros, alterações e exclusões
Existem funções para cadastrar, editar e excluir usuários, trens, sensores e rotas, além da associação entre sensores e trens.
Resultado: Parcialmente atendido. Algumas funções ainda precisam de correções e testes.

4. Regras de Negócio
As principais regras foram verificadas da seguinte forma:
Apenas usuários autenticados podem acessar áreas protegidas.
Sensores precisam estar vinculados a um trem.
Sensores e trens possuem confirmação antes da exclusão.
Sensores só podem ser associados a trens existentes.
Trens com sensores associados não devem ser excluídos.
Resultado: A maioria das regras possui implementação, mas existem problemas com os status dos sensores e algumas operações de exclusão.

5. Requisitos Não Funcionais
Segurança
O sistema utiliza:
password_hash();
password_verify();
consultas preparadas;
controle de sessão;
proteção CSRF em algumas operações.
Resultado: Parcialmente atendido.
Interface
O projeto utiliza Bootstrap e CSS compartilhado entre as páginas.
Resultado: Parcialmente atendido. Ainda precisa de testes de usabilidade.
Desempenho e disponibilidade
Não é possível confirmar esses requisitos apenas analisando o código.
Resultado: Pendente de teste.
Atualização em tempo real
Não foi encontrada implementação de atualização automática.
Resultado: Não atendido atualmente.
Padrão de código
A maior parte dos arquivos segue um padrão de nomes, mas foi encontrado logout.PHP, que deveria seguir o padrão logout.php.
Resultado: Parcialmente atendido.
Metodologia
O projeto utiliza Kanban através do GitHub Projects.
Resultado: Atendido.

6. Principais Problemas Encontrados
Durante a análise foram encontrados os seguintes problemas:
Cadastro de sensores pode apresentar problema com o token CSRF.
salvar_trem.php possui marcadores de Markdown dentro do arquivo PHP.
A exclusão de trens utiliza GET no dashboard, enquanto o processamento espera POST e CSRF.
A exclusão de sensores não possui proteção CSRF.
A exclusão de rotas também não possui proteção CSRF.
O cadastro apresentado no login exige administrador.
O status dos sensores não segue de forma consistente a regra Ativo/Alerta.
Não existe atualização realmente em tempo real.
Não foi encontrado o módulo de relatórios previsto nos requisitos.
O arquivo logout.PHP não segue o padrão de nomenclatura definido.

7. Testes que Devem Ser Realizados
Antes da entrega, a equipe deve testar:
login correto e incorreto;
acesso sem autenticação;
cadastro de usuário;
cadastro, edição e exclusão de trens;
cadastro, edição e exclusão de sensores;
associação de sensores aos trens;
cadastro, edição e exclusão de rotas;
filtros de sensores;
visualização do dashboard;
logout;
permissões de administrador;
dados inválidos;
segurança das operações.
Os resultados dos testes devem ser registrados junto com prints ou outras evidências.

8. Evidências
As principais evidências que devem ser registradas são:
tela de login;
dashboard;
cadastro e edição de trem;
cadastro e edição de sensor;
confirmação de exclusão;
usuários cadastrados;
rotas;
logout;
banco de dados;
mensagens de erro ou sucesso.

9. Conclusão
O Ferrorama já possui uma boa parte da estrutura necessária, incluindo login, banco de dados, dashboard e gerenciamento de usuários, trens, sensores e rotas.
Porém, ainda existem alguns pontos que precisam ser corrigidos antes da entrega, principalmente:
segurança CSRF;
exclusões;
monitoramento em tempo real;
relatórios;
status dos sensores;
cadastro de usuários;
testes práticos.
Após essas correções e a realização dos testes, a documentação deverá ser atualizada com os resultados e as evidências.
