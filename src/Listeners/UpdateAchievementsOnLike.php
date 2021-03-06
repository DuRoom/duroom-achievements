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
use DuRoom\Likes\Event\PostWasLiked;
use DuRoom\Likes\Event\PostWasUnliked;
use DuRoom\Post\Post;
use DuRoom\User\User;
use DuRoom\Post\CommentPost;
use DuRoom\Discussion\Discussion;
use Illuminate\Database\Eloquent\Model;

class UpdateAchievementsOnLike
{
    protected $calculator;

    public function __construct(AchievementCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function extensionDependencies(): array
    {
        return ['duroom-likes'];
    }

    public function handle(PostWasLiked $event)
    {

        $arr = array(
            array(
                "type"=>"likes",
                "count"=>User::where("id","=",$event->actor->id)->join('post_likes', 'users.id', '=', 'post_likes.user_id')->count(),
                "user"=>$event->actor,
                "new"=>0,
            ),
            array(
                "type"=>"selflikes",
                "count"=>CommentPost::where('user_id', $event->post->user_id)->select('id')->withCount('likes')->get()->sum('likes_count'),
                "user"=>$event->post->user,
                "new"=>1,
            ),
        );


        $event->actor["new_achievements"] = $this->calculator->recalculate($event->actor,$arr);
    }
}