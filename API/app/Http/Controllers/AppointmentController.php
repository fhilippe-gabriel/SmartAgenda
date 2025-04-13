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
        $appointment = Appointment::where('user_id', auth()->id())->get();

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

    function search(Request $request)
    {

        $query = Appointment::where('user_id', auth()->id());

        // Filtrar por nome do cliente
        if ($request->filled('client_name')) {
            $query->where('client_name', 'like', '%' . $request->client_name . '%');
        }

        // Filtrar por tipo de serviço
        if ($request->filled('service')) {
            $query->where('service', 'like', '%' . $request->service . '%');
        }

        // Filtrar por data exata
        if ($request->filled('scheduled_at')) {
            $query->whereDate('scheduled_at', $request->scheduled_at);
        }

        // Filtrar por intervalo de datas
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('scheduled_at', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $results = $query->get();

        return response()->json(
            [
                'message' => 'Resultados encontrados com base nos filtros aplicados',
                'status' => 200,
                'data' => $results,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, Appointment $appointment)


    {
        $agendamento = Appointment::where('user_id', auth()->id())->find($id);



        if (! $agendamento) {
            return response()->json([
                'message' => 'Agendamento não encontrado.',
                'status' => 404,
            ]);
        }

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
        $appointment = Appointment::where('user_id', auth()->id())->find($id);

        if (! $appointment) {
            return response()->json([
                'message' => 'Agendamento não encontrado.',
                'status' => 404,
            ]);
        }

        $appointment->delete();

        return response()->json([
            'message' => 'Agendamento excluído com sucesso.',
            'status' => 200,
        ]);
    }
}
