<?php

namespace OpenSearch\Generated\App;

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
class AppServiceProcessor
{
    protected $handler_ = null;
    public function __construct($handler)
    {
        $this->handler_ = $handler;
    }
    public function process($input, $output)
    {
        $rseqid = 0;
        $fname = null;
        $mtype = 0;
        $input->readMessageBegin($fname, $mtype, $rseqid);
        $methodname = 'process_' . $fname;
        if (!method_exists($this, $methodname)) {
            $input->skip(\Thrift\Type\TType::STRUCT);
            $input->readMessageEnd();
            $x = new \Thrift\Exception\TApplicationException('Function ' . $fname . ' not implemented.', \Thrift\Exception\TApplicationException::UNKNOWN_METHOD);
            $output->writeMessageBegin($fname, \Thrift\Type\TMessageType::EXCEPTION, $rseqid);
            $x->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
            return;
        }
        $this->{$methodname}($rseqid, $input, $output);
        return true;
    }
    protected function process_save($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_save_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_save_result();
        try {
            $result->success = $this->handler_->save($args->app);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'save', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('save', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
    protected function process_getById($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_getById_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_getById_result();
        try {
            $result->success = $this->handler_->getById($args->identity);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'getById', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('getById', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
    protected function process_listAll($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_listAll_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_listAll_result();
        try {
            $result->success = $this->handler_->listAll($args->pageable);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'listAll', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('listAll', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
    protected function process_removeById($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_removeById_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_removeById_result();
        try {
            $result->success = $this->handler_->removeById($args->identity);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'removeById', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('removeById', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
    protected function process_updateById($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_updateById_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_updateById_result();
        try {
            $result->success = $this->handler_->updateById($args->identity, $args->app);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'updateById', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('updateById', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
    protected function process_reindexById($seqid, $input, $output)
    {
        $args = new \OpenSearch\Generated\App\AppService_reindexById_args();
        $args->read($input);
        $input->readMessageEnd();
        $result = new \OpenSearch\Generated\App\AppService_reindexById_result();
        try {
            $result->success = $this->handler_->reindexById($args->identity);
        } catch (\OpenSearch\Generated\Common\OpenSearchException $error) {
            $result->error = $error;
        } catch (\OpenSearch\Generated\Common\OpenSearchClientException $e) {
            $result->e = $e;
        }
        $bin_accel = $output instanceof \Thrift\Protocol\TBinaryProtocolAccelerated && function_exists('thrift_protocol_write_binary');
        if ($bin_accel) {
            thrift_protocol_write_binary($output, 'reindexById', \Thrift\Type\TMessageType::REPLY, $result, $seqid, $output->isStrictWrite());
        } else {
            $output->writeMessageBegin('reindexById', \Thrift\Type\TMessageType::REPLY, $seqid);
            $result->write($output);
            $output->writeMessageEnd();
            $output->getTransport()->flush();
        }
    }
}