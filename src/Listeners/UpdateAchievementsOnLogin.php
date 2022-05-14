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
use DuRoom\User\Event\LoggedIn;
use DuRoom\Discussion\Discussion;
use DuRoom\Post\Post;
use DuRoom\Post\CommentPost;

class UpdateAchievementsOnLogin
{

    protected $calculator;

    public function __construct(AchievementCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function handle(LoggedIn $event)
    {
        $datetime1 = date_create($event->user->joined_at);
        $datetime2 = date_create(date("r"));
    
        $years = date_diff($datetime2, $datetime1)->days/365;

        $arr = array(
            array(
                "type"=>"years",
                "count"=>$years,
                "user"=>$event->user,
                "new"=>1,
            ),
            array(
                "type"=>"avatar",
                "count"=>($event->user->avatar_url!=NULL ? 1:-1),
                "user"=>$event->user,
                "new"=>1,
            )
        );

        $event->actor["new_achievements"] = $this->calculator->recalculate($event->user,$arr);
    }
}