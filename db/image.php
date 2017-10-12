<?php
/**
 * NextCloud / ownCloud - fractalnote
 *
 * Licensed under the Apache License, Version 2.0
 *
 * @author Alexander Demchenko <a.demchenko@aldem.ru>, <https://github.com/alboro>
 * @copyright Alexander Demchenko 2017
 */
namespace OCA\FractalNote\Db;

/**
 * Class Image
 *
 * @method integer getNodeId()
 * @method integer getOffset()
 * @method string getJustification()
 * @method string getAnchor()
 * @method string getPng()
 * @method string getFilename()
 * @method string getLink()
 * @method integer getTime()
 * @method void setNodeId(integer $value)
 * @method void setOffset(integer $offset)
 * @method void setJustification(string $value)
 * @method void setAnchor(string $value)
 * @method void setPng(string $value)
 * @method void setFilename(string $value)
 * @method void setLink(string $value)
 * @method void setTime(integer $time)
 *
 * @package OCA\FractalNote\Db
 */
class Image extends Entity
{
    protected $nodeId;
    protected $offset;
    protected $justification;
    protected $anchor;
    protected $png;
    protected $filename;
    protected $link;
    protected $time;

    public function __construct()
    {
        parent::__construct();
        $this->addType('nodeId', 'integer');
        $this->addType('offset', 'integer');
        $this->addType('time', 'integer');
    }

    public function getPrimaryPropertyName()
    {
        return 'nodeId';
    }

    public function getPropertiesConfig()
    {
        return [
            'nodeId' => [],
            'offset' => [],
            'justification' => [],
            'anchor' => [],
            'png' => [],
            'filename' => [],
            'link' => [],
            'time' => [],
        ];
    }
}