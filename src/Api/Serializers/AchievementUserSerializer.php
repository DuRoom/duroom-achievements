<?php

/*
 * This file is part of duroom/achievements
 *
 *  Copyright (c) 2022 NKDuy
 *
 *  For detailed copyright and license information, please view the
 *  LICENSE file that was distributed with this source code.
 */

namespace DuRoom\Achievements\Api\Serializers;

use DuRoom\Api\Serializer\AbstractSerializer;
use DuRoom\Achievements\AchievementUser;
use DuRoom\Achievements\Achievement;

class AchievementUserSerializer extends AbstractSerializer
{
    /**
     * @var string
     */
    protected $type = 'achievement_user';

    /**
     * @param $group
     *
     * @return array
     */
    protected function getDefaultAttributes($ach)
    {
        if (!($ach instanceof AchievementUser)) {
            throw new InvalidArgumentException(
                get_class($this).' can only serialize instances of '.AchievementUser::class
            );
        }

        $achievement = Achievement::find($ach->achievement_id);

        return [
            'id' => $ach->achievement_id,
            'name' => $achievement->name,
            'description'   => $achievement->description,
            'computation'   => $achievement->computation,
            'points'   => $achievement->points,
            'image'   => $achievement->image,
            'rectangle'   => $achievement->rectangle,
            'active'   => $achievement->active,
            'hidden'   => $achievement->hidden,
            'created_at' => $ach->created_at,
            'new' => $ach->new
        ];
    }
}