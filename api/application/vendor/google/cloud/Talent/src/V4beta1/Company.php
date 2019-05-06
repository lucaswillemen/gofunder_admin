<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/talent/v4beta1/company.proto

namespace Google\Cloud\Talent\V4beta1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A Company resource represents a company in the service. A company is the
 * entity that owns job postings, that is, the hiring entity responsible for
 * employing applicants for the job position.
 *
 * Generated from protobuf message <code>google.cloud.talent.v4beta1.Company</code>
 */
class Company extends \Google\Protobuf\Internal\Message
{
    /**
     * Required during company update.
     * The resource name for a company. This is generated by the service when a
     * company is created.
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}", for
     * example, "projects/api-test-project/tenants/foo/companies/bar".
     * Tenant id is optional and the default tenant is used if unspecified, for
     * example, "projects/api-test-project/companies/bar".
     *
     * Generated from protobuf field <code>string name = 1;</code>
     */
    private $name = '';
    /**
     * Required.
     * The display name of the company, for example, "Google, LLC".
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     */
    private $display_name = '';
    /**
     * Required.
     * Client side company identifier, used to uniquely identify the
     * company.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string external_id = 3;</code>
     */
    private $external_id = '';
    /**
     * Optional.
     * The employer's company size.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.CompanySize size = 4;</code>
     */
    private $size = 0;
    /**
     * Optional.
     * The street address of the company's main headquarters, which may be
     * different from the job location. The service attempts
     * to geolocate the provided address, and populates a more specific
     * location wherever possible in
     * [DerivedInfo.headquarters_location][google.cloud.talent.v4beta1.Company.DerivedInfo.headquarters_location].
     *
     * Generated from protobuf field <code>string headquarters_address = 5;</code>
     */
    private $headquarters_address = '';
    /**
     * Optional.
     * Set to true if it is the hiring agency that post jobs for other
     * employers.
     * Defaults to false if not provided.
     *
     * Generated from protobuf field <code>bool hiring_agency = 6;</code>
     */
    private $hiring_agency = false;
    /**
     * Optional.
     * Equal Employment Opportunity legal disclaimer text to be
     * associated with all jobs, and typically to be displayed in all
     * roles.
     * The maximum number of allowed characters is 500.
     *
     * Generated from protobuf field <code>string eeo_text = 7;</code>
     */
    private $eeo_text = '';
    /**
     * Optional.
     * The URI representing the company's primary web site or home page,
     * for example, "https://www.google.com".
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string website_uri = 8;</code>
     */
    private $website_uri = '';
    /**
     * Optional.
     * The URI to employer's career site or careers page on the employer's web
     * site, for example, "https://careers.google.com".
     *
     * Generated from protobuf field <code>string career_site_uri = 9;</code>
     */
    private $career_site_uri = '';
    /**
     * Optional.
     * A URI that hosts the employer's company logo.
     *
     * Generated from protobuf field <code>string image_uri = 10;</code>
     */
    private $image_uri = '';
    /**
     * Optional.
     * A list of keys of filterable
     * [Job.custom_attributes][google.cloud.talent.v4beta1.Job.custom_attributes],
     * whose corresponding `string_values` are used in keyword searches. Jobs with
     * `string_values` under these specified field keys are returned if any
     * of the values match the search keyword. Custom field values with
     * parenthesis, brackets and special symbols are not searchable as-is,
     * and those keyword queries must be surrounded by quotes.
     *
     * Generated from protobuf field <code>repeated string keyword_searchable_job_custom_attributes = 11;</code>
     */
    private $keyword_searchable_job_custom_attributes;
    /**
     * Output only. Derived details about the company.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.Company.DerivedInfo derived_info = 12;</code>
     */
    private $derived_info = null;
    /**
     * Output only. Indicates whether a company is flagged to be suspended from
     * public availability by the service when job content appears suspicious,
     * abusive, or spammy.
     *
     * Generated from protobuf field <code>bool suspended = 13;</code>
     */
    private $suspended = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required during company update.
     *           The resource name for a company. This is generated by the service when a
     *           company is created.
     *           The format is
     *           "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}", for
     *           example, "projects/api-test-project/tenants/foo/companies/bar".
     *           Tenant id is optional and the default tenant is used if unspecified, for
     *           example, "projects/api-test-project/companies/bar".
     *     @type string $display_name
     *           Required.
     *           The display name of the company, for example, "Google, LLC".
     *     @type string $external_id
     *           Required.
     *           Client side company identifier, used to uniquely identify the
     *           company.
     *           The maximum number of allowed characters is 255.
     *     @type int $size
     *           Optional.
     *           The employer's company size.
     *     @type string $headquarters_address
     *           Optional.
     *           The street address of the company's main headquarters, which may be
     *           different from the job location. The service attempts
     *           to geolocate the provided address, and populates a more specific
     *           location wherever possible in
     *           [DerivedInfo.headquarters_location][google.cloud.talent.v4beta1.Company.DerivedInfo.headquarters_location].
     *     @type bool $hiring_agency
     *           Optional.
     *           Set to true if it is the hiring agency that post jobs for other
     *           employers.
     *           Defaults to false if not provided.
     *     @type string $eeo_text
     *           Optional.
     *           Equal Employment Opportunity legal disclaimer text to be
     *           associated with all jobs, and typically to be displayed in all
     *           roles.
     *           The maximum number of allowed characters is 500.
     *     @type string $website_uri
     *           Optional.
     *           The URI representing the company's primary web site or home page,
     *           for example, "https://www.google.com".
     *           The maximum number of allowed characters is 255.
     *     @type string $career_site_uri
     *           Optional.
     *           The URI to employer's career site or careers page on the employer's web
     *           site, for example, "https://careers.google.com".
     *     @type string $image_uri
     *           Optional.
     *           A URI that hosts the employer's company logo.
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $keyword_searchable_job_custom_attributes
     *           Optional.
     *           A list of keys of filterable
     *           [Job.custom_attributes][google.cloud.talent.v4beta1.Job.custom_attributes],
     *           whose corresponding `string_values` are used in keyword searches. Jobs with
     *           `string_values` under these specified field keys are returned if any
     *           of the values match the search keyword. Custom field values with
     *           parenthesis, brackets and special symbols are not searchable as-is,
     *           and those keyword queries must be surrounded by quotes.
     *     @type \Google\Cloud\Talent\V4beta1\Company\DerivedInfo $derived_info
     *           Output only. Derived details about the company.
     *     @type bool $suspended
     *           Output only. Indicates whether a company is flagged to be suspended from
     *           public availability by the service when job content appears suspicious,
     *           abusive, or spammy.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Talent\V4Beta1\Company::initOnce();
        parent::__construct($data);
    }

    /**
     * Required during company update.
     * The resource name for a company. This is generated by the service when a
     * company is created.
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}", for
     * example, "projects/api-test-project/tenants/foo/companies/bar".
     * Tenant id is optional and the default tenant is used if unspecified, for
     * example, "projects/api-test-project/companies/bar".
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required during company update.
     * The resource name for a company. This is generated by the service when a
     * company is created.
     * The format is
     * "projects/{project_id}/tenants/{tenant_id}/companies/{company_id}", for
     * example, "projects/api-test-project/tenants/foo/companies/bar".
     * Tenant id is optional and the default tenant is used if unspecified, for
     * example, "projects/api-test-project/companies/bar".
     *
     * Generated from protobuf field <code>string name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Required.
     * The display name of the company, for example, "Google, LLC".
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Required.
     * The display name of the company, for example, "Google, LLC".
     *
     * Generated from protobuf field <code>string display_name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayName($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_name = $var;

        return $this;
    }

    /**
     * Required.
     * Client side company identifier, used to uniquely identify the
     * company.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string external_id = 3;</code>
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }

    /**
     * Required.
     * Client side company identifier, used to uniquely identify the
     * company.
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string external_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setExternalId($var)
    {
        GPBUtil::checkString($var, True);
        $this->external_id = $var;

        return $this;
    }

    /**
     * Optional.
     * The employer's company size.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.CompanySize size = 4;</code>
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Optional.
     * The employer's company size.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.CompanySize size = 4;</code>
     * @param int $var
     * @return $this
     */
    public function setSize($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Talent\V4beta1\CompanySize::class);
        $this->size = $var;

        return $this;
    }

    /**
     * Optional.
     * The street address of the company's main headquarters, which may be
     * different from the job location. The service attempts
     * to geolocate the provided address, and populates a more specific
     * location wherever possible in
     * [DerivedInfo.headquarters_location][google.cloud.talent.v4beta1.Company.DerivedInfo.headquarters_location].
     *
     * Generated from protobuf field <code>string headquarters_address = 5;</code>
     * @return string
     */
    public function getHeadquartersAddress()
    {
        return $this->headquarters_address;
    }

    /**
     * Optional.
     * The street address of the company's main headquarters, which may be
     * different from the job location. The service attempts
     * to geolocate the provided address, and populates a more specific
     * location wherever possible in
     * [DerivedInfo.headquarters_location][google.cloud.talent.v4beta1.Company.DerivedInfo.headquarters_location].
     *
     * Generated from protobuf field <code>string headquarters_address = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setHeadquartersAddress($var)
    {
        GPBUtil::checkString($var, True);
        $this->headquarters_address = $var;

        return $this;
    }

    /**
     * Optional.
     * Set to true if it is the hiring agency that post jobs for other
     * employers.
     * Defaults to false if not provided.
     *
     * Generated from protobuf field <code>bool hiring_agency = 6;</code>
     * @return bool
     */
    public function getHiringAgency()
    {
        return $this->hiring_agency;
    }

    /**
     * Optional.
     * Set to true if it is the hiring agency that post jobs for other
     * employers.
     * Defaults to false if not provided.
     *
     * Generated from protobuf field <code>bool hiring_agency = 6;</code>
     * @param bool $var
     * @return $this
     */
    public function setHiringAgency($var)
    {
        GPBUtil::checkBool($var);
        $this->hiring_agency = $var;

        return $this;
    }

    /**
     * Optional.
     * Equal Employment Opportunity legal disclaimer text to be
     * associated with all jobs, and typically to be displayed in all
     * roles.
     * The maximum number of allowed characters is 500.
     *
     * Generated from protobuf field <code>string eeo_text = 7;</code>
     * @return string
     */
    public function getEeoText()
    {
        return $this->eeo_text;
    }

    /**
     * Optional.
     * Equal Employment Opportunity legal disclaimer text to be
     * associated with all jobs, and typically to be displayed in all
     * roles.
     * The maximum number of allowed characters is 500.
     *
     * Generated from protobuf field <code>string eeo_text = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setEeoText($var)
    {
        GPBUtil::checkString($var, True);
        $this->eeo_text = $var;

        return $this;
    }

    /**
     * Optional.
     * The URI representing the company's primary web site or home page,
     * for example, "https://www.google.com".
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string website_uri = 8;</code>
     * @return string
     */
    public function getWebsiteUri()
    {
        return $this->website_uri;
    }

    /**
     * Optional.
     * The URI representing the company's primary web site or home page,
     * for example, "https://www.google.com".
     * The maximum number of allowed characters is 255.
     *
     * Generated from protobuf field <code>string website_uri = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setWebsiteUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->website_uri = $var;

        return $this;
    }

    /**
     * Optional.
     * The URI to employer's career site or careers page on the employer's web
     * site, for example, "https://careers.google.com".
     *
     * Generated from protobuf field <code>string career_site_uri = 9;</code>
     * @return string
     */
    public function getCareerSiteUri()
    {
        return $this->career_site_uri;
    }

    /**
     * Optional.
     * The URI to employer's career site or careers page on the employer's web
     * site, for example, "https://careers.google.com".
     *
     * Generated from protobuf field <code>string career_site_uri = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setCareerSiteUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->career_site_uri = $var;

        return $this;
    }

    /**
     * Optional.
     * A URI that hosts the employer's company logo.
     *
     * Generated from protobuf field <code>string image_uri = 10;</code>
     * @return string
     */
    public function getImageUri()
    {
        return $this->image_uri;
    }

    /**
     * Optional.
     * A URI that hosts the employer's company logo.
     *
     * Generated from protobuf field <code>string image_uri = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setImageUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->image_uri = $var;

        return $this;
    }

    /**
     * Optional.
     * A list of keys of filterable
     * [Job.custom_attributes][google.cloud.talent.v4beta1.Job.custom_attributes],
     * whose corresponding `string_values` are used in keyword searches. Jobs with
     * `string_values` under these specified field keys are returned if any
     * of the values match the search keyword. Custom field values with
     * parenthesis, brackets and special symbols are not searchable as-is,
     * and those keyword queries must be surrounded by quotes.
     *
     * Generated from protobuf field <code>repeated string keyword_searchable_job_custom_attributes = 11;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getKeywordSearchableJobCustomAttributes()
    {
        return $this->keyword_searchable_job_custom_attributes;
    }

    /**
     * Optional.
     * A list of keys of filterable
     * [Job.custom_attributes][google.cloud.talent.v4beta1.Job.custom_attributes],
     * whose corresponding `string_values` are used in keyword searches. Jobs with
     * `string_values` under these specified field keys are returned if any
     * of the values match the search keyword. Custom field values with
     * parenthesis, brackets and special symbols are not searchable as-is,
     * and those keyword queries must be surrounded by quotes.
     *
     * Generated from protobuf field <code>repeated string keyword_searchable_job_custom_attributes = 11;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setKeywordSearchableJobCustomAttributes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->keyword_searchable_job_custom_attributes = $arr;

        return $this;
    }

    /**
     * Output only. Derived details about the company.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.Company.DerivedInfo derived_info = 12;</code>
     * @return \Google\Cloud\Talent\V4beta1\Company\DerivedInfo
     */
    public function getDerivedInfo()
    {
        return $this->derived_info;
    }

    /**
     * Output only. Derived details about the company.
     *
     * Generated from protobuf field <code>.google.cloud.talent.v4beta1.Company.DerivedInfo derived_info = 12;</code>
     * @param \Google\Cloud\Talent\V4beta1\Company\DerivedInfo $var
     * @return $this
     */
    public function setDerivedInfo($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Talent\V4beta1\Company_DerivedInfo::class);
        $this->derived_info = $var;

        return $this;
    }

    /**
     * Output only. Indicates whether a company is flagged to be suspended from
     * public availability by the service when job content appears suspicious,
     * abusive, or spammy.
     *
     * Generated from protobuf field <code>bool suspended = 13;</code>
     * @return bool
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * Output only. Indicates whether a company is flagged to be suspended from
     * public availability by the service when job content appears suspicious,
     * abusive, or spammy.
     *
     * Generated from protobuf field <code>bool suspended = 13;</code>
     * @param bool $var
     * @return $this
     */
    public function setSuspended($var)
    {
        GPBUtil::checkBool($var);
        $this->suspended = $var;

        return $this;
    }

}

