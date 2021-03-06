<?php

namespace OpenSearch\Generated\DataCollection;

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
// HELPER FUNCTIONS AND STRUCTURES
class DataCollectionService_push_args
{
    static $_TSPEC;
    /**
     * @var string
     */
    public $docJson = null;
    /**
     * @var string
     */
    public $searchAppName = null;
    /**
     * @var string
     */
    public $dataCollectionName = null;
    /**
     * @var string
     */
    public $dataCollectionType = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(1 => array('var' => 'docJson', 'type' => \Thrift\Type\TType::STRING), 2 => array('var' => 'searchAppName', 'type' => \Thrift\Type\TType::STRING), 3 => array('var' => 'dataCollectionName', 'type' => \Thrift\Type\TType::STRING), 4 => array('var' => 'dataCollectionType', 'type' => \Thrift\Type\TType::STRING));
        }
        if (is_array($vals)) {
            if (isset($vals['docJson'])) {
                $this->docJson = $vals['docJson'];
            }
            if (isset($vals['searchAppName'])) {
                $this->searchAppName = $vals['searchAppName'];
            }
            if (isset($vals['dataCollectionName'])) {
                $this->dataCollectionName = $vals['dataCollectionName'];
            }
            if (isset($vals['dataCollectionType'])) {
                $this->dataCollectionType = $vals['dataCollectionType'];
            }
        }
    }
    public function getName()
    {
        return 'DataCollectionService_push_args';
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
                        $xfer += $input->readString($this->docJson);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->searchAppName);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->dataCollectionName);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == \Thrift\Type\TType::STRING) {
                        $xfer += $input->readString($this->dataCollectionType);
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
        $xfer += $output->writeStructBegin('DataCollectionService_push_args');
        if ($this->docJson !== null) {
            $xfer += $output->writeFieldBegin('docJson', \Thrift\Type\TType::STRING, 1);
            $xfer += $output->writeString($this->docJson);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->searchAppName !== null) {
            $xfer += $output->writeFieldBegin('searchAppName', \Thrift\Type\TType::STRING, 2);
            $xfer += $output->writeString($this->searchAppName);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->dataCollectionName !== null) {
            $xfer += $output->writeFieldBegin('dataCollectionName', \Thrift\Type\TType::STRING, 3);
            $xfer += $output->writeString($this->dataCollectionName);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->dataCollectionType !== null) {
            $xfer += $output->writeFieldBegin('dataCollectionType', \Thrift\Type\TType::STRING, 4);
            $xfer += $output->writeString($this->dataCollectionType);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
