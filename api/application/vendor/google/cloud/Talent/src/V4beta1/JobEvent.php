<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/talent/v4beta1/event.proto

namespace Google\Cloud\Talent\V4beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An event issued when a job seeker interacts with the application that
 * implements Cloud Talent Solution.
 *
 * Generated from protobuf message <code>google.cloud.talent.v4beta1.JobEvent</code>
 */
class JobEvent extends \Google\Protobuf\Internal\Message
{
    /**
     * Required.
     * The type of the event (see
     * [JobEventType][google.cloud.talent.v4beta1.JobEvent.JobEventType]).
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.JobEvent.JobEventType type = 1;</code>
     */
    private $type = 0;
    /**
     * Required.
     * The [job name(s)][google.cloud.talent.v4beta1.Job.name] associated with
     * this event. For example, if this is an
     * [impression][google.cloud.talent.v4beta1.JobEvent.JobEventType.IMPRESSION]
     * event, this field contains the identifiers of all jobs shown to the job
     * seeker. If this was a
     * [view][google.cloud.talent.v4beta1.JobEvent.JobEventType.VIEW] event, this
     * field contains the identifier of the viewed job.
     *
     * Generated from protobuf field <code>repeated string jobs = 2;</code>
     */
    private $jobs;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type
     *           Required.
     *           The type of the event (see
     *           [JobEventType][google.cloud.talent.v4beta1.JobEvent.JobEventType]).
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $jobs
     *           Required.
     *           The [job name(s)][google.cloud.talent.v4beta1.Job.name] associated with
     *           this event. For example, if this is an
     *           [impression][google.cloud.talent.v4beta1.JobEvent.JobEventType.IMPRESSION]
     *           event, this field contains the identifiers of all jobs shown to the job
     *           seeker. If this was a
     *           [view][google.cloud.talent.v4beta1.JobEvent.JobEventType.VIEW] event, this
     *           field contains the identifier of the viewed job.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Talent\V4Beta1\Event::initOnce();
        parent::__construct($data);
    }

    /**
     * Required.
     * The type of the event (see
     * [JobEventType][google.cloud.talent.v4beta1.JobEvent.JobEventType]).
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.JobEvent.JobEventType type = 1;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Required.
     * The type of the event (see
     * [JobEventType][google.cloud.talent.v4beta1.JobEvent.JobEventType]).
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.JobEvent.JobEventType type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Talent\V4beta1\JobEvent_JobEventType::class);
        $this->type = $var;

        return $this;
    }

    /**
     * Required.
     * The [job name(s)][google.cloud.talent.v4beta1.Job.name] associated with
     * this event. For example, if this is an
     * [impression][google.cloud.talent.v4beta1.JobEvent.JobEventType.IMPRESSION]
     * event, this field contains the identifiers of all jobs shown to the job
     * seeker. If this was a
     * [view][google.cloud.talent.v4beta1.JobEvent.JobEventType.VIEW] event, this
     * field contains the identifier of the viewed job.
     *
     * Generated from protobuf field <code>repeated string jobs = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Required.
     * The [job name(s)][google.cloud.talent.v4beta1.Job.name] associated with
     * this event. For example, if this is an
     * [impression][google.cloud.talent.v4beta1.JobEvent.JobEventType.IMPRESSION]
     * event, this field contains the identifiers of all jobs shown to the job
     * seeker. If this was a
     * [view][google.cloud.talent.v4beta1.JobEvent.JobEventType.VIEW] event, this
     * field contains the identifier of the viewed job.
     *
     * Generated from protobuf field <code>repeated string jobs = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setJobs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->jobs = $arr;

        return $this;
    }

}

