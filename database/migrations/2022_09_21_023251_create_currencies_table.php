<?php

use App\Models\Currency;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol');
            $table->timestamps();
        });

        $currencies = array(
            0 =>
            array(
                'symbol' => '$',
                'name' => 'US Dollar'
            ),
            1 =>
            array(
                'symbol' => 'Ksh',
                'name' => 'Kenyan Shilling',
            ),
            2 =>
            array(
                'symbol' => '€',
                'name' => 'Euro',
            ),
            3 =>
            array(
                'symbol' => 'AED',
                'name' => 'United Arab Emirates Dirham',
            ),
            4 =>
            array(
                'symbol' => 'Af',
                'name' => 'Afghan Afghani',
            ),
            5 =>
            array(
                'symbol' => 'ALL',
                'name' => 'Albanian Lek',
            ),
            6 =>
            array(
                'symbol' => 'AMD',
                'name' => 'Armenian Dram',
            ),
            7 =>
            array(
                'symbol' => 'AR$',
                'name' => 'Argentine Peso',
            ),
            8 =>
            array(
                'symbol' => 'AU$',
                'name' => 'Australian Dollar',
            ),
            9 =>
            array(
                'symbol' => 'man.',
                'name' => 'Azerbaijani Manat',
            ),
            10 =>
            array(
                'symbol' => 'KM',
                'name' => 'Bosnia-Herzegovina Convertible Mark',
            ),
            11 =>
            array(
                'symbol' => 'Tk',
                'name' => 'Bangladeshi Taka',
            ),
            12 =>
            array(
                'symbol' => 'BGN',
                'name' => 'Bulgarian Lev',
            ),
            13 =>
            array(
                'symbol' => 'BD',
                'name' => 'Bahraini Dinar',
            ),
            14 =>
            array(
                'symbol' => 'FBu',
                'name' => 'Burundian Franc',
            ),
            15 =>
            array(
                'symbol' => 'BN$',
                'name' => 'Brunei Dollar',
            ),
            16 =>
            array(
                'symbol' => 'Bs',
                'name' => 'Bolivian Boliviano',
            ),
            17 =>
            array(
                'symbol' => 'R$',
                'name' => 'Brazilian Real',
            ),
            18 =>
            array(
                'symbol' => 'BWP',
                'name' => 'Botswanan Pula',
            ),
            19 =>
            array(
                'symbol' => 'BYR',
                'name' => 'Belarusian Ruble',
            ),
            20 =>
            array(
                'symbol' => 'BZ$',
                'name' => 'Belize Dollar',
            ),
            21 =>
            array(
                'symbol' => 'CDF',
                'name' => 'Congolese Franc',
            ),
            22 =>
            array(
                'symbol' => 'CHF',
                'name' => 'Swiss Franc',
            ),
            23 =>
            array(
                'symbol' => 'CL$',
                'name' => 'Chilean Peso',
            ),
            24 =>
            array(
                'symbol' => 'CN¥',
                'name' => 'Chinese Yuan',
            ),
            25 =>
            array(
                'symbol' => 'CO$',
                'name' => 'Colombian Peso',
            ),
            26 =>
            array(
                'symbol' => '₡',
                'name' => 'Costa Rican Colón',
            ),
            27 =>
            array(
                'symbol' => 'CV$',
                'name' => 'Cape Verdean Escudo',
            ),
            28 =>
            array(
                'symbol' => 'Kč',
                'name' => 'Czech Republic Koruna',
            ),
            29 =>
            array(
                'symbol' => 'Fdj',
                'name' => 'Djiboutian Franc',
            ),
            30 =>
            array(
                'symbol' => 'Dkr',
                'name' => 'Danish Krone',
            ),
            31 =>
            array(
                'symbol' => 'RD$',
                'name' => 'Dominican Peso',
            ),
            32 =>
            array(
                'symbol' => 'DA',
                'name' => 'Algerian Dinar',
            ),
            33 =>
            array(
                'symbol' => 'Ekr',
                'name' => 'Estonian Kroon',
            ),
            34 =>
            array(
                'symbol' => 'EGP',
                'name' => 'Egyptian Pound',
            ),
            35 =>
            array(
                'symbol' => 'Nfk',
                'name' => 'Eritrean Nakfa',
            ),
            36 =>
            array(
                'symbol' => 'Br',
                'name' => 'Ethiopian Birr',
            ),
            37 =>
            array(
                'symbol' => '£',
                'name' => 'British Pound Sterling',
            ),
            38 =>
            array(
                'symbol' => 'GEL',
                'name' => 'Georgian Lari',
            ),
            39 =>
            array(
                'symbol' => 'GH₵',
                'name' => 'Ghanaian Cedi',
            ),
            40 =>
            array(
                'symbol' => 'FG',
                'name' => 'Guinean Franc',
            ),
            41 =>
            array(
                'symbol' => 'GTQ',
                'name' => 'Guatemalan Quetzal',
            ),
            42 =>
            array(
                'symbol' => 'HK$',
                'name' => 'Hong Kong Dollar',
            ),
            43 =>
            array(
                'symbol' => 'HNL',
                'name' => 'Honduran Lempira',
            ),
            44 =>
            array(
                'symbol' => 'kn',
                'name' => 'Croatian Kuna',
            ),
            45 =>
            array(
                'symbol' => 'Ft',
                'name' => 'Hungarian Forint',
            ),
            46 =>
            array(
                'symbol' => 'Rp',
                'name' => 'Indonesian Rupiah',
            ),
            47 =>
            array(
                'symbol' => '₪',
                'name' => 'Israeli New Sheqel',
            ),
            48 =>
            array(
                'symbol' => 'Rs',
                'name' => 'Indian Rupee',
            ),
            49 =>
            array(
                'symbol' => 'IQD',
                'name' => 'Iraqi Dinar',
            ),
            50 =>
            array(
                'symbol' => 'IRR',
                'name' => 'Iranian Rial',
            ),
            51 =>
            array(
                'symbol' => 'Ikr',
                'name' => 'Icelandic Króna',
            ),
            52 =>
            array(
                'symbol' => 'J$',
                'name' => 'Jamaican Dollar',
            ),
            53 =>
            array(
                'symbol' => 'JD',
                'name' => 'Jordanian Dinar',
            ),
            54 =>
            array(
                'symbol' => '¥',
                'name' => 'Japanese Yen',
            ),
            55 =>
            array(
                'symbol' => 'CA$',
                'name' => 'Canadian Dollar',
            ),
            56 =>
            array(
                'symbol' => 'KHR',
                'name' => 'Cambodian Riel',
            ),
            57 =>
            array(
                'symbol' => 'CF',
                'name' => 'Comorian Franc',
            ),
            58 =>
            array(
                'symbol' => '₩',
                'name' => 'South Korean Won',
            ),
            59 =>
            array(
                'symbol' => 'KD',
                'name' => 'Kuwaiti Dinar',
            ),
            60 =>
            array(
                'symbol' => 'KZT',
                'name' => 'Kazakhstani Tenge',
            ),
            61 =>
            array(
                'symbol' => 'LB£',
                'name' => 'Lebanese Pound',
            ),
            62 =>
            array(
                'symbol' => 'SLRs',
                'name' => 'Sri Lankan Rupee',
            ),
            63 =>
            array(
                'symbol' => 'Lt',
                'name' => 'Lithuanian Litas',
            ),
            64 =>
            array(
                'symbol' => 'Ls',
                'name' => 'Latvian Lats',
            ),
            65 =>
            array(
                'symbol' => 'LD',
                'name' => 'Libyan Dinar',
            ),
            66 =>
            array(
                'symbol' => 'MAD',
                'name' => 'Moroccan Dirham',
            ),
            67 =>
            array(
                'symbol' => 'MDL',
                'name' => 'Moldovan Leu',
            ),
            68 =>
            array(
                'symbol' => 'MGA',
                'name' => 'Malagasy Ariary',
            ),
            69 =>
            array(
                'symbol' => 'MKD',
                'name' => 'Macedonian Denar',
            ),
            70 =>
            array(
                'symbol' => 'MMK',
                'name' => 'Myanma Kyat',
            ),
            71 =>
            array(
                'symbol' => 'MOP$',
                'name' => 'Macanese Pataca'
            ),
            72 =>
            array(
                'symbol' => 'MURs',
                'name' => 'Mauritian Rupee'
            ),
            73 =>
            array(
                'symbol' => 'MX$',
                'name' => 'Mexican Peso'
            ),
            74 =>
            array(
                'symbol' => 'RM',
                'name' => 'Malaysian Ringgit'
            ),
            75 =>
            array(
                'symbol' => 'MTn',
                'name' => 'Mozambican Metical'
            ),
            76 =>
            array(
                'symbol' => 'N$',
                'name' => 'Namibian Dollar'
            ),
            77 =>
            array(
                'symbol' => '₦',
                'name' => 'Nigerian Naira'
            ),
            78 =>
            array(
                'symbol' => 'C$',
                'name' => 'Nicaraguan Córdoba'
            ),
            79 =>
            array(
                'symbol' => 'Nkr',
                'name' => 'Norwegian Krone'
            ),
            80 =>
            array(
                'symbol' => 'NPRs',
                'name' => 'Nepalese Rupee',
                'symbol_native' => 'नेरू',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'NPR',
                'name_plural' => 'Nepalese rupees',
            ),
            81 =>
            array(
                'symbol' => 'NZ$',
                'name' => 'New Zealand Dollar',
                'symbol_native' => '$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'NZD',
                'name_plural' => 'New Zealand dollars',
            ),
            82 =>
            array(
                'symbol' => 'OMR',
                'name' => 'Omani Rial',
                'symbol_native' => 'ر.ع.‏',
                'decimal_digits' => 3,
                'rounding' => 0,
                'code' => 'OMR',
                'name_plural' => 'Omani rials',
            ),
            83 =>
            array(
                'symbol' => 'B/.',
                'name' => 'Panamanian Balboa',
                'symbol_native' => 'B/.',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'PAB',
                'name_plural' => 'Panamanian balboas',
            ),
            84 =>
            array(
                'symbol' => 'S/.',
                'name' => 'Peruvian Nuevo Sol',
                'symbol_native' => 'S/.',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'PEN',
                'name_plural' => 'Peruvian nuevos soles',
            ),
            85 =>
            array(
                'symbol' => '₱',
                'name' => 'Philippine Peso',
                'symbol_native' => '₱',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'PHP',
                'name_plural' => 'Philippine pesos',
            ),
            86 =>
            array(
                'symbol' => 'PKRs',
                'name' => 'Pakistani Rupee',
                'symbol_native' => '₨',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'PKR',
                'name_plural' => 'Pakistani rupees',
            ),
            87 =>
            array(
                'symbol' => 'zł',
                'name' => 'Polish Zloty',
                'symbol_native' => 'zł',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'PLN',
                'name_plural' => 'Polish zlotys',
            ),
            88 =>
            array(
                'symbol' => '₲',
                'name' => 'Paraguayan Guarani',
                'symbol_native' => '₲',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'PYG',
                'name_plural' => 'Paraguayan guaranis',
            ),
            89 =>
            array(
                'symbol' => 'QR',
                'name' => 'Qatari Rial',
                'symbol_native' => 'ر.ق.‏',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'QAR',
                'name_plural' => 'Qatari rials',
            ),
            90 =>
            array(
                'symbol' => 'RON',
                'name' => 'Romanian Leu',
                'symbol_native' => 'RON',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'RON',
                'name_plural' => 'Romanian lei',
            ),
            91 =>
            array(
                'symbol' => 'din.',
                'name' => 'Serbian Dinar',
                'symbol_native' => 'дин.',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'RSD',
                'name_plural' => 'Serbian dinars',
            ),
            92 =>
            array(
                'symbol' => 'RUB',
                'name' => 'Russian Ruble',
                'symbol_native' => 'руб.',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'RUB',
                'name_plural' => 'Russian rubles',
            ),
            93 =>
            array(
                'symbol' => 'RWF',
                'name' => 'Rwandan Franc',
                'symbol_native' => 'FR',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'RWF',
                'name_plural' => 'Rwandan francs',
            ),
            94 =>
            array(
                'symbol' => 'SR',
                'name' => 'Saudi Riyal',
                'symbol_native' => 'ر.س.‏',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'SAR',
                'name_plural' => 'Saudi riyals',
            ),
            95 =>
            array(
                'symbol' => 'SDG',
                'name' => 'Sudanese Pound',
                'symbol_native' => 'SDG',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'SDG',
                'name_plural' => 'Sudanese pounds',
            ),
            96 =>
            array(
                'symbol' => 'Skr',
                'name' => 'Swedish Krona',
                'symbol_native' => 'kr',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'SEK',
                'name_plural' => 'Swedish kronor',
            ),
            97 =>
            array(
                'symbol' => 'S$',
                'name' => 'Singapore Dollar',
                'symbol_native' => '$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'SGD',
                'name_plural' => 'Singapore dollars',
            ),
            98 =>
            array(
                'symbol' => 'Ssh',
                'name' => 'Somali Shilling',
                'symbol_native' => 'Ssh',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'SOS',
                'name_plural' => 'Somali shillings',
            ),
            99 =>
            array(
                'symbol' => 'SY£',
                'name' => 'Syrian Pound',
                'symbol_native' => 'ل.س.‏',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'SYP',
                'name_plural' => 'Syrian pounds',
            ),
            100 =>
            array(
                'symbol' => '฿',
                'name' => 'Thai Baht',
                'symbol_native' => '฿',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'THB',
                'name_plural' => 'Thai baht',
            ),
            101 =>
            array(
                'symbol' => 'DT',
                'name' => 'Tunisian Dinar',
                'symbol_native' => 'د.ت.‏',
                'decimal_digits' => 3,
                'rounding' => 0,
                'code' => 'TND',
                'name_plural' => 'Tunisian dinars',
            ),
            102 =>
            array(
                'symbol' => 'T$',
                'name' => 'Tongan Paʻanga',
                'symbol_native' => 'T$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'TOP',
                'name_plural' => 'Tongan paʻanga',
            ),
            103 =>
            array(
                'symbol' => 'TL',
                'name' => 'Turkish Lira',
                'symbol_native' => 'TL',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'TRY',
                'name_plural' => 'Turkish Lira',
            ),
            104 =>
            array(
                'symbol' => 'TT$',
                'name' => 'Trinidad and Tobago Dollar',
                'symbol_native' => '$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'TTD',
                'name_plural' => 'Trinidad and Tobago dollars',
            ),
            105 =>
            array(
                'symbol' => 'NT$',
                'name' => 'New Taiwan Dollar',
                'symbol_native' => 'NT$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'TWD',
                'name_plural' => 'New Taiwan dollars',
            ),
            106 =>
            array(
                'symbol' => 'TSh',
                'name' => 'Tanzanian Shilling',
                'symbol_native' => 'TSh',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'TZS',
                'name_plural' => 'Tanzanian shillings',
            ),
            107 =>
            array(
                'symbol' => '₴',
                'name' => 'Ukrainian Hryvnia',
                'symbol_native' => '₴',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'UAH',
                'name_plural' => 'Ukrainian hryvnias',
            ),
            108 =>
            array(
                'symbol' => 'USh',
                'name' => 'Ugandan Shilling',
                'symbol_native' => 'USh',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'UGX',
                'name_plural' => 'Ugandan shillings',
            ),
            109 =>
            array(
                'symbol' => '$U',
                'name' => 'Uruguayan Peso',
                'symbol_native' => '$',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'UYU',
                'name_plural' => 'Uruguayan pesos',
            ),
            110 =>
            array(
                'symbol' => 'UZS',
                'name' => 'Uzbekistan Som',
                'symbol_native' => 'UZS',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'UZS',
                'name_plural' => 'Uzbekistan som',
            ),
            111 =>
            array(
                'symbol' => 'Bs.F.',
                'name' => 'Venezuelan Bolívar',
                'symbol_native' => 'Bs.F.',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'VEF',
                'name_plural' => 'Venezuelan bolívars',
            ),
            112 =>
            array(
                'symbol' => '₫',
                'name' => 'Vietnamese Dong',
                'symbol_native' => '₫',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'VND',
                'name_plural' => 'Vietnamese dong',
            ),
            113 =>
            array(
                'symbol' => 'FCFA',
                'name' => 'CFA Franc BEAC',
                'symbol_native' => 'FCFA',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'XAF',
                'name_plural' => 'CFA francs BEAC',
            ),
            114 =>
            array(
                'symbol' => 'CFA',
                'name' => 'CFA Franc BCEAO',
                'symbol_native' => 'CFA',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'XOF',
                'name_plural' => 'CFA francs BCEAO',
            ),
            115 =>
            array(
                'symbol' => 'YR',
                'name' => 'Yemeni Rial',
                'symbol_native' => 'ر.ي.‏',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'YER',
                'name_plural' => 'Yemeni rials',
            ),
            116 =>
            array(
                'symbol' => 'R',
                'name' => 'South African Rand',
                'symbol_native' => 'R',
                'decimal_digits' => 2,
                'rounding' => 0,
                'code' => 'ZAR',
                'name_plural' => 'South African rand',
            ),
            117 =>
            array(
                'symbol' => 'ZK',
                'name' => 'Zambian Kwacha',
                'symbol_native' => 'ZK',
                'decimal_digits' => 0,
                'rounding' => 0,
                'code' => 'ZMK',
                'name_plural' => 'Zambian kwachas',
            ),
        );

        foreach ($currencies as $currency) {
            Currency::updateOrCreate(['symbol' => $currency['symbol']], [
                'name' => $currency['name'],
                'symbol' => $currency['symbol']
            ]);
        }
    }
}
