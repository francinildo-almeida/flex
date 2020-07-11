<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Professor;
use Illuminate\Http\Request;
use App\DataTables\CursoDataTable;
use App\Service\CursoService;
use App\Http\Requests\CursoRequest;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CursoDataTable $datatable)
    {
        return  $datatable->render('curso.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $professor = Professor::all()->pluck('nome', 'id');
        return view('curso.create', compact('professor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CursoRequest $request)
    {
       $retorno = CursoService::store($request->all());

       if ($retorno['status']) {
           return redirect()->route('curso.index');
       }

       return back()->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $retorno = CursoService::getCursoPorId($id);
        if ($retorno['status']) {
            return view('curso.create', [
                'curso' => $retorno['curso'],
                'professor' => $retorno['professor'],
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id)
    {
        $retorno = CursoService::update($request->all(), $id);
        if ($retorno['status']) {
            return redirect()->route('curso.index');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $retorno = CursoService::destroy($id);
        if ($retorno['status']) {
            return "Sucesso";
        }
        return abort(403, 'Erro ao Excuir ' .$retorno['erro']);
    }
}
