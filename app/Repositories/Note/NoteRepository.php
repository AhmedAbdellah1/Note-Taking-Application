<?php

namespace App\Repositories\Note;

use App\Interfaces\Note\NoteRepositoryInterface;
use App\Http\Resources\NoteResource;
use App\Traits\ResponseTrait;
use App\Models\Note;

class NoteRepository implements NoteRepositoryInterface
{
    use ResponseTrait;


    // To retrieve all notes belonging to the authenticated user,
    public function getAllNotes()
    {
        $userId = auth()->id();
        $notes = Note::where('user_id', $userId)->get();

        // OR
        // To retrieve all notes
        // $note = $notes = Note::all();

        return $this->successResponse(NoteResource::collection($notes), 'Notes retrieved successfully');
    }


    // To retrieve single note belonging to the authenticated user,
    public function getNoteById($noteId)
    {
        $note = Note::where('user_id', auth()->id())->find($noteId);

        // OR
        // To retrieve single note not belonging to the authenticated user,
        // $note = Note::find($noteId);

        return $note
            ? $this->successResponse(new NoteResource($note), 'Note retrieved successfully')
            : $this->errorResponse('Note not found', 404);
    }


    // To create a new note
    public function createNote($validatedData)
    {
        $userId = auth()->id();
        $note = Note::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'user_id' => $userId,
        ]);

        return $this->successResponse(new NoteResource($note), 'Note created successfully');
    }


    // To update an existing note belonging to the authenticated user
    public function updateNote($validatedData, $id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);

        // OR
        // To update an existing note not belonging to the authenticated user,
        // $note = Note::find($id);

        if (!$note) {
            return $this->errorResponse('Note not found', 404);
        }

        $note->update($validatedData);

        return $this->successResponse(new NoteResource($note), 'Note updated successfully');
    }


    // To delete an existing note belonging to the authenticated user,
    public function deleteNote($id)
    {
        $note = Note::where('user_id', auth()->id())->find($id);

        // OR
        // To delete an existing note not belonging to the authenticated user,
        // $note = Note::find($id);

        if (!$note) {
            return $this->errorResponse('Note not found', 404);
        }

        $note->delete();

        return $this->successResponse($note, 'Note deleted successfully');
    }
}