# Factories
## Use Tinker
```php artisan tinker```

## User Model with Phone Number

```php
\App\Models\User::factory(1)
    ->has(
        \App\Models\Phone::factory()
            ->count(3)
            ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                ['type' => \App\Models\Phone::PHONE_TYPE['MOBILE']],
                ['type' => \App\Models\Phone::PHONE_TYPE['WORK']],
                ['type' => \App\Models\Phone::PHONE_TYPE['HOME']],
            ))
    )->create();
```

## Seeds Properties with Address and Owners

```php
$owners = \App\Models\User::factory()
        ->has(
            \App\Models\Phone::factory()
                ->count(3)
                ->state(new \Illuminate\Database\Eloquent\Factories\Sequence(
                    ['type' => \App\Models\Phone::PHONE_TYPE['MOBILE']],
                    ['type' => \App\Models\Phone::PHONE_TYPE['WORK']],
                    ['type' => \App\Models\Phone::PHONE_TYPE['HOME']],
                ))
        );

\App\Models\Property::factory(1)
    ->has(
        \App\Models\Address::factory()
    )
    ->has($owners, 'owners')
    ->hasAttached($owners, ['main_owner' => true], 'owners')
    ->create();
```
