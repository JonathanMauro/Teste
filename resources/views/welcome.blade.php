<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Controle</title>
    <link rel="shortcut icon" href="{{ asset('img/controlo-remoto.png') }}" type="image/x-icon">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- BOOTSTRAP --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- JS --}}
    <script src="{{ asset('js/scripts.js') }}" defer></script>
    {{-- BOXICONS --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token"> 
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Controle</a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/">Relatório</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/total">Total</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/ranking">Ranking</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div class="topo">
            <span>Cadastro de Funcionários</span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new">Incluir Funcionário</button>
        </div>

        <div class="divTable">
            <table>
                <thead>
                    <tr>
                        <th class="text-center">Nome</th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Unidade</th>
                        <th class="text-center">Cargo</th>
                      
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

            <div class="pagination row">
                <div class="col-10">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item" onclick="previousPage()" id="previousPageBtn"><a class="page-link"
                                    href="#">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item" onclick="nextPage()" id="nextPageBtn"><a class="page-link"
                                    href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="modal fade" id="new" tabindex="-1" aria-labelledby="new" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Funcionário</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" required>
                            <label for="cpf">CPF</label>
                            <input type="number" id="cpf">
                            <label for="email">E-mail</label>
                            <input type="email" id="email">
                            <label for="unidade_id">Unidade ID</label>
                            <input type="number" id="unidade_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSalvar">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
        let currentPage = 1;
        let totalPages = 0;
        const cargos = ['Porteiro(a)', 'Zelador(a)', 'Gerente', 'Promotor(a)', 'Psicologo(a)', 'Recepcionista', 'Segurança',
            'Vendedor(a)', 'Motorista', 'Despachante'
        ];
        let nomeCargo = '';

        function fetchPage(page) {
            fetch(`api/colaborador?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('.divTable tbody');
                    tableBody.innerHTML = '';

                    currentPage = page;
                    totalPages = data.last_page;

                    // Atualiza o número da página atual
                    updatePagination();

                    // Itera sobre os dados recebidos e cria linhas na tabela para cada colaborador
                    data.data.forEach(colaborador => {
                        const row = document.createElement('tr');

                        if (Array.isArray(colaborador.notas_desempenho) && colaborador.notas_desempenho.length >
                            0) {
                            // Se tiver pelo menos um elemento, acessa o cargo_id do primeiro elemento
                           nomeCargo = cargos[colaborador.notas_desempenho[0].cargo_id - 1] 
                        } else {
                            // Se não for um array ou se for um array vazio, exibe uma mensagem de erro ou trata conforme necessário
                            nomeCargo = 'Não possui'
                        }



                        row.innerHTML = `
                            <td class="text-center">${colaborador.nome}</td>
                            <td class="text-center">${colaborador.cpf}</td>
                            <td class="text-center">${colaborador.email}</td>
                            <td class="text-center">${colaborador.unidade_id}</td>
                            <td class="text-center">${nomeCargo}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Erro ao buscar os colaboradores:', error));
        }

        function previousPage() {
            if (currentPage > 1) {
                fetchPage(currentPage - 1);
            } else {
                document.getElementById('previousPageBtn').classList.add('disabled');
            }
        }

        function nextPage() {
            if (currentPage < totalPages) {
                fetchPage(currentPage + 1);
            } else {
                document.getElementById('nextPageBtn').classList.add('disabled');
            }
        }

        function updatePagination() {
            const paginationContainer = document.querySelector('.pagination ul');
            paginationContainer.innerHTML = '';

            // Número de páginas exibidas antes e depois da página atual
            const numPagesDisplayed = 2;

            // Adiciona botão "Previous"
            const previousPageBtn = document.createElement('li');
            previousPageBtn.classList.add('page-item');
            previousPageBtn.innerHTML = `<a class="page-link" href="#" onclick="previousPage()">Previous</a>`;
            paginationContainer.appendChild(previousPageBtn);

            // Adiciona números de página antes da página atual
            for (let i = currentPage - numPagesDisplayed; i < currentPage; i++) {
                if (i > 0) {
                    const pageItem = document.createElement('li');
                    pageItem.classList.add('page-item');
                    pageItem.innerHTML = `<a class="page-link" href="#" onclick="fetchPage(${i})">${i}</a>`;
                    paginationContainer.appendChild(pageItem);
                }
            }

            // Adiciona número da página atual
            const currentPageItem = document.createElement('li');
            currentPageItem.classList.add('page-item', 'active');
            currentPageItem.innerHTML = `<span class="page-link">${currentPage}</span>`;
            paginationContainer.appendChild(currentPageItem);

            // Adiciona números de página após a página atual
            for (let i = currentPage + 1; i <= currentPage + numPagesDisplayed; i++) {
                if (i <= totalPages) {
                    const pageItem = document.createElement('li');
                    pageItem.classList.add('page-item');
                    pageItem.innerHTML = `<a class="page-link" href="#" onclick="fetchPage(${i})">${i}</a>`;
                    paginationContainer.appendChild(pageItem);
                }
            }

            // Adiciona botão "Next"
            const nextPageBtn = document.createElement('li');
            nextPageBtn.classList.add('page-item');
            nextPageBtn.innerHTML = `<a class="page-link" href="#" onclick="nextPage()">Next</a>`;
            paginationContainer.appendChild(nextPageBtn);
        }

        // Carrega a primeira página ao carregar a página
        fetchPage(1);


                  //envio de dados ao backend
document.getElementById('btnSalvar').addEventListener('click', function() {
    // Captura os valores dos campos do formulário
    const nome = document.getElementById('nome').value;
    const unidade_id = document.getElementById('unidade_id').value;
    const email = document.getElementById('email').value;
    const cpf = document.getElementById('cpf').value;
    

    // Constrói o objeto de dados a ser enviado para o backend
    const data = {
        nome: nome,
        unidade_id: unidade_id,
        email: email,
        cpf: cpf
    };

    // Envia os dados para o backend usando uma solicitação HTTP POST
    fetch('api/colaborador', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (response.ok) {
            // Se a solicitação for bem-sucedida, fechar o modal e atualizar lista
            document.getElementById('new').classList.remove('show') // Fechar o modal
            fetchPage(currentPage); // Atualizar a lista de colaboradores
        } else {
            // Se a solicitação não for bem-sucedida, exiba uma mensagem de erro
            console.error('Erro ao enviar os dados do formulário.');
        }
    })
    .catch(error => {
        console.error('Erro ao enviar os dados do formulário:', error);
    });
});
    </script>
</body>

</html>
