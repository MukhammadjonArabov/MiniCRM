<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with(['customer', 'files', 'manager'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'tickets' => $tickets
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => [
                'nullable',
                'regex:/^\+998\d{9}$/'
            ],
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $validator->validated();

        $customer = Customer::firstOrCreate(
            ['email' => $data['customer_email']],
            [
                'name' => $data['customer_name'],
                'phone' => $data['customer_phone'] ?? null
            ]
        );

        $ticket = Ticket::create([
            'customer_id' => $customer->id,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => 'new',
        ]);

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('tickets_files');

                File::create([
                    'ticket_id' => $ticket->id,
                    'file_name' => $uploadedFile->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $uploadedFile->getClientOriginalExtension(),
                    'file_size' => $uploadedFile->getSize(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Ticket created successfully',
            'ticket_id' => $ticket->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Tiket::with(['customer', 'files', 'manager'])->find($id);

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'ticket' => $ticket
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,in_progress,processed',
            'manager_id' => 'nullable|exists:users,id',
        ]);

        $data = $validator->validated();

        if (isset($data['status'])) {
            $ticket->status = $data['status'];
        }

        if (isset($data['manager_reply'])) {
            $ticket->manager_reply = $data['manager_reply'];
            $ticket->manager_reply_date = now();
            $ticket->manager_id = auth()->id(); 
        }

        $ticket->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket updated successfully',
            'ticket' => $ticket
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found'
            ], 404);
        }
        
        foreach ($ticket->files as $file) {
            if (\Storage::exists($file->file_path)) {
                \Storage::delete($file->file_path);
            }
        }

        $ticket->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket deleted successfully'
        ]);
    }
}

