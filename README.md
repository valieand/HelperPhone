HelperPhone For ProcessWire CMS/CMF
=======================================

HelperPhone Pack For ProcessWire CMS/CMF.
Copyright (c) 2013-2016 Andrey Valiev aka @valieand

This pack includes following modules for ProcessWire CMS/CMF:
- FieldtypePhoneNumber: module that stores phone numbers
- InputFieldPhoneNumber: module that renders inputfield for phone numbers
- HelperPhone: module that can be

All these modules require included PW WireData-derived class PhoneNumber and PhoneNumberConst.
- PhoneNumber class is a thin wrapper over [giggsey/libphonenumber-for-php](https://github.com/giggsey/libphonenumber-for-php), itself is port of Google's libphonenumber.
- PhoneNumberConst class stores constants, used by PhoneNumber class

## Requirements

Please note that this module requires:
- ProcessWire 2.6.20 or a later version
- PHP 7.0.0 or later version

## Getting started

Copy (or clone with git) HelperPhone folder to /site/modules/, go to Admin >
Modules, hit "Check for new modules" and install required modules.

After installing these modules you need to configure them before anything really
starts happening.

## Usage: as PhoneNumber class

$phone = '8 (916) 318-07-29 ext 1234'; // input string could be in any phone-recogizable format
$phoneNumber = new PhoneNumber($phone, 'RU'); // or call wire('modules')->get('HelperPhone')->makePhoneNumber($phone, 'RU');

echo ($phoneNumber->isValidNumber() ? 'Yes':'No'); // Yes
echo ($phoneNumber->isValidNumberForRegion($regionCode) ? 'Yes':'No'); // Yes
echo PhoneNumberConst::typeNames[$phoneNumber->getNumberType()]; // Mobile
echo $phoneNumber->getCountryCode(); // 7
echo $phoneNumber->getRegionCode(); // RU
echo $phoneNumber->getNationalNumber(); // 9163180729
echo $phoneNumber->getExtension(); // 1234

## Usage: as field

// Note: on field creation, make sure that you've configured field settings:
// - default region: region that will be assumed if input phone number string is not in international format, e.g. does not start with '+'
// - enabled/disabled phone extentions: if disabled, phone extension will be removed on field save.

// Phone field settings in example below: default region code 'RU', phone extensions are enabled

echo $page->phone; // +79163180729, $page->phone stores instance of PhoneNumber which renders toString in E164 format. Note: this format does not include extension.
echo $page->getFormatted('phone'); // +7 916 318-07-29 ext. 1234
echo $page->getUnformatted('phone'); // +79163180729
echo $page->phone->format(PhoneNumberConst::RFC3966); // tel:+7-916-318-07-29;ext=1234
echo $page->phone->getNationalNumber(); // 9163180729

## Usage: in PW selectors

// FieldtypePhoneNumber is instance of FieldtypeText.
// It stores phone numbers and extensions as string in E164 format with #extention (if provided by user and enabled in settings)
// E.g. in db it looks like this: '+79163180729#1234'
// This makes it easy to query fields as any text field
// However, be careful

echo $pages->find([
    'template' => 'my_temlate',
    'phone^=' => '+79163180729',
]); // will echo page ids where phone starts with '+79163180729'

## License

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

(See included LICENSE file for full license text.)
