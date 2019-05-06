<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/scheduler/v1beta1/cloudscheduler.proto

namespace Google\Cloud\Scheduler\V1beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for listing jobs using
 * [ListJobs][google.cloud.scheduler.v1beta1.CloudScheduler.ListJobs].
 *
 * Generated from protobuf message <code>google.cloud.scheduler.v1beta1.ListJobsRequest</code>
 */
class ListJobsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required.
     * The location name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID`.
     *
     * Generated from protobuf field <code>string parent = 1;</code>
     */
    private $parent = '';
    /**
     * Requested page size.
     * The maximum page size is 500. If unspecified, the page size will
     * be the maximum. Fewer jobs than requested might be returned,
     * even if more jobs exist; use next_page_token to determine if more
     * jobs exist.
     *
     * Generated from protobuf field <code>int32 page_size = 5;</code>
     */
    private $page_size = 0;
    /**
     * A token identifying a page of results the server will return. To
     * request the first page results, page_token must be empty. To
     * request the next page of results, page_token must be the value of
     * [next_page_token][google.cloud.scheduler.v1beta1.ListJobsResponse.next_page_token]
     * returned from the previous call to
     * [ListJobs][google.cloud.scheduler.v1beta1.CloudScheduler.ListJobs]. It is
     * an error to switch the value of
     * [filter][google.cloud.scheduler.v1beta1.ListJobsRequest.filter] or
     * [order_by][google.cloud.scheduler.v1beta1.ListJobsRequest.order_by] while
     * iterating through pages.
     *
     * Generated from protobuf field <code>string page_token = 6;</code>
     */
    private $page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $parent
     *           Required.
     *           The location name. For example:
     *           `projects/PROJECT_ID/locations/LOCATION_ID`.
     *     @type int $page_size
     *           Requested page size.
     *           The maximum page size is 500. If unspecified, the page size will
     *           be the maximum. Fewer jobs than requested might be returned,
     *           even if more jobs exist; use next_page_token to determine if more
     *           jobs exist.
     *     @type string $page_token
     *           A token identifying a page of results the server will return. To
     *           request the first page results, page_token must be empty. To
     *           request the next page of results, page_token must be the value of
     *           [next_page_token][google.cloud.scheduler.v1beta1.ListJobsResponse.next_page_token]
     *           returned from the previous call to
     *           [ListJobs][google.cloud.scheduler.v1beta1.CloudScheduler.ListJobs]. It is
     *           an error to switch the value of
     *           [filter][google.cloud.scheduler.v1beta1.ListJobsRequest.filter] or
     *           [order_by][google.cloud.scheduler.v1beta1.ListJobsRequest.order_by] while
     *           iterating through pages.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Scheduler\V1Beta1\Cloudscheduler::initOnce();
        parent::__construct($data);
    }

    /**
     * Required.
     * The location name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID`.
     *
     * Generated from protobuf field <code>string parent = 1;</code>
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Required.
     * The location name. For example:
     * `projects/PROJECT_ID/locations/LOCATION_ID`.
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
     * Requested page size.
     * The maximum page size is 500. If unspecified, the page size will
     * be the maximum. Fewer jobs than requested might be returned,
     * even if more jobs exist; use next_page_token to determine if more
     * jobs exist.
     *
     * Generated from protobuf field <code>int32 page_size = 5;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     * Requested page size.
     * The maximum page size is 500. If unspecified, the page size will
     * be the maximum. Fewer jobs than requested might be returned,
     * even if more jobs exist; use next_page_token to determine if more
     * jobs exist.
     *
     * Generated from protobuf field <code>int32 page_size = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

    /**
     * A token identifying a page of results the server will return. To
     * request the first page results, page_token must be empty. To
     * request the next page of results, page_token must be the value of
     * [next_page_token][google.cloud.scheduler.v1beta1.ListJobsResponse.next_page_token]
     * returned from the previous call to
     * [ListJobs][google.cloud.scheduler.v1beta1.CloudScheduler.ListJobs]. It is
     * an error to switch the value of
     * [filter][google.cloud.scheduler.v1beta1.ListJobsRequest.filter] or
     * [order_by][google.cloud.scheduler.v1beta1.ListJobsRequest.order_by] while
     * iterating through pages.
     *
     * Generated from protobuf field <code>string page_token = 6;</code>
     * @return string
     */
    public function getPageToken()
    {
        return $this->page_token;
    }

    /**
     * A token identifying a page of results the server will return. To
     * request the first page results, page_token must be empty. To
     * request the next page of results, page_token must be the value of
     * [next_page_token][google.cloud.scheduler.v1beta1.ListJobsResponse.next_page_token]
     * returned from the previous call to
     * [ListJobs][google.cloud.scheduler.v1beta1.CloudScheduler.ListJobs]. It is
     * an error to switch the value of
     * [filter][google.cloud.scheduler.v1beta1.ListJobsRequest.filter] or
     * [order_by][google.cloud.scheduler.v1beta1.ListJobsRequest.order_by] while
     * iterating through pages.
     *
     * Generated from protobuf field <code>string page_token = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->page_token = $var;

        return $this;
    }

}

