<?php

namespace User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'home_type' => 'required',
            'room_type' => 'required',
            'total_occupancy' => 'required',
            'total_bedrooms' => 'required',
            'total_bathrooms' => 'required',
            'summary' => 'required|unique:rooms',
            'address' => 'required',
            'has_tv' => 'required',
            'has_kitchen' => 'required',
            'has_air_con' => 'required',
            'has_heating' => 'required',
            'has_internet' => 'required',
            'price' => 'required',
            'published_at' => 'required',
            'owner_id' => 'required|exists:users,id',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }
}
