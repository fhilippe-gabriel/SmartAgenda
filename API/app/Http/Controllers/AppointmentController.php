<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Appointment $appointment)

    // Fetch all appointments
    // You can also use pagination if needed
    // $appointment = Appointment::paginate(10);

    // Return the list of appointments
    {
        $appointment = Appointment::all();

        return ([
            'message' => 'List of appointments',
            'status' => 200,
            'data' => $appointment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'client_name' => 'required|string',
                'service' => 'required|string',
                'scheduled_at' => 'required|date',
            ]
        );

        // Cria um agendamento vinculado ao usuário autenticado
        $appointment = $request->user()->appointments()->create($data);
        // Retorna o agendamento criado
        return response()->json(
            [
                'message' => 'Appointment created successfully',
                'status' => 201,
                'data' => $appointment,
            ]
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Appointment $appointment)
    {
        $appointment = Appointment::findOrFail($id);

        // Return the appointment details

        return response()->json(
            [
                'message' => 'Appointment details',
                'status' => 200,
                'data' => $appointment,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, Appointment $appointment)
    {
        $appointment = Appointment::findOrFail($id);

        // Validate the request data
        $data = $request->validate(
            [
                'client_name' => 'required|string',
                'service' => 'required|string',
                'scheduled_at' => 'required|date',
            ]
        );

        $appointment->update($data);

        return $appointment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Appointment $appointment)
    {
        $appointment = Appointment::findOrFail($id);

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
