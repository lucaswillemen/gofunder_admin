<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/kms/v1/service.proto

namespace Google\Cloud\Kms\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [KeyManagementService.CreateCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.CreateCryptoKeyVersion].
 *
 * Generated from protobuf message <code>google.cloud.kms.v1.CreateCryptoKeyVersionRequest</code>
 */
class CreateCryptoKeyVersionRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The [name][google.cloud.kms.v1.CryptoKey.name] of the
     * [CryptoKey][google.cloud.kms.v1.CryptoKey] associated with the
     * [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Generated from protobuf field <code>string parent = 1;</code>
     */
    private $parent = '';
    /**
     * A [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with initial
     * field values.
     *
     * Generated from protobuf field <code>.google.cloud.kms.v1.CryptoKeyVersion crypto_key_version = 2;</code>
     */
    private $crypto_key_version = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required. The [name][google.cloud.kms.v1.CryptoKey.name] of the
     *           [CryptoKey][google.cloud.kms.v1.CryptoKey] associated with the
     *           [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     *     @type \Google\Cloud\Kms\V1\CryptoKeyVersion $crypto_key_version
     *           A [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with initial
     *           field values.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Kms\V1\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The [name][google.cloud.kms.v1.CryptoKey.name] of the
     * [CryptoKey][google.cloud.kms.v1.CryptoKey] associated with the
     * [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Generated from protobuf field <code>string parent = 1;</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required. The [name][google.cloud.kms.v1.CryptoKey.name] of the
     * [CryptoKey][google.cloud.kms.v1.CryptoKey] associated with the
     * [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Generated from protobuf field <code>string parent = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setParent($var)
    {
        GPBUtil::checkString($var, True);
        $this->parent = $var;

        return $this;
    }

    /**
     * A [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with initial
     * field values.
     *
     * Generated from protobuf field <code>.google.cloud.kms.v1.CryptoKeyVersion crypto_key_version = 2;</code>
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     */
    public function getCryptoKeyVersion()
    {
        return $this->crypto_key_version;
    }

    /**
     * A [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with initial
     * field values.
     *
     * Generated from protobuf field <code>.google.cloud.kms.v1.CryptoKeyVersion crypto_key_version = 2;</code>
     * @param \Google\Cloud\Kms\V1\CryptoKeyVersion $var
     * @return $this
     */
    public function setCryptoKeyVersion($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Kms\V1\CryptoKeyVersion::class);
        $this->crypto_key_version = $var;

        return $this;
    }

}

