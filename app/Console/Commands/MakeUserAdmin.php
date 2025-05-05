<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Torna um usuário administrador pelo e-mail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->error("Usuário com e-mail {$email} não encontrado.");
            return 1;
        }

        $user->type = 'admin';
        $user->save();

        $this->info("Usuário {$user->name} agora é um administrador.");
        return 0;
    }
}
