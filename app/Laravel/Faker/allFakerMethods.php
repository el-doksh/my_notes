<?php
[ 
    'ar' => [
    'name' => $this->faker->name(),
    ],
    'en' => [
        'name' => $this->faker->name(),
    ],
    'image' =>  $this->faker->image(public_path('uploads/levels'),640,480),
    'bool' => $this->faker->boolean(),
    'company' => $faker->unique()->company,
    'email' => $faker->safeEmail,
    'logo' => $faker->imageUrl($width = 640, $height = 480),
    'cover' => $faker->imageUrl($width = 1000, $height = 600),
    'bio' => $faker->catchPhrase,
    'main' => $faker->realText($maxNbChars = 200, $indexSize = 2),
    'featured' => $faker->boolean($chanceOfGettingTrue = 50),
    'url' => $faker->url,
    'contact_name' => $faker->name,
    'contact_number' => $faker->phoneNumber,
    'full_name' => $this->faker->name(),
    'nick_name' => $this->faker->unique()->userName(),
    'nationallity' => $this->faker->name(),
    'gender' => $this->faker->randomElement(['Male', 'Female']),
    'date_of_birth' => $this->faker->date(),
    // 'password' => Hash::make('admin@123456'),
    'active' => $this->faker->boolean(),
    'email' => $this->faker->unique()->safeEmail(),
    'phone' => $this->faker->unique()->numerify('##########'),
    'email_verified_at' => now(),
    'password' => Hash::make('test@123456'), // password
    'remember_token' => Str::random(10),
    'num & string' => $this->faker->bothify('?###??##'),
    'numberrrs' => $faker->numerify('##########'),
    'phone' => $faker->numerify('###-###-####'),
    'amount' => $faker->randomFloat(2, 0, 10000),
    'name' => $faker->word,
    'short_description' => $faker->sentence,
    'description' => $faker->paragraph,
    'img' => $faker->image(storage_path('images'),400,300, null, false),
    'number' => $this->faker->numberBetween(1,50),
];

$values = [];
for ($i = 0; $i < 10; $i++) {
    // get a random digit, but always a new one, to avoid duplicates
    $values []= $faker->unique()->randomDigit();
}
print_r($values); // [4, 1, 8, 5, 0, 2, 6, 9, 7, 3]

// providers with a limited range will throw an exception when no new unique value can be generated
$values = [];
try {
    for ($i = 0; $i < 10; $i++) {
        $values []= $faker->unique()->randomDigitNotNull();
    }
} catch (\OverflowException $e) {
    echo "There are only 9 unique digits not null, Faker can't generate 10 of them!";
}

// you can reset the unique modifier for all providers by passing true as first argument
$faker->unique($reset = true)->randomDigitNotNull(); // will not throw OverflowException since unique() was reset
// tip: unique() keeps one array of values per provider

// optional() sometimes bypasses the provider to return a default value instead (which defaults to NULL)
$values = [];
for ($i = 0; $i < 10; $i++) {
    // get a random digit, but also null sometimes
    $values []= $faker->optional()->randomDigit();
}
print_r($values); // [1, 4, null, 9, 5, null, null, 4, 6, null]

// optional() accepts a weight argument to specify the probability of receiving the default value.
// 0 will always return the default value; 1.0 will always return the provider. Default weight is 0.5 (50% chance).
// Please note that the weight can be provided as float (0 / 1.0) or int (0 / 100)

// As float
$faker->optional($weight = 0.1)->randomDigit(); // 90% chance of NULL
$faker->optional($weight = 0.9)->randomDigit(); // 10% chance of NULL

// As int
$faker->optional($weight = 10)->randomDigit; // 90% chance of NULL
$faker->optional($weight = 100)->randomDigit; // 0% chance of NULL

// optional() accepts a default argument to specify the default value to return.
// Defaults to NULL.
$faker->optional($weight = 0.5, $default = false)->randomDigit(); // 50% chance of FALSE
$faker->optional($weight = 0.9, $default = 'abc')->word(); // 10% chance of 'abc'

// valid() only accepts valid values according to the passed validator functions
$values = [];
$evenValidator = function($digit) {
    return $digit % 2 === 0;
};
for ($i = 0; $i < 10; $i++) {
    $values []= $faker->valid($evenValidator)->randomDigit();
}
print_r($values); // [0, 4, 8, 4, 2, 6, 0, 8, 8, 6]

// just like unique(), valid() throws an overflow exception when it can't generate a valid value
$values = [];
try {
    $faker->valid($evenValidator)->randomElement([1, 3, 5, 7, 9]);
} catch (\OverflowException $e) {
    echo "Can't pick an even number in that set!";
}