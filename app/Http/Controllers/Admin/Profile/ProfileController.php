<?php

namespace App\Http\Controllers\Admin\Profile;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\Profile\ProfileInterface;

class ProfileController extends Controller
{

    private ProfileInterface $profile;

    public function __construct
    (
        ProfileInterface $profile
    )
    {
        $this->profile = $profile;
    }

    public function userProfile(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $response = $this->profile->userProfile();
        return apiResponseFormatter($response);
    }
}
