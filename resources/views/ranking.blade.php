@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="topo">
            <span>Total de Colaboradores por Ranking</span>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#new">Incluir Cargo Colaborador</button>
        </div>

        <div class="divTable">
            <table>
                <thead>
                    <tr>
                        <th class="text-center"> Nome </th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">Unidade</th>
                        <th class="text-center">Cargo</th>
                        <th class="text-center">Nota de Desempenho</th>
                        <th class="text-center">Atualizar</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
        </div>
        <div class="modal fade" id="new" tabindex="-1" aria-labelledby="new" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Avaliação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            @csrf
                            <label for="cargo">Cargo ID</label>
                            <input type="text" id="cargo_id" required>
                            <label for="colaborador_id">Colaborador ID</label>
                            <input type="number" id="colaborador_id">
                            <label for="nota_desempenho">Nota Desempenho</label>
                            <input type="number" id="nota_desempenho">
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btnSalvar" onclick="fecharModal()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarLabel">Editar Dados</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <label for="modalCargoID">Cargo ID</label>
                            <input type="text" id="modalCargoID" class="form-control">
                            <label for="modalColaboradorID">Colaborador ID</label>
                            <input type="text" id="modalColaboradorID" class="form-control">
                            <label for="modalNotaDesempenho">Nota Desempenho</label>
                            <input type="text" id="modalNotaDesempenho" class="form-control">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary" id="btnSalvarEdicao">Salvar Mudanças</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentPage = 1;
        let totalPages = 0;
        const cargos = ['Porteiro(a)', 'Zelador(a)', 'Gerente', 'Promotor(a)', 'Psicologo(a)', 'Recepcionista', 'Segurança',
            'Vendedor(a)', 'Motorista', 'Despachante'
        ];
        let nomeCargo = '';
    


        function fetchPage(page) {
    fetch(`api/ranking?page=${page}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector('.divTable tbody');
            tableBody.innerHTML = '';
           

            
            // Transforma o objeto em uma matriz de objetos
            const dataArray = Object.values(data);

            // Ordena a matriz com base na soma das notas de desempenho
            const dataOrdenada = dataArray.sort((a, b) => b.somaNotasDesempenho - a.somaNotasDesempenho);

            dataOrdenada.forEach(ranking => {

                if (Array.isArray(ranking.notas_desempenho) && ranking.notas_desempenho.length >
                            0) {
                            // Se tiver pelo menos um elemento, acessa o cargo_id do primeiro elemento
                           nomeCargo = cargos[ranking.notas_desempenho[0].cargo_id - 1] 
                        } else {
                            // Se não for um array ou se for um array vazio, exibe uma mensagem de erro ou trata conforme necessário
                            nomeCargo = 'Não possui'
                        }
                
                // Cria uma nova linha da tabela
                const row = document.createElement('tr');

                // Define os valores para cada coluna da tabela
                row.innerHTML = `
                    <td class="text-center">${ranking.nome}</td>
                    <td class="text-center">${ranking.cpf}</td>
                    <td class="text-center">${ranking.email}</td>
                    <td class="text-center">${ranking.unidade_id}</td>
                    <td class="text-center">${nomeCargo}</td>
                    <td class="text-center">${ranking.somaNotasDesempenho}</td>
                    <td class="text-center blue-color"><a href="#" class="edit-icon" data-bs-toggle="modal" data-bs-target="#modalEditar"><i class='bx bx-edit'></i></a></td>
                `;
                tableBody.appendChild(row);
            });
        })
}




        
        // Carrega a primeira página ao carregar a página
        fetchPage(1);


   //envio de dados ao backend
document.getElementById('btnSalvar').addEventListener('click', function() {
    // Captura os valores dos campos do formulário
    const cargo_id = document.getElementById('cargo_id').value;
    const colaborador_id = document.getElementById('colaborador_id').value;
    const nota_desempenho = document.getElementById('nota_desempenho').value;
    

    // Constrói o objeto de dados a ser enviado para o backend
    const data = {
        cargo_id: cargo_id,
        colaborador_id: colaborador_id,
        nota_desempenho: nota_desempenho,
    
    };

    // Envia os dados para o backend usando uma solicitação HTTP POST
    fetch('api/cargocolaborador', {
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

function fecharModal() {
    // Captura o modal
    const modal = document.getElementById('new');
    
    // Fecha o modal
    const bootstrapModal = bootstrap.Modal.getInstance(modal);
    bootstrapModal.hide();
    
    // Recarrega a página após fechar o modal
    window.location.reload();
}

// Seleciona todos os ícones de edição
const editIcons = document.querySelectorAll('.edit-icon');

// Adiciona um evento de clique a cada ícone de edição
editIcons.forEach(icon => {
    icon.addEventListener('click', function(event) {
        event.preventDefault(); // Evita o comportamento padrão do link

        // Captura os dados da linha correspondente
        const rowData = this.closest('tr').querySelectorAll('td');

        // Extrai os dados necessários da linha
        const cargo_id = ranking.cargo_id; // 
        const colaborador_id = ranking.unidade_id; 
        const nota_desempenho = ranking.notas_desempenho[0]; 
        abrirModal(cargo_id, colaborador_id, nota_desempenho); 
    });
});

document.getElementById('btnSalvarEdicao').addEventListener('click', function() {
    // Aqui você pode acessar os valores dos campos de entrada e enviar os dados para o backend para atualização
    const cargo_id = document.getElementById('modalCargoID').value;
    const colaborador_id = document.getElementById('modalColaboradorID').value;
    const nota_desempenho = document.getElementById('modalNotaDesempenho').value;

    // Envie os dados para o backend e lide com a atualização
});

function abrirModal(cargo_id, colaborador_id, nota_desempenho) {
    // Abre o modal de edição
    const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
    modal.show();
  
    // Preenche os campos do modal com os dados capturados
    document.getElementById('modalCargoID').value = cargo_id;
    document.getElementById('modalColaboradorID').value = colaborador_id;
    document.getElementById('modalNotaDesempenho').value = nota_desempenho;
}
    </script>
@endsection
