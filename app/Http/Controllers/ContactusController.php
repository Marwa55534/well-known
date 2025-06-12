<?php

namespace App\Http\Controllers;

use App\Models\Contactus;
use Illuminate\Http\Request;

class ContactusController extends Controller
{
    //
    public function index(){
        $contact = Contactus::all();
        return $this->formatResponse($contact, 'Data retrieved successfully');
    }
}
