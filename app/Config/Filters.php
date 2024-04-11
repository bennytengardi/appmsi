<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;


class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'     => CSRF::class,
		'toolbar'  => DebugToolbar::class,
		'honeypot' => Honeypot::class,
		'filterauth' => \App\Filters\FilterAuth::class,
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */

	public $globals = [
		'before' => [
			'filterauth' => ['except' => [
				'auth', 'auth/*',
				'home', 'home/*',
				'/'
			]],
		],

		'after'  => [
			'filterauth' => ['except' => [
				'admin', 'admin/*',
				'home', 'home/*',
				'auth', 'auth/*',
				'company', 'company/*',
				'satuan', 'satuan/*',
				'merk', 'merk/*',
				'kategori', 'kategori/*',
				'salesman', 'salesman/*',
				'barang', 'barang/*',
				'customer', 'customer/*',
				'supplier', 'supplier/*',
				'account', 'account/*',
				'currency', 'currency/*',
				'user', 'user/*',
				'purchord', 'purchord/*',
				'purchinv', 'purchinv/*',
				'purchrtn', 'purchrtn/*',
				'payment', 'payment/*',
				'suratjln', 'suratjln/*',
				'salesinv', 'salesinv/*',
				'salesord', 'salesord/*',
				'salesrtn', 'salesrtn/*',
				'receipt', 'receipt/*',
				'jurnal', 'jurnal/*',
				'othpay', 'othpay/*',
				'othrcv', 'othrcv/*',
				'bankbook', 'bankbook/*',
				'stockin', 'stockin/*',
				'adjustment', 'adjustment/*',
				'adjbarang', 'adjbarang/*',
				'history', 'history/*',
				'loghistory', 'loghistory/*',
				'posting', 'posting/*',
				'backup', 'backup/*',
				'gantinoinvoice','gantinoinvoice/*',
				'gantinosjalan','gantinosjalan/*',
				'gantinoso','gantinoso/*',
				'gantinopo','gantinopo/*',
				'gantikodebarang','gantikodebarang/*',
				'counter', 'counter/*',
				'lapbeli01', 'lapbeli01/*',
				'lapbeli02', 'lapbeli02/*',
				'lapbeli03', 'lapbeli03/*',
				'lapbeli04', 'lapbeli04/*',
				'lapbeli05', 'lapbeli05/*',
				'lapbeli06', 'lapbeli06/*',
				'lapbeli07', 'lapbeli07/*',
				'lapbeli08', 'lapbeli08/*',
				'lapbeli09', 'lapbeli09/*',
				'lapbeli10', 'lapbeli10/*',
				'lapjual01', 'lapjual01/*',
				'lapjual02', 'lapjual02/*',
				'lapjual03', 'lapjual03/*',
				'lapjual04', 'lapjual04/*',
				'lapjual05', 'lapjual05/*',
				'lapjual06', 'lapjual06/*',
				'lapjual07', 'lapjual07/*',
				'lapjual08', 'lapjual08/*',
				'lapjual09', 'lapjual09/*',
				'lapjual10', 'lapjual10/*',
				'lapjual11', 'lapjual11/*',
				'lapjual12', 'lapjual12/*',
				'lapjual13', 'lapjual13/*',
				'lapjual14', 'lapjual14/*',
				'lapjual15', 'lapjual15/*',
				'lapjual16', 'lapjual16/*',
				'lapjual17', 'lapjual17/*',
				'lapjual18', 'lapjual18/*',
				'lapjual19', 'lapjual19/*',
				'lapjual20', 'lapjual20/*',
				'lapjual21', 'lapjual21/*',
				'lapjual22', 'lapjual22/*',
				'lapjual23', 'lapjual23/*',
				'lapjual24', 'lapjual24/*',
				'lapjual25', 'lapjual25/*',
				'lapjual26', 'lapjual26/*',
				'lapjual27', 'lapjual27/*',
				'lapkeu01', 'lapkeu01/*',
				'lapkeu02', 'lapkeu02/*',
				'lapkeu03', 'lapkeu03/*',
				'lapkeu04', 'lapkeu04/*',
				'lapkeu05', 'lapkeu05/*',
				'lapkeu06', 'lapkeu06/*',
				'lapstk01', 'lapstk01/*',
				'lapstk02', 'lapstk02/*',
				'lapstk03', 'lapstk03/*',
				'lapstk04', 'lapstk04/*',
				'lapprod01', 'lapprod01/*',
				'lapprod02', 'lapprod02/*',
				'lapprod03', 'lapprod03/*',
				'/'
			]],
			//'honeypot'
		],
	];


	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [];
}
