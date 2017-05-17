<?php

class HelperPhoneConfig extends ModuleConfig {

    public function getDefaults() {
        return [
            'defaultRegionCode' => 'RU',
        ];
    }

    public function getInputfields() {
        $w = parent::getInputfields();

        $this->wire('classLoader')->addNamespace('libphonenumber', dirname(__FILE__) . '/libphonenumber-for-php/src/');
        require_once(dirname(__FILE__) . '/PhoneNumberConst.php');

        $regionCodeTitles = PhoneNumberConst::getRegionCodeTitles();
        $regionCodeTitles = array_merge([\libphonenumber\PhoneNumberUtil::UNKNOWN_REGION => ' '], $regionCodeTitles);

        $f = $this->wire('modules')->get("InputfieldSelect");
        $f->name = 'defaultRegionCode';
        $f->label = $this->_('Default region code');
        $f->required = true;
        $f->notes = $this->_('2-letter ISO code for country. For example, Russia region code is RU.');
        $f->addOptions($regionCodeTitles);
        $w->add($f);

        return $w;
    }

}
?>