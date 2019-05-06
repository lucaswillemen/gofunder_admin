<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataproc/v1beta2/clusters.proto

namespace Google\Cloud\Dataproc\V1beta2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Specifies the selection and config of software inside the cluster.
 *
 * Generated from protobuf message <code>google.cloud.dataproc.v1beta2.SoftwareConfig</code>
 */
class SoftwareConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The version of software inside the cluster. It must be one of the
     * supported [Cloud Dataproc
     * Versions](/dataproc/docs/concepts/versioning/dataproc-versions#supported_cloud_dataproc_versions),
     * such as "1.2" (including a subminor version, such as "1.2.29"), or the
     * ["preview"
     * version](/dataproc/docs/concepts/versioning/dataproc-versions#other_versions).
     * If unspecified, it defaults to the latest version.
     *
     * Generated from protobuf field <code>string image_version = 1;</code>
     */
    private $image_version = '';
    /**
     * Optional. The properties to set on daemon config files.
     * Property keys are specified in `prefix:property` format, such as
     * `core:fs.defaultFS`. The following are supported prefixes
     * and their mappings:
     * * capacity-scheduler: `capacity-scheduler.xml`
     * * core:   `core-site.xml`
     * * distcp: `distcp-default.xml`
     * * hdfs:   `hdfs-site.xml`
     * * hive:   `hive-site.xml`
     * * mapred: `mapred-site.xml`
     * * pig:    `pig.properties`
     * * spark:  `spark-defaults.conf`
     * * yarn:   `yarn-site.xml`
     * For more information, see
     * [Cluster properties](/dataproc/docs/concepts/cluster-properties).
     *
     * Generated from protobuf field <code>map<string, string> properties = 2;</code>
     */
    private $properties;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $image_version
     *           Optional. The version of software inside the cluster. It must be one of the
     *           supported [Cloud Dataproc
     *           Versions](/dataproc/docs/concepts/versioning/dataproc-versions#supported_cloud_dataproc_versions),
     *           such as "1.2" (including a subminor version, such as "1.2.29"), or the
     *           ["preview"
     *           version](/dataproc/docs/concepts/versioning/dataproc-versions#other_versions).
     *           If unspecified, it defaults to the latest version.
     *     @type array|\Google\Protobuf\Internal\MapField $properties
     *           Optional. The properties to set on daemon config files.
     *           Property keys are specified in `prefix:property` format, such as
     *           `core:fs.defaultFS`. The following are supported prefixes
     *           and their mappings:
     *           * capacity-scheduler: `capacity-scheduler.xml`
     *           * core:   `core-site.xml`
     *           * distcp: `distcp-default.xml`
     *           * hdfs:   `hdfs-site.xml`
     *           * hive:   `hive-site.xml`
     *           * mapred: `mapred-site.xml`
     *           * pig:    `pig.properties`
     *           * spark:  `spark-defaults.conf`
     *           * yarn:   `yarn-site.xml`
     *           For more information, see
     *           [Cluster properties](/dataproc/docs/concepts/cluster-properties).
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataproc\V1Beta2\Clusters::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The version of software inside the cluster. It must be one of the
     * supported [Cloud Dataproc
     * Versions](/dataproc/docs/concepts/versioning/dataproc-versions#supported_cloud_dataproc_versions),
     * such as "1.2" (including a subminor version, such as "1.2.29"), or the
     * ["preview"
     * version](/dataproc/docs/concepts/versioning/dataproc-versions#other_versions).
     * If unspecified, it defaults to the latest version.
     *
     * Generated from protobuf field <code>string image_version = 1;</code>
     * @return string
     */
    public function getImageVersion()
    {
        return $this->image_version;
    }

    /**
     * Optional. The version of software inside the cluster. It must be one of the
     * supported [Cloud Dataproc
     * Versions](/dataproc/docs/concepts/versioning/dataproc-versions#supported_cloud_dataproc_versions),
     * such as "1.2" (including a subminor version, such as "1.2.29"), or the
     * ["preview"
     * version](/dataproc/docs/concepts/versioning/dataproc-versions#other_versions).
     * If unspecified, it defaults to the latest version.
     *
     * Generated from protobuf field <code>string image_version = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setImageVersion($var)
    {
        GPBUtil::checkString($var, True);
        $this->image_version = $var;

        return $this;
    }

    /**
     * Optional. The properties to set on daemon config files.
     * Property keys are specified in `prefix:property` format, such as
     * `core:fs.defaultFS`. The following are supported prefixes
     * and their mappings:
     * * capacity-scheduler: `capacity-scheduler.xml`
     * * core:   `core-site.xml`
     * * distcp: `distcp-default.xml`
     * * hdfs:   `hdfs-site.xml`
     * * hive:   `hive-site.xml`
     * * mapred: `mapred-site.xml`
     * * pig:    `pig.properties`
     * * spark:  `spark-defaults.conf`
     * * yarn:   `yarn-site.xml`
     * For more information, see
     * [Cluster properties](/dataproc/docs/concepts/cluster-properties).
     *
     * Generated from protobuf field <code>map<string, string> properties = 2;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Optional. The properties to set on daemon config files.
     * Property keys are specified in `prefix:property` format, such as
     * `core:fs.defaultFS`. The following are supported prefixes
     * and their mappings:
     * * capacity-scheduler: `capacity-scheduler.xml`
     * * core:   `core-site.xml`
     * * distcp: `distcp-default.xml`
     * * hdfs:   `hdfs-site.xml`
     * * hive:   `hive-site.xml`
     * * mapred: `mapred-site.xml`
     * * pig:    `pig.properties`
     * * spark:  `spark-defaults.conf`
     * * yarn:   `yarn-site.xml`
     * For more information, see
     * [Cluster properties](/dataproc/docs/concepts/cluster-properties).
     *
     * Generated from protobuf field <code>map<string, string> properties = 2;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setProperties($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->properties = $arr;

        return $this;
    }

}

