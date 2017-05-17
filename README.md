HelperPhone For ProcessWire CMS/CMF
=======================================

HelperPhone Pack For ProcessWire CMS/CMF.
Copyright (c) 2013-2016 Andrey Valiev aka @valieand

This pack includes following modules for ProcessWire CMS/CMF:
- FieldtypePhoneNumber: module that stores phone numbers
- InputfieldPhoneNumber: module that renders inputfield for phone numbers
- HelperPhone: module that loads PhoneNumber and PhoneNumberConst classes, and 'libphonenumber' namespace

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
Each of these modules can be used independently.

After installing HelperPhone - set default region code in module config. If skipped, phone numbers will be valid only if number is provided in international format, e.g. starting with '+'.

FieldtypePhoneNumber and InputfieldPhoneNumber does not require configuration in module config, however, if you create new PhoneNumber field, make sure that it is configured in field settings: default region and enable/disable extensions.

## Usage: as PhoneNumber class

```````````
$phone = '8 (916) 318-07-29 ext 1234'; // input string could be in any phone-recognizable format
$phoneNumber = new PhoneNumber($phone, 'RU');
// or wire('modules')->get('HelperPhone')->makePhoneNumber($phone, 'RU');

echo ($phoneNumber->isValidNumber() ? 'Yes':'No');
// Yes

echo ($phoneNumber->isValidNumberForRegion($regionCode) ? 'Yes':'No');
// Yes

echo PhoneNumberConst::typeNames[$phoneNumber->getNumberType()];
// Mobile

echo $phoneNumber->getCountryCode();
// 7

echo $phoneNumber->getRegionCode();
// RU

echo $phoneNumber->getNationalNumber();
// 9163180729

echo $phoneNumber->getExtension();
// 1234

echo $phoneNumber->formatForCallingFrom('US')
// 011 7 916 318-07-28

echo $phoneNumber->formatForCallingFrom('GE')
// 00 7 916 318-07-28
```````````

For more methods and properties please refer to PhoneNumber and PhoneNumberConst source files. Need more? Check [giggsey/libphonenumber-for-php](https://github.com/giggsey/libphonenumber-for-php) and use it by accessing $phoneNumber->phoneNumber property - it is instance of \libphonenumber\PhoneNumber or null (if empty).

## Usage: as field

Note: on field creation, make sure that you've configured field settings
- default region: region that will be assumed if input phone number string is not in international format, e.g. does not start with '+'
- enabled/disabled phone extentions: if disabled, phone extension will be removed on field save.

Phone field settings in example below: default region code 'RU', phone extensions are enabled

```````````
echo $page->phone;
// +79163180729
// Note1: $page->phone stores instance of PhoneNumber and renders to string in E164 format.
// Note2: E164 format does not include extension.

echo $page->getFormatted('phone');
// +7 916 318-07-29 ext. 1234

echo $page->getUnformatted('phone');
// +79163180729

echo $page->phone->format(PhoneNumberConst::RFC3966);
// tel:+7-916-318-07-29;ext=1234

echo $page->phone->getNationalNumber();
// 9163180729
```````````

## Usage: in PW selectors

FieldtypePhoneNumber is instance of FieldtypeText.
It stores phone numbers and extensions as string in E164 format with #extention (if provided by user and enabled in settings)
E.g. in db it looks like this: '+79163180729#1234'. This makes it easy to query fields as any text field.

```````````
echo $pages->find([
    'template' => 'my_temlate',
    'phone^=' => '+79163180729',
]);
// will echo page ids where phone starts with '+79163180729'
```````````

## Usage: FieldtypePhoneNumber and InputfieldPhoneNumber

Two new properties you may find useful: $regionCode and $enableExtension. Other properties are derived from '...Text' parents.
Please refer to source files for details.

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
