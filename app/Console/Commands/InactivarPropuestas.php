<?php

namespace App\Console\Commands;

use App\Models\Propuesta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Notifications\NotificacionInactivacion;

class InactivarPropuestas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inactivar:propuestas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inactivar propuestas a fin de cada mes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $activos = Propuesta::where('active', 1)->get();
            $email = Config::get('params.credentials.email');
            $activos= count($activos);
            Propuesta::where('active', 1)->update(['active' => 0]);
            Mail::send('mails.inactivas', ['activos' => $activos], function ($message) use ($email) {
                $message->to($email)->subject("Inactivación de Ordenes de compra");
            });

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
    }
}
