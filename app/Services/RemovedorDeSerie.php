<?php


namespace App\Services;


use App\{Episodio, Events\SerieApagada, Jobs\ExcluirCapaSerie, Serie, Temporada};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class RemovedorDeSerie
{
    public function removerSerie(int $serieId) : String
    {
        $nomeSerie = '';
        DB::transaction(function() use ($serieId, &$nomeSerie){

            $serie = Serie::find($serieId);
            $serieObj =  (object) $serie->toArray();
            $nomeSerie = $serie->nome;
            $this->removerTemporada($serie);
            $serie->delete();

            //$evento = new SerieApagada($serieObj);
            //event($evento);
            ExcluirCapaSerie::dispatch($serieObj);
        });
        return $nomeSerie;
    }

    /**
     * @param $serie
     */
    private function removerTemporada(Serie $serie): void
    {
        $serie->temporadas()->each(function (Temporada $temporada) {
            $this->RemoverEpisodio($temporada);
            $temporada->delete();
        });

    }

    /**
     * @param Temporada $temporada
     * @throws \Exception
     */
    private function RemoverEpisodio(Temporada $temporada): void
    {
        $temporada->episodios()->each(function (Episodio $episodioo) {
            $episodioo->delete();
        });
    }
}
