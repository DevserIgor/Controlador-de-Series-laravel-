@extends('layout')

@section('cabecalho')
Séries
@endsection

@section('conteudo')
@if(!empty($mensagem))
<div class="alert alert-success">
    {{ $mensagem }}
</div>
@endif
@auth()
<a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Adicionar</a>
@endauth
<ul class="list-group">
    @foreach ($series as $serie)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span id="nome-serie-{{ $serie->id }}">{{ $serie->nome }}</span>

        <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->id }}">
            <input type="text" class="form-control" value="{{ $serie->nome }}">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="editarSerie({{ $serie->id }})">
                    <i class="fas fa-check"></i>
                </button>
                @csrf {{--criptografia de requizição--}}
            </div>
        </div>

        <span class="d-flex">
            @auth()
            <button class="btn btn-info btn-sm mr-1" onclick="toggleInputName({{ $serie->id }})">
                <i class="fas fa-edit"></i>
            </button>
            @endauth
            <a href="/series/{{ $serie->id }}/temporadas" class="btn btn-info btn-sm mr-1">
                <i class="fas fa-external-link-alt"></i>
            </a>
            @auth()
            <form
                action="/series/{{ $serie->id }}"
                method="post"
                onsubmit=" return confirm('Tem certeza que deseja remover {{ addslashes( $serie->nome ) }}?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
            </form>
            @endauth
        </span>
    </li>
    @endforeach {{--series->serie--}}
</ul>
<script>
    function toggleInputName(serieId){
        const nomeSerieEl = document.getElementById(`nome-serie-${serieId}`);
        const inputNomeSerieEl = document.getElementById(`input-nome-serie-${serieId}`);

        if(nomeSerieEl.hasAttribute('hidden')){
            nomeSerieEl.removeAttribute('hidden');
            inputNomeSerieEl.hidden = true;
        }else{
            inputNomeSerieEl.removeAttribute('hidden');
            nomeSerieEl.hidden = true;
        }
    }

    function editarSerie(serieId){
        let formData = new FormData();
        const nome = document.querySelector(`#input-nome-serie-${ serieId } > input`).value;
        const token = document.querySelector('input[name="_token"]  ').value;
        formData.append('nome',nome);
        formData.append('_token', token);



        const url = `/series/${serieId}/editaNome`;
        fetch(url, {
            body: formData,
            method: 'POST'
        }).then(() =>{
            toggleInputName(serieId);
            document.getElementById(`nome-serie-${serieId}`).textContent = nome;
        });
    }

</script>
@endsection {{--Conteudo--}}



