@php
$sampleData = [
    // Header data
    'company_name' => 'SOGEA-SATOM SA',
    'company_address' => '01 B P 2190',
    'company_city' => 'COTONOU',
    'company_phone' => '21-33-00-94',
    'company_country' => 'BENIN',
    'social_place' => 'C.N.S.S.',
    'social_address' => 'BP 374',
    'period' => 'OCTOBRE 2024',
    'period_start' => '01/10/2024',
    'period_end' => '31/10/24',
    'employee_id' => 'EMP001',
    'seniority_date' => '01/12/17',
    'establishment_name' => 'S A T O M  B E N I N',
    'establishment_address' => 'B.P. 2190',
    'establishment_city' => 'COTONOU',
    'establishment_phone' => '33 00 94',
    'siret' => '1    00001        ',
    'naf' => '.',
    'collective_agreement' => 'BATIMENT ET T.P.',
    'salary' => 500000,
    'job_title' => 'INGENIEUR',
    'calculation_code' => 'ING001',
    'qualification' => 'AGENT DE MAITRISE 5',
    'security_number' => '123456789',
    'employee_name' => 'DUPONT JEAN',
    'employee_postal' => '00000',
    'employee_city' => 'COTONOU',
    'employee_country' => 'BENIN',
    'ifu_number' => '987654321',
    'mutual' => 'MUTUAL+',
    'family_status' => 'M',
    'children_count' => '02',
    'tax_deductions' => '02',
    
    // Body data
    'payroll_lines' => [
        [
            'code' => '0012',
            'label' => 'SAL. DE BASE MENS.',
            'base' => '',
            'rate' => '100,000',
            'addition' => '500000',
            'deduction' => '',
            'employer_rate' => '',
            'employer_amount' => '',
            'date_event' => 'P 01/10'
        ],
        [
            'code' => '0122',
            'label' => 'IND.DEPLACEMENT',
            'base' => '23,00',
            'rate' => '25000,000',
            'addition' => '25000',
            'deduction' => '',
            'employer_rate' => '',
            'employer_amount' => '',
            'date_event' => 'P 02/10'
        ],
        // Ajoutez d'autres lignes selon vos besoins
    ],
    'subtotal_additions' => 552193,
    'subtotal_deductions' => 190693,
    'subtotal_employer' => 134243,
    'net_pay' => 361500,
    
    // Footer data
    'payment_method' => 'VIREMENTS',
    'payment_date' => '31/10/24',
    'bank_code' => 'BJ061',
    'branch_code' => '01004',
    'account_number' => '0784722000150',
    'bank_name' => 'BANK OF AFRICA',
    'taxable_base' => 551250,
    'taxable_base_annual' => 6615000,
    'page_number' => '1/1',
    
    // Summary data
    'left_summary' => [],
    'right_summary' => [
        [
            'label' => 'BASE IMPOSABLE',
            'month' => '551250',
            'annual' => '6615000'
        ]
    ]
];
@endphp

@include('pdf.payslip.benin_payslip', ['data' => $sampleData])