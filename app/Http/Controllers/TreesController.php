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
    
   
}
