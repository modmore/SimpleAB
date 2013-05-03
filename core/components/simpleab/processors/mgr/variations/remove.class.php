<?php
/**
 * Gets a list of sabConversion objects.
 */
class sabVariationRemoveProcessor extends modObjectProcessor {
    public $classKey = 'sabVariation';
    public $backup = array(
        'sabConversion' => array(),
        'sabPick' => array(),
        'sabVariation' => array(),
    );

    /**
     * @var xPDOObject $object
     */
    public $object;

    /**
     * @return array|string
     */
    public function process() {
        $this->object = $this->modx->getObject($this->classKey, $this->getProperty($this->primaryKeyField));
        if (!$this->object) return $this->failure('err_obj_nf');

        $c = $this->modx->newQuery('sabConversion');
        $c->where(array(
            'variation' => $this->object->get($this->primaryKeyField),
        ));
        foreach ($this->modx->getIterator('sabConversion', $c) as $conversion) {
            /** @var sabConversion $conversion */
            $this->backup['sabConversion'][] = $conversion->toArray();
            $conversion->remove();
        }

        $c = $this->modx->newQuery('sabPick');
        $c->where(array(
            'variation' => $this->object->get($this->primaryKeyField),
        ));
        foreach ($this->modx->getIterator('sabPick', $c) as $pick) {
            /** @var sabPick $pick */
            $this->backup['sabPick'][] = $pick->toArray();
            $pick->remove();
        }

        $this->backup[$this->classKey][] = $this->object->toArray();

        $this->writeBackup();

        if ($this->object->remove()) {
            return $this->success();
        }
        return $this->failure('err_obj_remove');
    }

    public function writeBackup() {
        $total = 0;

        $data = array();
        foreach ($this->backup as $type => $items) {
            $itemsXml = array();
            foreach ($items as $object) {
                $objectXml = array();
                foreach ($object as $key => $value) {
                    if (!is_numeric($value) && !is_bool($value) && !is_null($value)) {
                        $objectXml[] = "<{$key}><![CDATA[{$value}]]></{$key}>";
                    } else {
                        $objectXml[] = "<{$key}>{$value}</{$key}>";
                    }
                }
                $objectXml = implode("", $objectXml);
                $itemsXml[] = "<{$type}>{$objectXml}</{$type}>";
                $total++;
            }
            $itemsXml = implode("\n", $itemsXml);
            $data[] = $itemsXml;
        }
        $data = implode("\n\n", $data);

        $time = date('Y-m-d@H:i:s');
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<data package="simpleab" exported="$time" total="$total">
$data
</data>
XML;
        $this->modx->cacheManager->set('backups/' . date('Y-m-d_H-i-s') . '_variation' . $this->object->get($this->primaryKeyField) , $xml, 0, array(xPDO::OPT_CACHE_KEY => 'simpleab'));
    }
}
return 'sabVariationRemoveProcessor';
