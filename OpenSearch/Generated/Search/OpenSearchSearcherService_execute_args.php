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
// HELPER FUNCTIONS AND STRUCTURES
class OpenSearchSearcherService_execute_args
{
    static $_TSPEC;
    /**
     * @var \OpenSearch\Generated\Search\SearchParams
     */
    public $searchParams = null;
    public function __construct($vals = null)
    {
        if (!isset(self::$_TSPEC)) {
            self::$_TSPEC = array(1 => array('var' => 'searchParams', 'type' => \Thrift\Type\TType::STRUCT, 'class' => '\OpenSearch\Generated\Search\SearchParams'));
        }
        if (is_array($vals)) {
            if (isset($vals['searchParams'])) {
                $this->searchParams = $vals['searchParams'];
            }
        }
    }
    public function getName()
    {
        return 'OpenSearchSearcherService_execute_args';
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
                    if ($ftype == \Thrift\Type\TType::STRUCT) {
                        $this->searchParams = new \OpenSearch\Generated\Search\SearchParams();
                        $xfer += $this->searchParams->read($input);
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
        $xfer += $output->writeStructBegin('OpenSearchSearcherService_execute_args');
        if ($this->searchParams !== null) {
            if (!is_object($this->searchParams)) {
                throw new \Thrift\Exception\TProtocolException('Bad type in structure.', \Thrift\Exception\TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('searchParams', \Thrift\Type\TType::STRUCT, 1);
            $xfer += $this->searchParams->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
