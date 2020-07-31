@extends('layout')
@section('cabecalho')
Adicionar Séries
@endsection
@section('conteudo')

@include("erros", ['errors'=> $errors] )

<form action="{{ route('series.store') }}" method="post" >
    @csrf
    <div class="row">
        <div class="col col-8">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome">
        </div>
        <div class="col col-2">
            <label for="qtd_temporadas">Nº Premporadas</label>
            <input type="number" class="form-control" id="qtd_temporadas" name="qtd_temporadas">
        </div>
        <div class="col col-2">
            <label for="ep_por_temporada">Ep. por temporada</label>
            <input type="bumber" class="form-control" id="ep_por_temporada" name="ep_por_temporada">
        </div>
    </div>

    <button class="btn btn-primary mt-2">Adicionar</button>
</form>
@endsection

