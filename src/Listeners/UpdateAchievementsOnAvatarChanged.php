<?php

/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Achievements\Listeners;

use DuRoom\Achievements\AchievementCalculator;
use DuRoom\User\Event\AvatarChanged;
use DuRoom\Post\Post;

class UpdateAchievementsOnAvatarChanged
{

    protected $calculator;

    public function __construct(AchievementCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(AvatarChanged $event)
    {

        $arr = array(
            array(
                "type"=>"avatar",
                "count"=>($event->user->avatar_url!=NULL ? 1:-1),
                "user"=>$event->user,
                "new"=>0,
            )
        );

        $event->actor["new_achievements"] = $this->calculator->recalculate($event->user,$arr);
    }
}