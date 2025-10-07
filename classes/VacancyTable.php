<?php

namespace Recruitee;

use WP_List_Table;
use WP_Query;
use Jacht\Constants;

defined('ABSPATH') || exit;

/**
 * Adding WP List table class if it's not available.
 */
if (!class_exists(WP_List_Table::class)) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * Class Drafts_List_Table.
 *
 * @since 0.1.0
 * @package Admin_Table_Tut
 * @see WP_List_Table
 */
class VacancyTable extends WP_List_Table
{

	/**
	 * Const to declare number of posts to show per page in the table.
	 */
	public const POSTS_PER_PAGE = 10;


	/**
	 * Return instances post object.
	 *
	 * @return WP_Query Custom query object with passed arguments.
	 */
	protected function get_posts_object()
	{

		$post_args = [
			'post_type'      => Constants::POST_TYPE,
			'posts_per_page' => self::POSTS_PER_PAGE,
		];

		$paged = filter_input(INPUT_GET, 'paged', FILTER_VALIDATE_INT);

		if ($paged) {
			$post_args['paged'] = $paged;
		}

		$post_type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);

		if ($post_type) {
			$post_args['post_type'] = $post_type;
		}

		$orderby = sanitize_sql_orderby(filter_input(INPUT_GET, 'orderby'));
		$order = esc_sql(filter_input(INPUT_GET, 'order'));

		if (empty($orderby)) {
			$orderby = 'date';
		}

		if (empty($order)) {
			$order = 'DESC';
		}

		$post_args['orderby'] = $orderby;
		$post_args['order'] = $order;

		$search = esc_sql(filter_input(INPUT_GET, 's'));
		if (!empty($search)) {
			$post_args['s'] = $search;
		}

		return new WP_Query($post_args);
	}

	/**
	 * Display text for when there are no items.
	 */
	public function no_items()
	{
		esc_html_e('Geen vacatures gevonden', 'jacht-vacancies');
	}

	/**
	 * The Default columns
	 *
	 * @param array $item The Item being displayed.
	 * @param string $column_name The column we're currently in.
	 * @return string              The Content to display
	 */
	public function column_default($item, $column_name) {
		$result = '';
		switch ($column_name) {
			case 'modified':
				$result = get_the_modified_date('d-m-Y H:i:s', $item['id']);
				break;
		}

		return $result;
	}

	/**
	 * Get list columns.
	 *
	 * @return array
	 */
	public function get_columns()
	{
		return [
			'title'    => __('Titel', 'jacht-vacancies'),
			'modified' => __('Laatst gewijzigd', 'jacht-vacancies'),
		];
	}

	/**
	 * Return title column.
	 *
	 * @param array $item Item data.
	 * @return string
	 */
	public function column_title($item)
	{
		$edit_url = get_edit_post_link($item['id']);

		$output = '<strong>';
		$output .= '<a class="row-title" href="' . esc_url($edit_url) . '" aria-label="' . sprintf(__('%s (Edit)'), $item['title']) . '">' . esc_html($item['title']) . '</a>';
		$output .= _post_states(get_post($item['id']), false);
		$output .= '</strong>';

		return $output;
	}


	/**
	 * Prepare the data for the WP List Table
	 *
	 * @return void
	 */
	public function prepare_items()
	{

		$columns = $this->get_columns();
		$sortable = $this->get_sortable_columns();
		$hidden = [];
		$primary = 'title';
		$this->_column_headers = [$columns, $hidden, $sortable, $primary];
		$data = [];

		$get_posts_obj = $this->get_posts_object();

		if ($get_posts_obj->have_posts()) {

			while ($get_posts_obj->have_posts()) {

				$get_posts_obj->the_post();
				$data[get_the_ID()] = [
					'id'    => get_the_ID(),
					'title' => get_the_title(),
					'date'  => get_post_datetime(),
				];
			}
			wp_reset_postdata();
		}

		$this->items = $data;

		$this->set_pagination_args(
			[
				'total_items' => $get_posts_obj->found_posts,
				'per_page'    => $get_posts_obj->post_count,
				'total_pages' => $get_posts_obj->max_num_pages,
			]
		);
	}

	/**
	 * Include the columns which can be sortable.
	 *
	 * @return array[] $sortable_columns Return array of sortable columns.
	 */
	public function get_sortable_columns()
	{

		return [
			'title' => ['title', false],
			'date'  => ['date', false],
		];
	}
}