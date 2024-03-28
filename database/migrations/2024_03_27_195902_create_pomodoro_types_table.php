<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PomodoroType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pomodoro_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('name');
            $table->timestamps();
        });

        $this->seedMe();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pomodoro_types');
    }

    private function seedMe()
    {
        $types = [
            'Basic',
            'API',
            'Client',
            'Conference',
            'Database', 
            'Documentation',
            'Email',
            'External', 
            'Framework',
            'Learning',
            'Meeting',
            'Research', 
        ];

        foreach ($types as $type) {
            PomodoroType::create(['name' => $type]);
        }
    }
};
