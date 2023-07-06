<?php

class ACFCompilation
{
    const FIELD = [
        'lang' => 'compilation-lang',
        
        'order-type' => 'billet-order-type',

        'achievement-type' => 'billet-achievement-type',

        'operator' => 'compilation-operator',
        
        'review-type' => 'compilation-review-type',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'lang' ], [ $handler, 'choices_lang' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'order-type' ], [ $handler, 'choices_order_type' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'achievement-type' ], [ $handler, 'choices_achievement_type' ] );
        
        add_filter( 'acf/load_field/name=' . self::FIELD[ 'operator' ], [ $handler, 'choices_operator' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'review-type' ], [ $handler, 'choices_review_type' ] );
    }

    public static function choices_lang( $field )
    {
        $languages = WPMLLangSwitcher::choises();

        $choices = [];

        foreach( $languages as $language )
        {
            $choices[ $language[ 'language_code' ] ] = $language[ 'native_name' ] . ' [' . $language[ 'language_code' ] . ']';
        }

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_order_type( $field )
    {
        $choices[ 'legal-disabled' ] = 'Не отображать';

        $choices[ 'legal-logo' ] = 'Над логотипом';

        $choices[ 'legal-title' ] = 'Перед заголовком';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_achievement_type( $field )
    {
        $choices[ 'legal-disabled' ] = 'Не отображать';

        $choices[ 'legal-image' ] = 'Фон с картинкой';

        $choices[ 'legal-background' ] = 'Только фон';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_operator( $field )
    {
        $choices[ 'AND' ] = 'В каждом';

        $choices[ 'IN' ] = 'Хотя бы одном';

        $choices[ 'NOT IN' ] = 'Ни в одном';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_review_type( $field )
    {
        $choices[ 'legal-bonus' ] = 'Бонус';

        $field[ 'choices' ] = $choices;

        return $field;
    }
}

?>