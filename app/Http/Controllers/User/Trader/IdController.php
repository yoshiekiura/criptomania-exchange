<?php

namespace App\Http\Controllers\User\Trader;

use App\Http\Requests\User\IdRequest;
use App\Repositories\User\Interfaces\UserInfoInterface;
use App\Services\Core\FileUploadService;
use App\Services\User\ProfileService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\Interfaces\NotificationInterface;


class IdController extends Controller
{
    public function index()
    {
        $data = app(ProfileService::class)->profile();
        $data['title'] = __('Upload ID');

        return view('backend.uploadID.index', $data);
    }

    public function store(IdRequest $request)
    {
        $attributes = $request->only('id_type');
        $attributes['is_id_verified'] = ID_STATUS_PENDING;

        $uploadedIdFiles = [];

        $notifToAdmin = __("User with :email has been uploaded the verify id card. Check your ID Management", [
                    'email' => Auth::user()->email
                ]);

        foreach($request->allFiles() as $fieldName => $file) {
            $uploadedIdFiles[$fieldName] = app(FileUploadService::class)->upload($file, config('commonconfig.path_id_image'), $fieldName, 'id', Auth::id(), 'public');
        }

        if(!empty($uploadedIdFiles)) {
            $attributes = array_merge($attributes, $uploadedIdFiles);

            if(app(UserInfoInterface::class)->updateByConditions($attributes, ['user_id' => Auth::id(), 'is_id_verified' => ID_STATUS_UNVERIFIED])) {

                 app(NotificationInterface::class)->create([
                'user_id' => 1,
                'data' => $notifToAdmin
                ]);

                 
                return redirect()->back()->with(SERVICE_RESPONSE_SUCCESS, __('ID has been uploaded successfully.'));
            }

        }


        return redirect()->back()->with(SERVICE_RESPONSE_ERROR, __('Failed to upload ID.'));
    }
}