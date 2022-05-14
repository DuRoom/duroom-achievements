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
use DuRoom\Post\Event\Revised;
use DuRoom\Post\Post;

class UpdateAchievementsOnRevised
{

    protected $calculator;

    public function __construct(AchievementCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(Revised $event)
    {

        $arr = array(
            array(
                "type"=>"edits",
                "count"=>Post::where('user_id', $event->actor->user_id)->select('id')->whereNotNull('edited_at')->get()->count(),
                "user"=>$event->actor,
                "new"=>0,
            )
        );

        $event->actor["new_achievements"] = $this->calculator->recalculate($event->actor,$arr);
    }
}