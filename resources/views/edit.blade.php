@extends('layouts.app')
@section('content')
    <div class="container">
        <h1>Editar Colaborador</h1>
        <form id="editForm" class="row">
            @csrf
            <div class="form-group">
                <label for="edit_cargo" class="form-label">Cargo ID</label>
                <input type="text" id="edit_cargo_id" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit_colaborador_id" class="form-label">Colaborador ID</label>
                <input type="number" id="edit_colaborador_id" class="form-control" disabled>
            </div>
            <div class="form-group">
                <label for="edit_nota_desempenho" class="form-label">Nota Desempenho</label>
                <input type="number" id="edit_nota_desempenho" class="form-control">
            </div>
            <button type="submit" id="submitForm" class="btn btn-primary">Atualizar</button>
        </form>
    </div>


    <script>
        function carregarDadosColaborador(colaboradorId) {
            if (!colaboradorId) {
                console.error('ID do colaborador não fornecido.');
                return;
            }

            fetch(`/api/cargocolaborador/${colaboradorId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao obter os dados do colaborador');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('edit_cargo_id').value = data.cargo_id;
                    document.getElementById('edit_colaborador_id').value = data.colaborador_id;
                    document.getElementById('edit_nota_desempenho').value = data.nota_desempenho;
                })
                .catch(error => {
                    console.error(error.message);
                });
        }

        const urlParams = new URLSearchParams(window.location.search);
        const colaboradorId = window.location.pathname.split('/').pop();

        carregarDadosColaborador(colaboradorId);

        document.getElementById('editForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const cargo_id = document.getElementById('edit_cargo_id').value;
            const colaborador_id = document.getElementById('edit_colaborador_id').value;
            const nota_desempenho = document.getElementById('edit_nota_desempenho').value;

            const data = {
                cargo_id: cargo_id,
                colaborador_id: colaborador_id,
                nota_desempenho: nota_desempenho,
            };

            fetch(`/api/cargocolaborador/${colaborador_id}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (response.ok) {
                        // Atualizar a página ou realizar outra ação após o sucesso da atualização
                        console.log('Dados do colaborador atualizados com sucesso.');
                    } else {
                        console.error('Erro ao atualizar os dados do colaborador.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao enviar os dados do formulário:', error);
                });
        });
    </script>
@endsection
