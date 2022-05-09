<?php

namespace App\Http\Controllers;

use App\Models\ConfigurationModule;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    
    public function index(Request $request)
    {
        $configurations = ConfigurationModule::first();
        return view('backend.pages.configurations.index', compact('configurations'));
    }
    public function create(Request $request)
    {
        $data = $request->validate([
            'stationCode' => 'required', 'apiKey' => 'required', 'apiPath' => 'required'
        ]);

        $configurations = ConfigurationModule::first();

        if($configurations) {
            $configurations->update($data);
            $request->session()->flash('alert-success', 'Configuration Successfully updated');
        }else{
            ConfigurationModule::create($data);
            $request->session()->flash('alert-success', 'Configuration Successfully created');
        }

        return back();
    }
}
