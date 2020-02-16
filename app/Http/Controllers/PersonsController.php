<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;

class PersonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$persons = Person::paginate(10);
        $persons = Person::all();

        return view('persons/index', compact('persons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('persons/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //method processes form input (receives the data from the $_POST super global array)
    {
        // dd($request->all());

        // Person::create($request->all());

        Person::create([
            'surname' => $request->surname,
            'first_name'=> $request->first_name,
            'other_names'=> $request->otherNames,
            'gender'=> $request->gender,
            'date_of_birth'=> $request->dateOfBirth,
            'id_number'=> $request->idNumber,
            'primary_msisdn'=> $request->primaryMobileNumber,
            'alternate_msisdn'=> $request->alternateMobileNumber,
            'postal_address'=> $request->postalAddress,
            'physical_location' => $request->physicalLocation
        ]);

        return redirect()->route('persons.index')
                        ->with('success','Person created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        return view('persons.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        // dd($person);
        
        return view('persons.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        $request->validate([
            'surname' => 'nullable',
            'first_name'=> 'nullable',
            'other_names'=> 'nullable',
            'gender'=> 'nullable',
            'date_of_birth'=> 'nullable',
            'id_number'=> 'nullable',
            'primary_msisdn'=> 'nullable',
            'alternate_msisdn'=> 'nullable',
            'postal_address'=> 'nullable',
            'physical_location' => 'nullable',
        ]);
  
        $person->update($request->all());
  
        return redirect()->route('persons.index')
                        ->with('success','Person updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->delete();
  
        return redirect()->route('persons.index')
                        ->with('success','Person deleted successfully');
    }
}
