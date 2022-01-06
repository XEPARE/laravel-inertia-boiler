<?php

namespace App\Actions\Fortify;

use App\Helpers\Traits\AvailableLanguages;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    use AvailableLanguages;

    /**
     * Validate and update the given user's profile information.
     *
     * @param  User $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'sex' => 'nullable|in:MALE,FEMALE,DIVERS',
//            'country' => ['nullable', Rule::in(collect(countries())->map(fn($o) => $o['iso_3166_1_alpha2'])->values())],
            'language' => ['required', Rule::in(collect($this->getAvailableLanguages(true))->keys())],
            'name' => 'required|string|max:255',
            'firstname' => 'nullable|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postcode' => 'nullable|digits:5|numeric',
            'street' => 'nullable|string|max:255',
            'number' => 'nullable|string|max:255',
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $collection = collect($input);
            $user->forceFill([
                'email' => $input['email'],
                'name' => $collection->get('name'),
                'firstname' => $collection->get('firstname'),
                'lastname' => $collection->get('lastname'),
                'city' => $collection->get('city'),
                'postcode' => $collection->get('postcode'),
                'street' => $collection->get('street'),
                'number' => $collection->get('number'),
//                'country' => $collection->get('country'),
                'sex' => $collection->get('sex'),
                'language' => $collection->get('language'),
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }

}
