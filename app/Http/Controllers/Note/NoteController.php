<?php

namespace App\Http\Controllers\Note;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Interfaces\Note\NoteRepositoryInterface;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $note;

    public function __construct(NoteRepositoryInterface $note)
    {
        $this->note = $note;
    }

    public function index()
    {
        return $this->note->getAllNotes();
    }

    public function show($id)
    {
        return $this->note->getNoteById($id);
    }

    public function store(NoteRequest $request)
    {
        return $this->note->createNote($request->validated());
    }

    public function update(NoteRequest $request, $id)
    {
        return $this->note->updateNote($request->validated(), $id);
    }

    public function destroy($id)
    {
        return $this->note->deleteNote($id);
    }
}
