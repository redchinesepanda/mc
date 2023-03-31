<?php

class ACFLocationRules
{
    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/location/rule_types', [ $handler,'acf_location_rules_types' ] );

        add_filter( 'acf/location/rule_values/current_locale', [ $handler,'acf_location_rule_values_user' ] );
    }

    public static function acf_location_rules_types( $choices )
    {
        $choices['Language']['current_locale'] = 'Current Locale';
    
        return $choices;
    }

    public static function acf_location_rule_values_user( $choices )
    {
        $languages = WPMLLangSwitcher::choises();

        foreach( $languages as $language ) {
            $choices[ $language['default_locale'] ] = $language['native_name'] . ' [' . $language['default_locale'] . ']';
        }

        return $choices;
    }
}

?>