<?php

namespace OpenSearch\Generated\Common;

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
class OpenSearchException extends \Thrift\Exception\TException
{
    static $_TSPEC;
    /**
     * @var int
     */
    public $code = null;
    /**
     * @var string
     */
    public $message = null;
    /**
     * @var string
     */
    public $requestId = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(1 => array('var' => 'code', 'type' => \Thrift\Type\TType::I32), 2 => array('var' => 'message', 'type' => \Thrift\Type\TType::STRING), 3 => array('var' => 'requestId', 'type' => \Thrift\Type\TType::STRING));
        }
        if (is_array($vals)) {
            if (isset($vals['code'])) {
                $this->code = $vals['code'];
            }
            if (isset($vals['message'])) {
                $this->message = $vals['message'];
            }
            if (isset($vals['requestId'])) {
                $this->requestId = $vals['requestId'];
            }
        }
    }
    public function getName()
    {
        return 'OpenSearchException';
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
                    if ($ftype == \Thrift\Type\TType::I32) {
                        $xfer += $input->readI32($this->code);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->message);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->requestId);
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
        $xfer += $output->writeStructBegin('OpenSearchException');
        if ($this->code !== null) {
            $xfer += $output->writeFieldBegin('code', \Thrift\Type\TType::I32, 1);
            $xfer += $output->writeI32($this->code);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->message !== null) {
            $xfer += $output->writeFieldBegin('message', \Thrift\Type\TType::STRING, 2);
            $xfer += $output->writeString($this->message);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->requestId !== null) {
            $xfer += $output->writeFieldBegin('requestId', \Thrift\Type\TType::STRING, 3);
            $xfer += $output->writeString($this->requestId);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
