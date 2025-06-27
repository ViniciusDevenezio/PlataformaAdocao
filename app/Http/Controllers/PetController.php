<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class PetController extends Controller
{
    public function adotar()
    {
           $pets = Pet::all();
             return view('adotar', compact('pets')); // sem 'pets.' antes
    }

    public function show($id)
    {
        $pet = Pet::findOrFail($id);
        return view('pets.show', compact('pet'));
    }
}
