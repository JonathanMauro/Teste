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
        $ranking = $this->cargocolaborador->find($id);
    
        // Se o modelo não for encontrado, retorne uma resposta de erro
        if (!$ranking) {
            return response()->json(['error' => 'Model not found'], 404);
        }
    
        // Atualize os campos com base nos dados recebidos do formulário, se estiverem presentes no request
        if ($request->has('cargo_id')) {
            $ranking->cargo_id = $request->cargo_id;
        } 
         
        if ($request->has('colaborador_id')) {
            $ranking->colaborador_id = $request->colaborador_id;
        }
        
        if ($request->has('nota_desempenho')) {
            $ranking->nota_desempenho = $request->nota_desempenho;
        }
    
        // Salve as alterações
        $ranking->save();
        dd($ranking->all());
        // Retorne uma resposta JSON com o modelo atualizado
        return response()->json($ranking, 200);
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
