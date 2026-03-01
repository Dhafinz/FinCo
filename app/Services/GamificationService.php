<?php

namespace App\Services;

use App\Models\User;
use App\Models\GamificationProfile;

class GamificationService
{
    public function awardXP(User $user, int $xp, string $source): void
    {
        $profile = $user->gamificationProfile;
        
        if (!$profile) {
            $profile = GamificationProfile::create(['user_id' => $user->id]);
        }

        $oldLevel = $profile->current_level;
        $profile->addXP($xp);

        if ($profile->current_level > $oldLevel) {
            \Log::info("User {$user->id} leveled up from {$oldLevel} to {$profile->current_level}");
        }
    }

    public function calculateTransactionXP(float $amount): int
    {
        $baseXP = 10;
        $bonusXP = floor($amount / 100000) * 5;
        return $baseXP + $bonusXP;
    }

    public function getUserProgress(User $user): array
    {
        $profile = $user->gamificationProfile;
        
        if (!$profile) {
            return [
                'level' => 1,
                'total_xp' => 0,
                'xp_to_next_level' => 100,
                'progress_percentage' => 0,
            ];
        }

        $currentLevelXP = $profile->total_xp - ($profile->xp_to_next_level - 100);
        $xpForNextLevel = 100;
        
        return [
            'level' => $profile->current_level,
            'total_xp' => $profile->total_xp,
            'xp_to_next_level' => $profile->xp_to_next_level,
            'xp_needed' => max(0, $profile->xp_to_next_level - $profile->total_xp),
            'progress_percentage' => min(100, ($currentLevelXP / $xpForNextLevel) * 100),
            'badges' => $profile->total_badges,
            'achievements' => $profile->total_achievements,
        ];
    }
}