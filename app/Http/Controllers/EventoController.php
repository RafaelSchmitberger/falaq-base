<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventoFormRequest;
use App\Models\Evento;
use App\Models\Pergunta;
use App\Http\Requests\StorePerguntaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::all();
        return view('eventos.index', compact('eventos'));
    }

    /**
     * TICKET #006 (MODERAÇÃO):
     * Só traz perguntas com is_public = true, mantendo o eager loading
     * de 'user' e a paginação já resolvidos nas sprints anteriores.
     */
    public function show($id)
    {
        $evento = Evento::find($id);

        $perguntas = Pergunta::where('evento_id', $id)
            ->where('is_public', true)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('eventos.show', compact('evento', 'perguntas'));
    }

    /**
     * TICKET #001 (BUG LEGADO DE SEGURANÇA):
     * Salva a pergunta usando a requisição sem validações rigorosas.
     */
    public function storePergunta(StorePerguntaRequest $request, $id)
    {
        $evento = Evento::findOrFail($id);

        Pergunta::create([
            'evento_id' => $evento->id,
            'user_id' => Auth::user()->id,
            'texto'     => $request->input('texto'),
            'status'    => 'pendente',
        ]);

        return redirect()->route('eventos.show', $evento->id)
            ->with('sucesso', 'Sua pergunta foi enviada com sucesso!');
    }


    public function create(){
        return view('eventos.create');
    }

    public function store(EventoFormRequest $req){
        $evento = $req->user()->eventos()->create($req->validated());
        return redirect()->route('eventos.show', $evento->id);
    }
}
