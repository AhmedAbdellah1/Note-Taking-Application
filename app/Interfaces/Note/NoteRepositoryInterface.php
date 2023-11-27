<?php

namespace App\Interfaces\Note;

interface NoteRepositoryInterface
{
    public function getAllNotes();
    public function getNoteById($id);
    public function createNote($request);
    public function updateNote($request, $id);
    public function deleteNote($id);
}
