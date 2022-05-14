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
use DuRoom\Achievements\Achievement;

class AchievementSerializer extends AbstractSerializer
{
    /**
     * @var string
     */
    protected $type = 'achievements';

    /**
     * @param $group
     *
     * @return array
     */
    protected function getDefaultAttributes($ach)
    {
        if (!($ach instanceof Achievement)) {
            throw new \InvalidArgumentException(
                get_class($this).' can only serialize instances of '.Achievement::class
            );
        }

        // // app('log')->error("NEW: ".print_r($ach->pivot["new"],TRUE));
		$new=$ach->pivot == null?0:$ach->pivot["new"];
		
        return [
            'name' => $ach->name,
            'description'   => $ach->description,
            'computation'   => $ach->computation,
            'points'   => $ach->points,
            'image'   => $ach->image,
            'rectangle'   => $ach->rectangle,
            'active'   => $ach->active,
            'hidden'   => $ach->hidden,
            'new'   => $new,
        ];
    }


    // protected function group($trustLevel)
    // {
    //     return $this->hasOne($trustLevel, GroupSerializer::class);
    // }

    protected function users($ach)
    {
        return $this->users($ach, BasicUserSerializer::class);
    }
}