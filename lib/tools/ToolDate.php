<?php

class ToolDate {

    const COMPARE_TYPES = [ '<', '>', '=', '<=', '>=' ];
    private $date_key;
    private $date_value;
    private $format;
    private $compare = '=';
    private $order_by_meta = '';

    public function __construct(
        string $date_key,
        string $date_value,
        string $mysql_format,
        string $compare = '='
    ) {
		$this->date_key   = $date_key;
        $this->date_value = $date_value;
        $this->format     = $mysql_format;
        in_array($compare, self::COMPARE_TYPES, TRUE) and $this->compare = $compare;
    }

    public function orderByMeta(string $direction = 'DESC'): ToolDate {
        if (in_array(strtoupper($direction), ['ASC', 'DESC'], TRUE)) {
            $this->order_by_meta = $direction;
        }
        return $this;
    }

    public function createWpQuery(array $args = []): \WP_Query {
        $args['meta_key'] = $this->date_key;
        $this->whereFilter('add');
        $this->order_by_meta and $this->orderByFilter('add');
        $query = new \WP_Query($args);
        $this->whereFilter('remove');
        $this->order_by_meta and $this->orderByFilter('remove');
        return $query;
    }

    // private function whereFilter(string $action) {
    //     static $filter;
    //     if (! $filter && $action === 'add') {
    //         $filter = function ($where) {
    //             global $wpdb;
    //             $where and $where .= ' AND ';
    //             $sql = "STR_TO_DATE({$wpdb->postmeta}.meta_value, %s) ";
    //             $sql .= "{$this->compare} %s";
    //             return $where . $wpdb->prepare($sql, $this->format, $this->date_value);
    //         };
    //     }
    //     $action === 'add'
    //         ? add_filter('posts_where', $filter)
    //         : remove_filter('posts_where', $filter);

	// 	LegalDebug::debug( [
	// 		'filter' => $filter,
	// 	] );
    // }

	// public static function ( $where )
	// {
	// 	global $wpdb;
	// 	$where and $where .= ' AND ';
	// 	$sql = "STR_TO_DATE({$wpdb->postmeta}.meta_value, %s) ";
	// 	$sql .= "{$this->compare} %s";
	// 	return $where . $wpdb->prepare($sql, $this->format, $this->date_value);
	// }

    private function whereFilter(string $action) {
        static $filter;
        // if (! $filter && $action === 'add') {
        if ( $action === 'add' ) {
            $filter = function ($where) {
                global $wpdb;
                $where and $where .= ' AND ';
                $sql = "STR_TO_DATE({$wpdb->postmeta}.meta_value, %s) ";
                $sql .= "{$this->compare} %s";
                return $where . $wpdb->prepare($sql, $this->format, $this->date_value);
            };
        }
        $action === 'add'
            ? add_filter('posts_where', $filter)
            : remove_filter('posts_where', $filter);

		LegalDebug::debug( [
			'filter' => $filter,
		] );
    }

    private function orderByFilter(string $action) {
        static $filter;
        if (! $filter && $action === 'add') {
            $filter = function () {
                global $wpdb;
                $sql = "STR_TO_DATE({$wpdb->postmeta}.meta_value, %s) ";
                $sql .= $this->order_by_meta;
                return $wpdb->prepare($sql, $this->format);
            };
        }
        $action === 'add'
            ? add_filter('posts_orderby', $filter)
            : remove_filter('posts_orderby', $filter);
    }
}

?>