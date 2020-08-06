<?php

namespace App\Listeners;

use App\Events\NovaSerie;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EnviarEmailNovaSerieCadastrada implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovaSerie  $event
     * @return void
     */
    public function handle(NovaSerie $event)
    {
        $users = User::all();
        foreach ($users as $indice => $user){
            $multiplicador = $indice + 1;
            $email = new \App\Mail\NovaSerie(
                $event->nome,
                $event->qtdtemporadas,
                $event->qtdEpsodios
            );
            $email->subject = 'Nova Série Adicionada';
            $quando = now()->addSecond($multiplicador * 10);
            \Illuminate\Support\Facades\Mail::to($user)->later($quando,$email);
        }
    }
}
