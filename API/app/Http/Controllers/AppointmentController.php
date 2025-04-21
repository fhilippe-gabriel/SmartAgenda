<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
/**
 * @OA\Tag(
 *     name="Appointments",
 *     description="API Endpoints for Appointment Management"
 * )
 */
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @OA\Get(
     *     path="/api/appointments",
     *     operationId="getAppointmentsList",
     *     tags={"Appointments"},
     *     summary="Get list of appointments",
     *     description="Returns list of appointments for the authenticated user",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="List of appointments"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="client_name", type="string", example="John Doe"),
     *                     @OA\Property(property="service", type="string", example="Haircut"),
     *                     @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *                 )
     *             )
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * 
     * @OA\Post(
     *     path="/api/appointments",
     *     operationId="storeAppointment",
     *     tags={"Appointments"},
     *     summary="Store new appointment",
     *     description="Creates a new appointment and returns it",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_name", "service", "scheduled_at"},
     *             @OA\Property(property="client_name", type="string", example="John Doe"),
     *             @OA\Property(property="service", type="string", example="Haircut"),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appointment created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Appointment created successfully"),
     *             @OA\Property(property="status", type="integer", example=201),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="John Doe"),
     *                 @OA\Property(property="service", type="string", example="Haircut"),
     *                 @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * 
     * @OA\Get(
     *     path="/api/appointments/{id}",
     *     operationId="getAppointmentById",
     *     tags={"Appointments"},
     *     summary="Get appointment information",
     *     description="Returns appointment data",
     *     @OA\Parameter(
     *         name="id",
     *         description="Appointment id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Appointment details"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="client_name", type="string", example="John Doe"),
     *                 @OA\Property(property="service", type="string", example="Haircut"),
     *                 @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * Search for appointments with filters
     * 
     * @OA\Get(
     *     path="/api/appointments/search",
     *     operationId="searchAppointments",
     *     tags={"Appointments"},
     *     summary="Search appointments with filters",
     *     description="Returns filtered appointments",
     *     @OA\Parameter(
     *         name="client_name",
     *         description="Filter by client name",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="service",
     *         description="Filter by service type",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="scheduled_at",
     *         description="Filter by exact date",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             format="date"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         description="Filter by start date",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             format="date"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         description="Filter by end date",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string",
     *             format="date"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Resultados encontrados com base nos filtros aplicados"),
     *             @OA\Property(property="status", type="integer", example=200),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="client_name", type="string", example="John Doe"),
     *                     @OA\Property(property="service", type="string", example="Haircut"),
     *                     @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *                 )
     *             )
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
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
     * 
     * @OA\Put(
     *     path="/api/appointments/{id}",
     *     operationId="updateAppointment",
     *     tags={"Appointments"},
     *     summary="Update existing appointment",
     *     description="Updates an appointment and returns it",
     *     @OA\Parameter(
     *         name="id",
     *         description="Appointment id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"client_name", "service", "scheduled_at"},
     *             @OA\Property(property="client_name", type="string", example="John Doe"),
     *             @OA\Property(property="service", type="string", example="Haircut"),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="client_name", type="string", example="John Doe"),
     *             @OA\Property(property="service", type="string", example="Haircut"),
     *             @OA\Property(property="scheduled_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 10:00:00"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01 10:00:00")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
     * 
     * @OA\Delete(
     *     path="/api/appointments/{id}",
     *     operationId="deleteAppointment",
     *     tags={"Appointments"},
     *     summary="Delete existing appointment",
     *     description="Deletes an appointment and returns a confirmation message",
     *     @OA\Parameter(
     *         name="id",
     *         description="Appointment id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Agendamento excluído com sucesso."),
     *             @OA\Property(property="status", type="integer", example=200)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Agendamento não encontrado."),
     *             @OA\Property(property="status", type="integer", example=404)
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
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
