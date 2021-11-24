# Factories
## Use Tinker
```php artisan tinker```

## User Model with Phone Number

```php
\App\Models\User::factory(1)
    ->has(
        \App\Models\Phone::factory()
            ->count(3)
            ->state(new Sequence(
                ['type' => \App\Models\Phone::PHONE_TYPE['MOBILE']],
                ['type' => \App\Models\Phone::PHONE_TYPE['WORK']],
                ['type' => \App\Models\Phone::PHONE_TYPE['HOME']],
            ))
    )->create();
```
