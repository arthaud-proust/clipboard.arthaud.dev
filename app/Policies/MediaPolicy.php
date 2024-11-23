<?php

namespace App\Policies;

use App\Models\User;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Media $media): bool
    {
        return $media->model()->is($user);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Media $media): bool
    {
        return $media->model()->is($user);
    }

    public function delete(User $user, Media $media): bool
    {
        return $media->model()->is($user);
    }

    public function restore(User $user, Media $media): bool
    {
        return $media->model()->is($user);
    }

    public function forceDelete(User $user, Media $media): bool
    {
        return $media->model()->is($user);
    }
}
