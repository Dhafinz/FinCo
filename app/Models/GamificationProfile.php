<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamificationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_xp', 'current_level', 'xp_to_next_level',
        'total_badges', 'total_achievements', 'challenges_completed', 'last_level_up'
    ];

    protected $casts = ['last_level_up' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function addXP(int $xp): void
    {
        $this->total_xp += $xp;
        
        while ($this->total_xp >= $this->xp_to_next_level) {
            $this->levelUp();
        }
        
        $this->save();
    }

    private function levelUp(): void
    {
        $this->current_level++;
        $this->last_level_up = now();
        
        if ($this->current_level <= 10) {
            $this->xp_to_next_level = $this->current_level * 100;
        } elseif ($this->current_level <= 25) {
            $this->xp_to_next_level = $this->xp_to_next_level + 200;
        } elseif ($this->current_level <= 50) {
            $this->xp_to_next_level = $this->xp_to_next_level + 300;
        } else {
            $this->xp_to_next_level = $this->xp_to_next_level + 500;
        }
    }
}