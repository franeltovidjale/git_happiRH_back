<?php

use App\Models\Country;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

if (! function_exists('createUniqueSector')) {
    function createUniqueSector($name = 'Technology')
    {
        static $counter = 0;
        $counter++;

        return Sector::create([
            'name' => $name,
            'slug' => strtolower($name) . '-' . $counter,
        ]);
    }
}

if (! function_exists('createUniqueCountry')) {
    function createUniqueCountry($name = 'United States', $code = 'US')
    {
        static $counter = 0;
        $counter++;

        return Country::create([
            'name' => $name . ' ' . $counter,
            'flag' => '🇺🇸',
            'code' => $code . $counter,
            'lang' => 'en',
            'active' => true,
        ]);
    }
}