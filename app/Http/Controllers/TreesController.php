<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Trees;

class TreesController extends Controller
{
    // Plantar un arbol
    public function create(Request $request)
    {
        $tree = new Trees();
         $request->validate([
        'seed_id' => ['required', 'integer', 'exists:seeds,id'],
        ]);

        $tree->user_id = $request->user()->id;
        $tree->seed_id = $request->seed_id;
        $tree->level = 0;
        $tree->health = 100;
        $tree->progress = 0;
        $tree->status = 'ACTIVE';
        $tree->next_care_at = null;

        $tree->save();

        return response()->json($tree,201);
    }

    // Mostrar toda la lista de arboles
    public function index(Request $request)
    {
         $trees = Trees::where('user_id', $request->user()->id)->get();

        return response()->json($trees);
    }

    // Consulta un arbol por su id
    public function show(Request $request, $id)
    {
        $tree = Trees::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$tree) {
            return response()->json([], 404);
        }

        return response()->json($tree);
    }

    // Aplicar un cuidado a un arbol
    public function care(Request $request, Trees $tree)
    {
        // 3.1 Autorizacion: si el arbol no es del usuario, responde 403
        $this->authorize('care', $tree);

        // 3.2 Estado terminal: DEAD, MATURE y HARVESTED no se pueden cuidar
        if ($tree->status !== 'ACTIVE') {
            return response()->json([
                'error' => 'El árbol no puede recibir cuidados porque su estado es ' . $tree->status . '.',
                'status' => $tree->status,
            ], 409);
        }

        // 3.3 Cooldown: no se puede cuidar antes de next_care_at
        if ($tree->next_care_at && now()->lt($tree->next_care_at)) {
            return response()->json([
                'error' => 'El árbol se encuentra en período de enfriamiento.',
                'next_care_at' => $tree->next_care_at,
            ], 409);
        }

        // 3.4 Reglas de cuidado y progreso (todo se calcula en el servidor)
        $tree->progress += 1;
        $tree->health = min(100, $tree->health + 20);

        if ($tree->progress >= 5) {
            $tree->level += 1;
            $tree->progress = 0;
        }

        if ($tree->level >= 10) {
            $tree->level = 10;
            $tree->status = 'MATURE';
        }

        $tree->last_cared_at = now();
        $tree->next_care_at = now()->addMinutes(60);
        $tree->save();

        // 4. Respuesta exitosa
        return response()->json([
            'message' => 'Cuidado aplicado con éxito',
            'tree' => [
                'id' => $tree->id,
                'level' => $tree->level,
                'health' => $tree->health,
                'progress' => $tree->progress,
                'status' => $tree->status,
                'next_care_at' => $tree->next_care_at,
            ],
        ], 200);
    }
    
   
}
