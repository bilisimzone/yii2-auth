<?php

/*
 * This file is part of the Coreb2c project.
 *
 * (c) Coreb2c project <http://github.com/coreb2c/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace coreb2c\auth\helpers;

/**
 * Timezone helper.
 *
 * @author Abdullah Tulek <abdullah.tulek@coreb2c.com>
 */
class Timezone {

    /**
     * Get all of the time zones with the offsets sorted by their offset
     *
     * @return array
     */
    public static function getAll() {
        $timeZones = [];
        $timeZoneIdentifiers = \DateTimeZone::listIdentifiers();

        foreach ($timeZoneIdentifiers as $timeZone) {
            $date = new \DateTime('now', new \DateTimeZone($timeZone));
            $offset = $date->getOffset() / 60 / 60;
            $timeZones[] = [
                'timezone' => $timeZone,
                'name' => "{$timeZone} (UTC " . ($offset > 0 ? '+' : '') . "{$offset})",
                'offset' => $offset
            ];
        }

        \yii\helpers\ArrayHelper::multisort($timeZones, 'offset', SORT_DESC, SORT_NUMERIC);

        return $timeZones;
    }

}
