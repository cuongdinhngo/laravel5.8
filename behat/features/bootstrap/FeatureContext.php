<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit_Framework_Assert as PHPUnit;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    public $content;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        DB::table('users')->truncate();
        Session::flush();
    }

    /**
     * @Given a user called :user exists
     */
    public function aUserCalledExists($user)
    {
        $data = [
            'name' => $user,
            "email" => "{$user}_dummy_test@mailinator.com",
            "password" => Hash::make("123456"),
            "api_token" => Str::random(80)
        ];

        $user = factory(User::class)->create($data);
    }

    /**
     * @Given I login as :email with password :password
     */
    public function iLoginAsWithPassword($email, $password)
    {
        $this->visit("/login");
        $this->fillField("email", $email);
        $this->fillField("password", $password);
        $this->pressButton("Login");
    }
}
