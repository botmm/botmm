<?php


namespace botmm\Tars\Protocol\Tars;


class HeadData {

    /**
     * @var byte
     */
    public $type;
    public $tag;

    public function clear() {
        $this->type = 0;
        $this->tag = 0;
    }

    public function __toString()
    {
        return "[type]: `{$this->type}` [tag]: `{$this->tag}`";
    }
}