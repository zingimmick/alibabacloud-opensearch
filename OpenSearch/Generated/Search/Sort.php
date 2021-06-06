<?php

namespace OpenSearch\Generated\Search;

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
 * 排序字段及方式
 * 
 */
class Sort
{
    static $_TSPEC;
    /**
     * @var \OpenSearch\Generated\Search\SortField[]
     */
    public $sortFields = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(1 => array('var' => 'sortFields', 'type' => \Thrift\Type\TType::LST, 'etype' => \Thrift\Type\TType::STRUCT, 'elem' => array('type' => \Thrift\Type\TType::STRUCT, 'class' => '\OpenSearch\Generated\Search\SortField')));
        }
        if (is_array($vals)) {
            if (isset($vals['sortFields'])) {
                $this->sortFields = $vals['sortFields'];
            }
        }
    }
    public function getName()
    {
        return 'Sort';
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
                    if ($ftype == \Thrift\Type\TType::LST) {
                        $this->sortFields = array();
                        $_size21 = 0;
                        $_etype24 = 0;
                        $xfer += $input->readListBegin($_etype24, $_size21);
                        for ($_i25 = 0; $_i25 < $_size21; ++$_i25) {
                            $elem26 = null;
                            $elem26 = new \OpenSearch\Generated\Search\SortField();
                            $xfer += $elem26->read($input);
                            $this->sortFields[] = $elem26;
                        }
                        $xfer += $input->readListEnd();
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
        $xfer += $output->writeStructBegin('Sort');
        if ($this->sortFields !== null) {
            if (!is_array($this->sortFields)) {
                throw new \Thrift\Exception\TProtocolException('Bad type in structure.', \Thrift\Exception\TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('sortFields', \Thrift\Type\TType::LST, 1);
            $output->writeListBegin(\Thrift\Type\TType::STRUCT, count($this->sortFields));
            foreach ($this->sortFields as $iter27) {
                $xfer += $iter27->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
