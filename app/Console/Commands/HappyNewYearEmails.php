<?php

namespace App\Console\Commands;

use App\Mail\HappyNewYear;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class HappyNewYearEmails extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'send:newyear-emails';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send Happy New Year emails to all registered users';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $users = User::all();

    foreach ($users as $user) {
      Mail::to($user->email)->send(new HappyNewYear($user));
    }

    $this->info("Happy New Year emails sent to all registered users.");
  }
}
