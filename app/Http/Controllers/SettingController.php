<?php

namespace App\Http\Controllers;

use App\Models\HospitalSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'hospital_name' => HospitalSetting::get('hospital_name', 'St. Jude General Hospital'),
            'hospital_email' => HospitalSetting::get('hospital_email', 'contact@stjudehospital.org'),
            'hospital_phone' => HospitalSetting::get('hospital_phone', '+1 (555) 019-2834'),
            'hospital_address' => HospitalSetting::get('hospital_address', '742 Evergreen Terrace, Medical District, Springfield'),
            'tax_percentage' => HospitalSetting::get('tax_percentage', '5.0'),
            'currency_symbol' => HospitalSetting::get('currency_symbol', '$'),
            'emergency_hotline' => HospitalSetting::get('emergency_hotline', '911 / (555) 019-9999'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hospital_name' => 'required|string|max:255',
            'hospital_email' => 'required|email|max:255',
            'hospital_phone' => 'required|string|max:50',
            'hospital_address' => 'required|string',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'currency_symbol' => 'required|string|max:10',
            'emergency_hotline' => 'required|string|max:50',
        ]);

        foreach ($validated as $key => $val) {
            HospitalSetting::set($key, $val);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Hospital settings updated successfully.');
    }
}
