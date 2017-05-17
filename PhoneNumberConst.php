<?php

class PhoneNumberConst {

    /* Phone number formats.
    --------------------------------------------------------------------------*/

    /**
     * The E164 format.
     *
     * This consists of a + sign followed by a series of digits,
     * comprising the country code and national number.
     *
     * Example: `+41446681800`.
     */
    const E164 = 0;

    /**
     * The international format.
     *
     * This is similar to the E164 format, with extra formatting.
     * This format is consistent with the definition in ITU-T Recommendation E123.
     *
     * Example: `+41 44 668 1800`.
     */
    const international = 1;

    /**
     * The national format.
     *
     * This is the number as it would be composed from within the country, with formatting.
     * This format is consistent with the definition in ITU-T Recommendation E123.
     *
     * Example: `044 668 1800`.
     */
    const national = 2;

    /**
     * The RFC 3966 format.
     *
     * This format outputs a `tel:` URI that can be used as an anchor link to start a VOIP call from a web page.
     *
     * Example: `tel:+41-44-668-1800`.
     */
    const RFC3966 = 3;


    /* Phone number types.
    --------------------------------------------------------------------------*/

    /**
     * Fixed line number.
     */
    const fixedLine = 0;

    /**
     * Mobile number.
     */
    const mobile = 1;

    /**
     * Fixed line or mobile number.
     *
     * In some regions (e.g. the USA), it is impossible to distinguish between fixed-line and
     * mobile numbers by looking at the phone number itself.
     */
    const fixedLineOrMobile = 2;

    /**
     * Freephone number.
     */
    const tollFree = 3;

    /**
     * Premium rate number.
     */
    const premiumRate = 4;

    /**
     * Shared cost number.
     *
     * The cost of this call is shared between the caller and the recipient, and is hence typically
     * less than PREMIUM_RATE calls.
     *
     * @see http://en.wikipedia.org/wiki/Shared_Cost_Service
     */
    const sharedCost = 5;

    /**
     * Voice over IP number.
     *
     * This includes TSoIP (Telephony Service over IP).
     */
    const VOIP = 6;

    /**
     * Personal number.
     *
     * A personal number is associated with a particular person, and may be routed to either a
     * MOBILE or FIXED_LINE number.
     *
     * @see http://en.wikipedia.org/wiki/Personal_Numbers
     */
    const personalNumber = 7;

    /**
     * Pager number.
     */
    const pager = 8;

    /**
     * Universal Access Number or Company Number.
     *
     * The number may be further routed to specific offices, but allows one number to be used for a company.
     */
    const UAN = 9;

    /**
     * Unknown number type.
     *
     * A phone number is of type UNKNOWN when it does not fit any of the known patterns
     * for a specific region.
     */
    const unknown = 10;

    /**
     * Emergency number.
     */
    const emergency = 27;

    /**
     * Voicemail number.
     */
    const voicemail = 28;

    /**
     * Short code number.
     */
    const shortCode = 29;

    /**
     * Standard rate number.
     */
    const standardRate = 30;

    /**
     * Get array of available type titles
     *
     * @return array
     */
    public static function getTypeTitles() {
        return [
            self::fixedLine         => __('Fixed line'),
            self::mobile            => __('Mobile'),
            self::fixedLineOrMobile => __('Fixed line or mobile'),
            self::tollFree          => __('Toll free'),
            self::premiumRate       => __('Premium rate'),
            self::sharedCost        => __('Shared cost'),
            self::VOIP              => __('VOIP'),
            self::personalNumber    => __('Personal number'),
            self::pager             => __('Pager'),
            self::UAN               => __('UAN'),
            self::unknown           => __('Unknown'),
            self::emergency         => __('Emergency'),
            self::voicemail         => __('Voice mail'),
            self::shortCode         => __('Short code'),
            self::standardRate      => __('Standard rate'),
        ];
    }

    /**
     * Get array of region code titles
     *
     * @return array
     * @todo add region codes titles (currently 2-digit codes)
     */
    public static function getRegionCodeTitles() {
        return array_combine(
            \libphonenumber\ShortNumbersRegionCodeSet::$shortNumbersRegionCodeSet,
            \libphonenumber\ShortNumbersRegionCodeSet::$shortNumbersRegionCodeSet
        );
    }

}
