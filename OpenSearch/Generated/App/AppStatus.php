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
final class AppStatus
{
    const AVAILABLE = 1;
    const PAUSE = 5;
    const FORBID = 6;
    const UNOPEN = 7;
    const CREATING = 8;
    const FAILED = 9;
    public static $__names = array(1 => 'AVAILABLE', 5 => 'PAUSE', 6 => 'FORBID', 7 => 'UNOPEN', 8 => 'CREATING', 9 => 'FAILED');
}