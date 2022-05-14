<?php
/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Achievements;

use DuRoom\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use DuRoom\User\User;
use DuRoom\User\Event\LoggedIn;
use DuRoom\User\Event\AvatarChanged;

use DuRoom\Post\Event\Posted;
use DuRoom\Post\Event\Revised;
use DuRoom\Discussion\Event\Started;

use DuRoom\Api\Controller;
use DuRoom\Api\Serializer;

use DuRoom\Likes\Event\PostWasLiked;
use DuRoom\Likes\Event\PostWasUnliked;

use DuRoom\Achievements\Api\Serializers;
use DuRoom\Achievements\Api\Controllers;
use DuRoom\Achievements\Achievement;
use DuRoom\Achievements\AchievementUser;
use DuRoom\Achievements\Api\Serializers\AchievementSerializer;
use DuRoom\Achievements\Middlewares\MiddlewarePosted;

return [
    (new Extend\Frontend('forum'))
        ->route('/achievements', 'duroom-achievements'),
        
    (new Extend\Routes('api'))
        ->get('/achievements', 'achievements.index', Controllers\ListAchievementsController::class)
        ->post('/achievements', 'achievements.create', Controllers\CreateAchievementController::class)
        ->patch('/achievements/{id}', 'achievements.update', Controllers\UpdateAchievementController::class)
        ->delete('/achievements/{id}', 'achievements.delete', Controllers\DeleteAchievementController::class)
        ->post('/achievement_user', 'achievements_user.create', Controllers\CreateAchievementUserController::class)
        ->patch('/achievement_user/{id}', 'achievements_user.update', Controllers\UpdateAchievementUserController::class),
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),
    new Extend\Locales(__DIR__.'/locale'),
    (new Extend\Model(User::class))
        ->relationship('achievements', function ($user) {
            return $user->hasMany(AchievementUser::class, 'user_id');
        }),
    (new Extend\ApiSerializer(Serializer\ForumSerializer::class))
        ->hasMany('achievements', Serializers\AchievementSerializer::class),

    (new Extend\ApiSerializer(Serializer\UserSerializer::class))
        ->hasMany('achievements', Serializers\AchievementUserSerializer::class),

    (new Extend\ApiSerializer(Serializer\BasicUserSerializer::class))
        ->hasMany('achievements', Serializers\AchievementSerializer::class)
        ->attributes(AddUserData::class),

    (new Extend\ApiController(Controller\ListUsersController::class))
        ->addInclude('achievements'),
    (new Extend\ApiController(Controller\ShowUserController::class))
        ->addInclude('achievements'),
    (new Extend\ApiController(Controller\UpdateUserController::class))
        ->addInclude('achievements'),
    (new Extend\ApiController(Controller\CreateUserController::class))
        ->addInclude('achievements'),
    (new Extend\ApiController(Controller\ShowDiscussionController::class))
        ->addInclude('posts.user.achievements'),
    (new Extend\ApiController(Controller\ListPostsController::class))
        ->addInclude('user.achievements'),

    (new Extend\ApiSerializer(Serializer\PostSerializer::class))
        ->attributes(AddPostData::class),


    (new Extend\Event())
        ->listen(LoggedIn::class, Listeners\UpdateAchievementsOnLogin::class),

    (new Extend\Event())
        ->listen(Posted::class, Listeners\UpdateAchievementsOnPost::class)
        ->listen(Revised::class, Listeners\UpdateAchievementsOnRevised::class)
        ->listen(Started::class, Listeners\UpdateAchievementsOnDiscussion::class)
        ->listen(PostWasLiked::class, Listeners\UpdateAchievementsOnLike::class)
        ->listen(PostWasUnliked::class, Listeners\UpdateAchievementsOnUnlike::class)
        ->listen(AvatarChanged::class, Listeners\UpdateAchievementsOnAvatarChanged::class),
    
    (new Extend\Middleware('api'))->add(MiddlewarePosted::class),
    (new Extend\Middleware('forum'))->add(MiddlewarePosted::class),

    (new Extend\Settings)
        ->serializeToForum('duroom-achievements.show-post-footer', 'duroom-achievements.show-post-footer')
        ->serializeToForum('duroom-achievements.show-user-card', 'duroom-achievements.show-user-card')
        ->serializeToForum('duroom-achievements.link-left-column', 'duroom-achievements.link-left-column')
];
