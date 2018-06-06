<?php
/**
 * Copyright 2018 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Ads\GoogleAds\Examples\BasicOperations;

require __DIR__ . '/../../vendor/autoload.php';

use GetOpt\GetOpt;
use Google\Ads\GoogleAds\Examples\Utils\ArgumentNames;
use Google\Ads\GoogleAds\Examples\Utils\ArgumentParser;
use Google\Ads\GoogleAds\Lib\GoogleAdsClient;
use Google\Ads\GoogleAds\Lib\GoogleAdsClientBuilder;
use Google\Ads\GoogleAds\Lib\GoogleAdsException;
use Google\Ads\GoogleAds\Lib\OAuth2TokenBuilder;
use Google\Ads\GoogleAds\Util\FieldMasks;
use Google\Ads\GoogleAds\Util\ResourceNames;
use Google\Ads\GoogleAds\V0\Enums\AdGroupStatusEnum_AdGroupStatus;
use Google\Ads\GoogleAds\V0\Errors\GoogleAdsError;
use Google\Ads\GoogleAds\V0\Resources\AdGroup;
use Google\Ads\GoogleAds\V0\Services\AdGroupOperation;
use Google\ApiCore\ApiException;
use Google\Protobuf\Int64Value;

/**
 * This example updates the CPC bid and status for a given ad group. To get ad groups, run
 * GetAdGroups.php.
 */
class UpdateAdGroup
{
    const CUSTOMER_ID = 'INSERT_CUSTOMER_ID_HERE';
    const AD_GROUP_ID = 'INSERT_AD_GROUP_ID_HERE';
    const CPC_BID_MICRO_AMOUNT = 'INSERT_CPC_BID_MICRO_AMOUNT_HERE';

    public static function main()
    {
        // Either pass the required parameters for this example on the command line, or insert them
        // into the constants above.
        $options = ArgumentParser::parseCommandArguments([
            ArgumentNames::CUSTOMER_ID => GetOpt::REQUIRED_ARGUMENT,
            ArgumentNames::AD_GROUP_ID => GetOpt::REQUIRED_ARGUMENT,
            ArgumentNames::CPC_BID_MICRO_AMOUNT => GetOpt::REQUIRED_ARGUMENT
        ]);

        // Generate a refreshable OAuth2 credential for authentication.
        $oAuth2Credential = (new OAuth2TokenBuilder())->fromFile()->build();

        // Construct a Google Ads client configured from a properties file and the
        // OAuth2 credentials above.
        $googleAdsClient = (new GoogleAdsClientBuilder())->fromFile()
            ->withOAuth2Credential($oAuth2Credential)
            ->build();

        try {
            self::runExample(
                $googleAdsClient,
                $options[ArgumentNames::CUSTOMER_ID] ?: self::CUSTOMER_ID,
                $options[ArgumentNames::AD_GROUP_ID] ?: self::AD_GROUP_ID,
                $options[ArgumentNames::CPC_BID_MICRO_AMOUNT] ?: self::CPC_BID_MICRO_AMOUNT
            );
        } catch (GoogleAdsException $googleAdsException) {
            printf(
                "Request with ID '%s' has failed.%sGoogle Ads failure details:%s",
                $googleAdsException->getRequestId(),
                PHP_EOL,
                PHP_EOL
            );
            foreach ($googleAdsException->getGoogleAdsFailure()->getErrors() as $error) {
                /** @var GoogleAdsError $error */
                printf(
                    "\t%s: %s%s",
                    $error->getErrorCode()->getErrorCode(),
                    $error->getMessage(),
                    PHP_EOL
                );
            }
        } catch (ApiException $apiException) {
            printf(
                "ApiException was thrown with message '%s'.%s",
                $apiException->getMessage(),
                PHP_EOL
            );
        }
    }

    /**
     * Runs the example.
     *
     * @param GoogleAdsClient $googleAdsClient the Google Ads API client
     * @param int $customerId the client customer ID without hyphens
     * @param int $adGroupId the ID of ad group to update
     * @param int $cpcBidMicroAmount the bid amount in micros to use for the ad group bid
     */
    public static function runExample(
        GoogleAdsClient $googleAdsClient,
        $customerId,
        $adGroupId,
        $cpcBidMicroAmount
    ) {
        // Creates ad group resource name.
        $adGroupResourceName = ResourceNames::forAdGroup($customerId, $adGroupId);

        // Creates an ad group object with the specified resource name and other changes.
        $adGroup = new AdGroup();
        $adGroup->setResourceName($adGroupResourceName);
        $wrappedCpcBidMicroAmount = new Int64Value();
        $wrappedCpcBidMicroAmount->setValue($cpcBidMicroAmount);
        $adGroup->setCpcBidMicros($wrappedCpcBidMicroAmount);
        $adGroup->setStatus(AdGroupStatusEnum_AdGroupStatus::PAUSED);

        // Constructs an operation that will update the ad group with the specified resource name,
        // using the FieldMasks utility to derive the update mask. This mask tells the Google Ads
        // API which attributes of the ad group you want to change.
        $adGroupOperation = new AdGroupOperation();
        $adGroupOperation->setUpdate($adGroup);
        $adGroupOperation->setUpdateMask(FieldMasks::allSetFieldsOf($adGroup));

        // Issues a mutate request to update the ad group.
        $adGroupServiceClient = $googleAdsClient->getAdGroupServiceClient();
        $response = $adGroupServiceClient->mutateAdGroups(
            $customerId,
            [$adGroupOperation]
        );

        // Prints the resource name of the updated ad group.
        /** @var AdGroup $updatedAdGroup */
        $updatedAdGroup = $response->getResults()[0];
        printf(
            "Updated ad group with resource name: '%s'%s",
            $updatedAdGroup->getResourceName(),
            PHP_EOL
        );
    }
}

UpdateAdGroup::main();