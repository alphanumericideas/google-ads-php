<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v2/resources/media_file.proto

namespace Google\Ads\GoogleAds\V2\Resources;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Encapsulates an Audio.
 *
 * Generated from protobuf message <code>google.ads.googleads.v2.resources.MediaAudio</code>
 */
final class MediaAudio extends \Google\Protobuf\Internal\Message
{
    /**
     * The duration of the Audio in milliseconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Int64Value ad_duration_millis = 1;</code>
     */
    private $ad_duration_millis = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Int64Value $ad_duration_millis
     *           The duration of the Audio in milliseconds.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V2\Resources\MediaFile::initOnce();
        parent::__construct($data);
    }

    /**
     * The duration of the Audio in milliseconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Int64Value ad_duration_millis = 1;</code>
     * @return \Google\Protobuf\Int64Value
     */
    public function getAdDurationMillis()
    {
        return $this->ad_duration_millis;
    }

    /**
     * Returns the unboxed value from <code>getAdDurationMillis()</code>

     * The duration of the Audio in milliseconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Int64Value ad_duration_millis = 1;</code>
     * @return int|string|null
     */
    public function getAdDurationMillisUnwrapped()
    {
        $wrapper = $this->getAdDurationMillis();
        return is_null($wrapper) ? null : $wrapper->getValue();
    }

    /**
     * The duration of the Audio in milliseconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Int64Value ad_duration_millis = 1;</code>
     * @param \Google\Protobuf\Int64Value $var
     * @return $this
     */
    public function setAdDurationMillis($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Int64Value::class);
        $this->ad_duration_millis = $var;

        return $this;
    }

    /**
     * Sets the field by wrapping a primitive type in a Google\Protobuf\Int64Value object.

     * The duration of the Audio in milliseconds.
     *
     * Generated from protobuf field <code>.google.protobuf.Int64Value ad_duration_millis = 1;</code>
     * @param int|string|null $var
     * @return $this
     */
    public function setAdDurationMillisUnwrapped($var)
    {
        $wrappedVar = is_null($var) ? null : new \Google\Protobuf\Int64Value(['value' => $var]);
        return $this->setAdDurationMillis($wrappedVar);
    }

}
