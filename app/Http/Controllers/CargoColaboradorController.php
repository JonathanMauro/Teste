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
      $consulta = $this->cargocolaborador->get();

      return response()->json($consulta);

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

    // Verificar se já existe um registro com os mesmos valores de cargo_id e colaborador_id
    $existingCargoColaborador = CargoColaborador::where('cargo_id', $request->cargo_id)
                                                ->where('colaborador_id', $request->colaborador_id)
                                                ->first();

    if ($existingCargoColaborador) {
        // Se o registro já existe, você pode optar por retornar uma resposta de erro
        return response()->json(['message' => 'Este registro já existe.'], 400);
    }

    // Se o registro não existir, crie um novo
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
        
            $colaborador = CargoColaborador::findOrFail($id);
            return response()->json($colaborador);
        
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
       // Encontre o recurso com base no ID fornecido
       $cargoColaborador = CargoColaborador::find($id);

       // Verifique se o recurso foi encontrado
       if (!$cargoColaborador) {
           // Se o recurso não for encontrado, retorne uma resposta 404 (Recurso não encontrado)
           return response()->json(['message' => 'Recurso não encontrado'], 404);
       }

       // Atualize os atributos do recurso com base nos dados fornecidos na requisição
       $cargoColaborador->update($request->only(['cargo_id', 'colaborador_id', 'nota_desempenho']));

       // Retorne uma resposta 200 (OK) para indicar que a atualização foi bem-sucedida
       return response()->json(['message' => 'Recurso atualizado com sucesso'], 200);
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
