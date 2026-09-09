<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Trees;

class TreesController extends Controller
{
    // Plantar un arbol
    public function create($user_id, $seed_id)
    {
        $tree = new Trees();

        $tree->user_id = $user_id;
        $tree->seed_id = $seed_id;
        $tree->level = 0;
        $tree->health = 100;
        $tree->progress = 0;
        $tree->status = 'ACTIVE';
        $tree->next_care_at = null;

        $tree->save();

        return "Arbol plantado exitosamente";
    }

    // Mostrar toda la lista de arboles
    public function index()
    {
        $trees = Trees::all();

        return view('trees', compact('trees'));
    }

    // Consulta un arbol por su id
    public function show($id)
    {
        $tree = Trees::find($id);

        return view('tree', compact('tree'));
    }
    
   
}
