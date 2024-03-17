<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CargoColaborador;

class CargoColaboradorController extends Controller
{

    public function __construct(CargoColaborador $cargocolaborador)
    {
        $this->cargocolaborador = $cargocolaborador;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //

    }
/*
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
    {
         // Validação dos dados
    $request->validate($this->cargocolaborador->rules(), $this->cargocolaborador->feedback());

    // Criação do cargo colaborador
    $cargoColaborador = new CargoColaborador();
    $cargoColaborador->cargo_id = $request->cargo_id;
    $cargoColaborador->colaborador_id = $request->colaborador_id;
    $cargoColaborador->nota_desempenho = $request->nota_desempenho;
    $cargoColaborador->save();
    
    return response()->json($cargoColaborador, 201);
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
        // Encontre o modelo com base no ID fornecido
        $cargoColaborador = $this->cargocolaborador->find($id);
    
        if ($cargoColaborador === null) {
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404);
        }
    
        // Valide os dados da solicitação
        $request->validate($this->cargocolaborador->rules(), $this->cargocolaborador->feedback());
    
        $cargoColaborador->fill($request->all());
        $cargoColaborador->save();
        
        return response()->json($cargoColaborador, 200);
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
