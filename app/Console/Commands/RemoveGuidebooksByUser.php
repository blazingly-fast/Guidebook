<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RemoveGuidebooksByUser extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'remove:guidebooks {email : The email of the user whose guidebooks should be removed}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Laravel command which will remove all guidebooks of some user whose email is sent as a parameter to command.';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $email = $this->argument('email');
    $user = User::where('email', $email)->first();

    if ($user) {
      $guidebooks = $user->guidebooks;
      DB::table('guidebooks')->whereIn('id', $guidebooks->pluck('id'))->delete();

      $this->info("All guidebooks of user with email $email have been removed.");
    } else {
      $this->error("User with email $email not found.");
    }
  }
}
