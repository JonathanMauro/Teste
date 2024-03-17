<?php

namespace App\Http\Controllers;

use App\Models\Colaborador;
use Illuminate\Http\Request;

class ColaboradorController extends Controller
{
    public function __construct(Colaborador $colaborador)
    {
        $this->colaborador = $colaborador;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consulta = $this->colaborador->with('notasDesempenho')->get();

        return response()->json($consulta);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {/*
   //validação dos dados e criação de nova unidade
     $request->validate($this->colaborador->rules(), $this->colaborador->feedback());

     // Criação do colaborador
     $colaborador = $this->colaborador->create([
         'unidade_id' => $request->unidade_id,
         'nome' => $request->nome, 
         'cpf' => $request->cpf,
         'email' => $request->email,
     ]);
    
     return response()->json($colaborador, 201);
*/

 // Validação dos dados
 $validatedData = $request->validate([
    'unidade_id' => 'required|exists:unidades,id',
    'nome' => 'required',
    'cpf' => 'required|unique:colaboradores',
    'email' => 'required|unique:colaboradores'
]);

// Cria um novo colaborador com os dados validados
$colaborador = Colaborador::create($validatedData);

// Retorna o colaborador criado
return response()->json($colaborador, 201);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
