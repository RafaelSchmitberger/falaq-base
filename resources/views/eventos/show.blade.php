@extends('layouts.app')

@section('title', $evento->titulo . ' — FalaQ')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-12 gap-6">
    <!-- Formulário de envio de Pergunta -->
    <div class="md:col-span-5">
        <div class="bg-[#1a1d27] border border-[#2e3347] rounded-lg shadow-sm p-4">
            <h4 class="text-lg font-bold mb-3">💬 Faça sua Pergunta</h4>
            <form action="{{ route('eventos.perguntas.store', $evento->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="texto" class="block text-sm text-gray-300 mb-2">Texto da Pergunta</label>

                    <textarea name="texto" id="texto" rows="4"
                              class="w-full rounded-md bg-[#0f1117] text-white px-3 py-2 border @error('texto') border-red-500 @else border-[#2e3347] @enderror focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              placeholder="Digite sua dúvida ou comentário para o palestrante...">{{ old('texto') }}</textarea>

                    @error('texto')
                        <p class="text-red-500 text-sm mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-bold transition-colors">
                    Enviar Pergunta
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de Perguntas (TICKET #002) -->
    <div class="md:col-span-7">
        <div class="flex justify-between items-center mb-3">
            <h4 class="text-lg font-bold m-0">📋 Perguntas do Evento</h4>
            <span class="text-gray-400 text-sm">Total no Banco: {{ $evento->perguntas->count() }}</span>
        </div>

        @forelse($perguntas as $pergunta)
            <div class="bg-[#1a1d27] border-l-4 border-indigo-500 rounded-lg shadow-sm p-4 mb-4">
                <p class="text-lg text-white mb-2">{{ $pergunta->texto }}</p>
                <div class="flex justify-between items-center text-gray-400 text-sm">
                    <span>Status:
                        <span class="bg-green-600 text-white text-xs font-semibold px-2 py-1 rounded-full">{{ $pergunta->status }}</span>
                    </span>
                    <span>{{ $pergunta->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        @empty
            <div class="bg-[#1a1d27] text-center p-6 rounded-lg text-gray-400 mb-4">
                Nenhuma pergunta enviada ainda. Seja o primeiro!
            </div>
        @endforelse

        <!-- TICKET #002: Renderização dos Botões de Paginação -->
        @if(method_exists($perguntas, 'links'))
            <div class="flex justify-center mt-4">
                {{ $perguntas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
