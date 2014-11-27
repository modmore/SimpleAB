<?php
/**
 * Gets a list of cbField objects.
 */
class SimpleABChunkGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modChunk';
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
}
return 'SimpleABChunkGetListProcessor';
