<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $customer_put  = [
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            // 'zip' => 'required|numeric',
            // 'phone1' => 'required|numeric',
            // 'phone2' => 'numeric',
            // 'country' => 'required|min_length[3]|max_length[50]',
            // 'address' => 'required|min_length[3]|max_length[50]',
    ];

    public $customer_post  = [
            'id' => 'trim|required|numeric',
            'name' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            // 'zip' => 'required|numeric',
            // 'phone1' => 'required|numeric',
            // 'phone2' => 'numeric',
            // 'country' => 'required|min_length[3]|max_length[50]',
            // 'address' => 'required|min_length[3]|max_length[50]',
    ];
}
