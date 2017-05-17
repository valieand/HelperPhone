<?php
/**
 * PhoneNumber
 *
 * PhoneNumber is an object that handles phone numbers
 *
 * Properties:
 * ------------------------
 * @property \libphonenumber\PhoneNumber $phoneNumber Объект
 * @property string $regionCode Код региона ISO. Если не указан, то предполагается международный формат номера.
 *
 * Hookable methods
 * ----------------
 *
 */

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber extends WireData {

    public function __construct($phoneNumber = null, $regionCode = null) {
        $this->set('regionCode', $regionCode);
        $this->set('phoneNumber', $phoneNumber);
    }

    public function set($key, $value) {
        if($key === 'phoneNumber') {
            if((is_string($value) || is_numeric($value)) && strlen($value)) {
                try {
                    $value = PhoneNumberUtil::getInstance()->parse($value, $this->regionCode);
                } catch (NumberParseException $e) {
                    if($this->wire('config')->debug) $this->error($e->getMessage() . ' Value=' . $value);
                    $value = null;
                }
            } elseif($value instanceof \libphonenumber\PhoneNumber) {
                // do nothing
            } else {
                $value = null;
            }
        } elseif($key === 'regionCode') {
            if(in_array($value, \libphonenumber\ShortNumbersRegionCodeSet::$shortNumbersRegionCodeSet)) {
                // do nothing
            } elseif($value === PhoneNumberUtil::UNKNOWN_REGION) {
                $value = null;
            } else {
                if($value) {
                    if($this->wire('config')->debug) $this->error('Region code ' . $value . ' is not available.');
                }
                $value = null;
            }
        }

        return parent::set($key, $value);
    }

    public function isEmpty() {
        return $this->phoneNumber === null;
    }

    /**
     * Returns whether this phone number matches a valid pattern.
     *
     * Note this doesn't verify the number is actually in use,
     * which is impossible to tell by just looking at a number itself.
     *
     * @return bool
     */
    public function isValidNumber() {
        if($this->isEmpty()) return false;
        return PhoneNumberUtil::getInstance()->isValidNumber($this->phoneNumber);
    }

    /**
     * Tests whether a phone number is valid for a certain region. Note this doesn't verify the number
     * is actually in use, which is impossible to tell by just looking at a number itself. If the
     * country calling code is not the same as the country calling code for the region, this
     * immediately exits with false. After this, the specific number pattern rules for the region are
     * examined. This is useful for determining for example whether a particular number is valid for
     * Canada, rather than just a valid NANPA number.
     * Warning: In most cases, you want to use {@link #isValidNumber} instead. For example, this
     * method will mark numbers from British Crown dependencies such as the Isle of Man as invalid for
     * the region "GB" (United Kingdom), since it has its own region code, "IM", which may be
     * undesirable.
     *
     * @param PhoneNumber $number the phone number that we want to validate
     * @param string $regionCode the region that we want to validate the phone number for
     * @return boolean that indicates whether the number is of a valid pattern
     */
    public function isValidNumberForRegion($regionCode) {
        if($this->isEmpty()) return false;
        return PhoneNumberUtil::getInstance()->isValidNumberForRegion($this->phoneNumber, $regionCode);
    }

    public function hasExtension() {
        if($this->isEmpty()) return false;
        return $this->phoneNumber->hasExtension();
    }

    public function getExtension() {
        if($this->isEmpty()) return null;
        return $this->phoneNumber->getExtension();
    }

    /**
     * Returns the country code of this PhoneNumber.
     *
     * The country code is a series of 1 to 3 digits, as defined per the E.164 recommendation.
     *
     * @return string
     */
    public function getCountryCode() {
        if($this->isEmpty()) return null;
        return (string) $this->phoneNumber->getCountryCode();
    }

    /**
     * Returns the national number of this PhoneNumber.
     *
     * The national number is a series of digits.
     *
     * @return string
     */
    public function getNationalNumber() {
        if($this->isEmpty()) return null;
        return $this->phoneNumber->getNationalNumber();
    }

    /**
     * Returns the region code of this PhoneNumber.
     *
     * The region code is an ISO 3166-1 alpha-2 country code.
     *
     * If the phone number does not map to a geographic region
     * (global networks, such as satellite phone numbers) this method returns null.
     *
     * @return string|null The region code, or null if the number does not map to a geographic region.
     */
    public function getRegionCode() {
        if($this->isEmpty()) return null;
        $regionCode = PhoneNumberUtil::getInstance()->getRegionCodeForNumber($this->phoneNumber);

        if($regionCode === '001') {
            return null;
        }

        return $regionCode;
    }

    /**
     * Returns the type of this phone number.
     *
     * @return int One of the PhoneNumberType constants.
     */
    public function getNumberType() {
        if($this->isEmpty()) return PhoneNumberConst::unknown;
        return PhoneNumberUtil::getInstance()->getNumberType($this->phoneNumber);
    }

    /**
     * Returns the type title of this phone number.
     *
     * @return string One of the PhoneNumberType constants.
     */
    public function getNumberTypeTitle() {
        $arr = PhoneNumberConst::getTypeTitles();
        return $arr[$this->getNumberType()];
    }

    /**
     * Returns whether this phone number is equal to another.
     *
     * @param PhoneNumber $other The phone number to compare.
     *
     * @return bool True if the phone numbers are equal, false otherwise.
     */
    public function equals(PhoneNumber $other) {
        if($this->isEmpty() && $other->isEmpty()) {
            if($this->regionCode === $other->regionCode) return true;
            return false;
        } elseif(!$this->isEmpty() && !$other->isEmpty()) {
            return $this->phoneNumber->equals($other->phoneNumber);
        } else return false;
    }

    /**
     * Returns a formatted string representation of this phone number.
     *
     * @param int $format One of the PhoneNumberFormat constants.
     *
     * @return string
     */
    public function format($format) {
        if($this->isEmpty()) return '';
        return PhoneNumberUtil::getInstance()->format($this->phoneNumber, $format);
    }

    /**
     * Formats this phone number for out-of-country dialing purposes.
     *
     * @param string $regionCode The ISO 3166-1 alpha-2 country code
     *
     * @return string
     */
    public function formatForCallingFrom($regionCode) {
        if($this->isEmpty()) return '';
        return PhoneNumberUtil::getInstance()->formatOutOfCountryCallingNumber($this->phoneNumber, $regionCode);
    }

    /**
     * Returns a string representation of this phone number in international E164 format.
     *
     * @return string
     */
    public function __toString() {
        if($this->isEmpty()) return '';
        return $this->format(PhoneNumberConst::E164);
    }
}
