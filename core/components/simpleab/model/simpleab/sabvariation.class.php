<?php
/**
 * SimpleAB
 *
 * Copyright 2011-2013 by Mark Hamstra <mark@modx.com>
 *
 * This file is part of SimpleAB
 *
 * SimpleAB is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * SimpleAB is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SimpleAB; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
*/
class sabVariation extends xPDOSimpleObject {
    public function clearCache() {
        $cacheOptions = $this->xpdo->simpleab->cacheOptions;
        $id = $this->get('id');
        $testId = $this->get('test');

        $this->xpdo->cacheManager->delete("tests/{$testId}/stats", $cacheOptions);
        $this->xpdo->cacheManager->delete("tests/{$testId}/variations", $cacheOptions);
    }

    /**
     * {@inheritdoc}
     *
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function save($cacheFlag= null) {
        $return = parent::save($cacheFlag);
        $this->clearCache();
        return $return;
    }

    /**
     * {@inheritdoc}
     *
     * @param null $cacheFlag
     *
     * @return bool
     */
    public function remove (array $ancestors = array()) {
        $return = parent::remove($ancestors);
        $this->clearCache();
        return $return;
    }
}
