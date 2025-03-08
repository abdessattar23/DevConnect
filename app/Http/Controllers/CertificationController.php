<?php

namespace App\Http\Controllers;

use App\Models\Certifications;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CertificationController extends Controller
{
  
    public function create()
    {
        return view('profile.certification.add');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'certification_date' => 'nullable|date',
            'certification_link' => 'nullable|string|max:255',
        ]);
        
        Auth::user()->certifications()->create($request->all());
        return redirect()->route('profile.view')->with('success', 'Project created successfully');
    }
      
        public function destroy(Certifications $certification) {
            
            $certification->delete();
            return redirect()->route('profile.view')->with('success', 'Certification deleted successfully');
        }
}
