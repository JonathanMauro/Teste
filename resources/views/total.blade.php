@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="topo">
            <span>Total de Colaboradores por Unidade</span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new">Incluir Unidade</button>
        </div>

        <div class="divTable">
            <table>
                <thead>
                    <tr>
                        <th class="text-center"> Nome </th>
                        <th class="text-center">Razão Social</th>
                        <th class="text-center">CNPJ</th>
                        <th class="text-center">Total de Colaboradores</th>
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
                        <h5 class="modal-title">Adicionar Unidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            <label for="nome_fantasia">Nome Fantasia</label>
                            <input type="text" id="nome_fantasia" required>
                            <label for="razao_social">Razão Social</label>
                            <input type="text" id="razao_social">
                            <label for="cnpj">CNPJ</label>
                            <input type="number" id="cnpj">
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

    <script>
        let currentPage = 1;
        let totalPages = 0;
        let quantidade = 0;
     

        function fetchPage(page) {
            fetch(`api/unidade?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('.divTable tbody');
                    tableBody.innerHTML = '';
                    currentPage = page;
                    totalPages = data.last_page;

                    // Atualiza o número da página atual
                    updatePagination();

                    // Itera sobre os dados recebidos e cria linhas na tabela para cada colaborador
                   data.data.forEach(unidade => {
                       

                       if (unidade.colaboradores.length > 0){
                        quantidade = unidade.colaboradores.length;
                       } else {
                        quantidade = 0;
                       }
                        // Cria uma nova linha da tabela
                        const row = document.createElement('tr');

                        // Define os valores para cada coluna da tabela
                        row.innerHTML = `
                        <td class="text-center">${unidade.nome_fantasia}</td>
                        <td class="text-center">${unidade.razao_social}</td>
                        <td class="text-center">${unidade.cnpj}</td>
                        <td class="text-center">${quantidade}</td>
                 
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
    const nome_fantasia = document.getElementById('nome_fantasia').value;
    const razao_social = document.getElementById('razao_social').value;
    const cnpj = document.getElementById('cnpj').value;
    

    // Constrói o objeto de dados a ser enviado para o backend
    const data = {
        nome_fantasia: nome_fantasia,
        razao_social: razao_social,
        cnpj: cnpj,
    
    };

    // Envia os dados para o backend usando uma solicitação HTTP POST
    fetch('api/unidade', {
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
@endsection
