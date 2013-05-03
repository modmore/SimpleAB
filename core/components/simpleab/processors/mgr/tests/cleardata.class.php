<?php
/**
 * Gets a list of sabConversion objects.
 */
class testsClearDataProcessor extends modObjectProcessor {
    public $classKey = 'sabTest';
    public $backup = array(
        'sabVariation' => array(),
        'sabConversion' => array(),
        'sabPick' => array(),
    );

    public function process() {
        $this->object = $this->modx->getObject($this->classKey, $this->getProperty($this->primaryKeyField));
        if (!$this->object) return $this->failure('err_obj_nf');

        $clearConversions = (bool)$this->getProperty('clear_conversions');
        $clearPicks = (bool)$this->getProperty('clear_picks');
        $clearVariations = (bool)$this->getProperty('clear_variations');

        if (!$clearConversions && !$clearPicks && !$clearVariations) {
            $this->addFieldError('id', 'Please pick at least one type of data to clear.');
            return $this->failure();
        }

        if ($clearConversions) {
            $c = $this->modx->newQuery('sabConversion');
            $c->where(array(
                'test' => $this->object->get($this->primaryKeyField),
            ));
            foreach ($this->modx->getIterator('sabConversion', $c) as $conversion) {
                /** @var sabConversion $conversion */
                $this->backup['sabConversion'][] = $conversion->toArray();
                $conversion->remove();
            }
        }

        if ($clearPicks) {
            $c = $this->modx->newQuery('sabPick');
            $c->where(array(
                'test' => $this->object->get($this->primaryKeyField),
            ));
            foreach ($this->modx->getIterator('sabPick', $c) as $pick) {
                /** @var sabPick $pick */
                $this->backup['sabPick'][] = $pick->toArray();
                $pick->remove();
            }
        }

        if ($clearVariations) {
            $c = $this->modx->newQuery('sabVariation');
            $c->where(array(
                'test' => $this->object->get($this->primaryKeyField),
            ));
            foreach ($this->modx->getIterator('sabVariation', $c) as $variation) {
                /** @var sabVariation $variation */
                $this->backup['sabVariation'][] = $variation->toArray();
                $variation->remove();
            }
        }

        $this->writeBackup();

        return $this->success();
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
        $this->modx->cacheManager->set('backups/' . date('Y-m-d_H-i-s'), $xml, 0, array(xPDO::OPT_CACHE_KEY => 'simpleab'));
    }
}
return 'testsClearDataProcessor';
