<?php

namespace OpenSearch\Generated\Suggestion;

/**
 * Autogenerated by Thrift Compiler (0.9.3)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;
/**
 * 下拉提示参数
 */
class SuggestParams
{
    static $_TSPEC;
    /**
     * 搜索关键词
     * 
     * @var string
     */
    public $query = null;
    /**
     * 下拉提示条数
     * 
     * @var int
     */
    public $hits = 10;
    /**
     * 用来标识发起当前下拉提示请求的终端用户。
     * 建议跟搜索请求中userId参数保持一致。
     * 
     * @var string
     */
    public $userId = null;
    /**
     * 重查策略
     * 
     * @var int
     */
    public $reSearch = null;
    /**
     * 自定义参数
     * 
     * @var array
     */
    public $customParams = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(1 => array('var' => 'query', 'type' => \Thrift\Type\TType::STRING), 3 => array('var' => 'hits', 'type' => \Thrift\Type\TType::I32), 5 => array('var' => 'userId', 'type' => \Thrift\Type\TType::STRING), 7 => array('var' => 'reSearch', 'type' => \Thrift\Type\TType::I32), 9 => array('var' => 'customParams', 'type' => \Thrift\Type\TType::MAP, 'ktype' => \Thrift\Type\TType::STRING, 'vtype' => \Thrift\Type\TType::STRING, 'key' => array('type' => \Thrift\Type\TType::STRING), 'val' => array('type' => \Thrift\Type\TType::STRING)));
        }
        if (is_array($vals)) {
            if (isset($vals['query'])) {
                $this->query = $vals['query'];
            }
            if (isset($vals['hits'])) {
                $this->hits = $vals['hits'];
            }
            if (isset($vals['userId'])) {
                $this->userId = $vals['userId'];
            }
            if (isset($vals['reSearch'])) {
                $this->reSearch = $vals['reSearch'];
            }
            if (isset($vals['customParams'])) {
                $this->customParams = $vals['customParams'];
            }
        }
    }
    public function getName()
    {
        return 'SuggestParams';
    }
    public function read($input)
    {
        $xfer = 0;
        $fname = null;
        $ftype = 0;
        $fid = 0;
        $xfer += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == \Thrift\Type\TType::STOP) {
                break;
            }
            switch ($fid) {
                case 1:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->query);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == \Thrift\Type\TType::I32) {
                        $xfer += $input->readI32($this->hits);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->userId);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == \Thrift\Type\TType::I32) {
                        $xfer += $input->readI32($this->reSearch);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 9:
                    if ($ftype == \Thrift\Type\TType::MAP) {
                        $this->customParams = array();
                        $_size0 = 0;
                        $_ktype1 = 0;
                        $_vtype2 = 0;
                        $xfer += $input->readMapBegin($_ktype1, $_vtype2, $_size0);
                        for ($_i4 = 0; $_i4 < $_size0; ++$_i4) {
                            $key5 = '';
                            $val6 = '';
                            $xfer += $input->readString($key5);
                            $xfer += $input->readString($val6);
                            $this->customParams[$key5] = $val6;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }
    public function write($output)
    {
        $xfer = 0;
        $xfer += $output->writeStructBegin('SuggestParams');
        if ($this->query !== null) {
            $xfer += $output->writeFieldBegin('query', \Thrift\Type\TType::STRING, 1);
            $xfer += $output->writeString($this->query);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->hits !== null) {
            $xfer += $output->writeFieldBegin('hits', \Thrift\Type\TType::I32, 3);
            $xfer += $output->writeI32($this->hits);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->userId !== null) {
            $xfer += $output->writeFieldBegin('userId', \Thrift\Type\TType::STRING, 5);
            $xfer += $output->writeString($this->userId);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->reSearch !== null) {
            $xfer += $output->writeFieldBegin('reSearch', \Thrift\Type\TType::I32, 7);
            $xfer += $output->writeI32($this->reSearch);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->customParams !== null) {
            if (!is_array($this->customParams)) {
                throw new \Thrift\Exception\TProtocolException('Bad type in structure.', \Thrift\Exception\TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('customParams', \Thrift\Type\TType::MAP, 9);
            $output->writeMapBegin(\Thrift\Type\TType::STRING, \Thrift\Type\TType::STRING, count($this->customParams));
            foreach ($this->customParams as $kiter7 => $viter8) {
                $xfer += $output->writeString($kiter7);
                $xfer += $output->writeString($viter8);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
