<?php

namespace OpenSearch\Generated\SecondRank;

/**
 * Autogenerated by Thrift Compiler (0.10.0)
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
class SecondRankService_listByAppIdAndName_result
{
    static $_TSPEC;
    /**
     * @var \OpenSearch\Generated\SecondRank\SecondRank[]
     */
    public $success = null;
    /**
     * @var \OpenSearch\Generated\Common\OpenSearchException
     */
    public $error = null;
    /**
     * @var \OpenSearch\Generated\Common\OpenSearchClientException
     */
    public $e = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(0 => array('var' => 'success', 'type' => \Thrift\Type\TType::LST, 'etype' => \Thrift\Type\TType::STRUCT, 'elem' => array('type' => \Thrift\Type\TType::STRUCT, 'class' => '\OpenSearch\Generated\SecondRank\SecondRank')), 1 => array('var' => 'error', 'type' => \Thrift\Type\TType::STRUCT, 'class' => '\OpenSearch\Generated\Common\OpenSearchException'), 2 => array('var' => 'e', 'type' => \Thrift\Type\TType::STRUCT, 'class' => '\OpenSearch\Generated\Common\OpenSearchClientException'));
        }
        if (is_array($vals)) {
            if (isset($vals['success'])) {
                $this->success = $vals['success'];
            }
            if (isset($vals['error'])) {
                $this->error = $vals['error'];
            }
            if (isset($vals['e'])) {
                $this->e = $vals['e'];
            }
        }
    }
    public function getName()
    {
        return 'SecondRankService_listByAppIdAndName_result';
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
                case 0:
                    if ($ftype == \Thrift\Type\TType::LST) {
                        $this->success = array();
                        $_size7 = 0;
                        $_etype10 = 0;
                        $xfer += $input->readListBegin($_etype10, $_size7);
                        for ($_i11 = 0; $_i11 < $_size7; ++$_i11) {
                            $elem12 = null;
                            $elem12 = new \OpenSearch\Generated\SecondRank\SecondRank();
                            $xfer += $elem12->read($input);
                            $this->success[] = $elem12;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 1:
                    if ($ftype == \Thrift\Type\TType::STRUCT) {
                        $this->error = new \OpenSearch\Generated\Common\OpenSearchException();
                        $xfer += $this->error->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == \Thrift\Type\TType::STRUCT) {
                        $this->e = new \OpenSearch\Generated\Common\OpenSearchClientException();
                        $xfer += $this->e->read($input);
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
        $xfer += $output->writeStructBegin('SecondRankService_listByAppIdAndName_result');
        if ($this->success !== null) {
            if (!is_array($this->success)) {
                throw new \Thrift\Exception\TProtocolException('Bad type in structure.', \Thrift\Exception\TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('success', \Thrift\Type\TType::LST, 0);
            $output->writeListBegin(\Thrift\Type\TType::STRUCT, count($this->success));
            foreach ($this->success as $iter13) {
                $xfer += $iter13->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->error !== null) {
            $xfer += $output->writeFieldBegin('error', \Thrift\Type\TType::STRUCT, 1);
            $xfer += $this->error->write($output);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->e !== null) {
            $xfer += $output->writeFieldBegin('e', \Thrift\Type\TType::STRUCT, 2);
            $xfer += $this->e->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
