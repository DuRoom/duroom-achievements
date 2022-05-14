<?php

/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace MaDuRoomlago\Achievements\Api\Controllers;

use DuRoom\Achievements\Api\Serializers\AchievementUserSerializer;
use DuRoom\Achievements\AchievementUser;
use DuRoom\Api\Controller\AbstractCreateController;
use DuRoom\User\User;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateAchievementUserController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = AchievementUserSerializer::class;

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $request->getAttribute('actor')->assertCan('administrate');

        $data = Arr::get($request->getParsedBody(), 'data', []);

        $username = Arr::get($data, 'attributes.user_id');
        $user_id = User::where('username',$username)->first();
        $achievement_id = Arr::get($data, 'attributes.id');
        $new = Arr::get($data, 'attributes.new');
        
        if($user_id != NULL){
            $delete = AchievementUser::where('user_id',$user_id->id)->where("achievement_id",$achievement_id)->first();
            if($delete != NULL){
                $delete->delete();
                return $delete;
            }

            $ach = AchievementUser::build(
                $user_id->id,
                $achievement_id,
                $new
            );
    
            $ach->save();
            return $ach;
        }
        return NULL;
        
    }
}