<?php

class ACFLocationRules
{
    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/location/rule_types', [ $handler,'acf_location_rule_types' ] );

        add_filter( 'acf/location/rule_values/current_locale', [ $handler,'acf_location_rule_values_locale' ] );

        add_filter( 'acf/location/rule_match/current_locale', [ $handler, 'acf_location_rule_match_user' ] );
    }

    public static function acf_location_rule_types( $choices )
    {
        $choices['Language']['current_locale'] = 'Current Locale';
    
        return $choices;
    }

    public static function acf_location_rule_values_locale( $choices )
    {
        $languages = WPMLLangSwitcher::choises();

        foreach( $languages as $language ) {
            $choices[ $language['default_locale'] ] = $language['native_name'] . ' [' . $language['default_locale'] . ']';
        }

        return $choices;
    }

    public static function acf_location_rule_match_user( $match, $rule, $options, $field_group )
    {
        $message['function'] = 'acf_location_rule_match_user';

        $current_language = apply_filters( 'wpml_post_language_details', NULL, $options['post_id'] ) ;

        $message['current_language'] = $current_language;

        $selected_language = $rule['value'];

        $message['selected_language'] = $selected_language;

        if ( $rule['operator'] == "==" ) {
            $match = ( $current_language['locale'] == $selected_language );

        } elseif( $rule['operator'] == "!=" ) {
            $match = ( $current_language['locale'] != $selected_language );
        }

        self::debug( $message );

        return $match;
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>